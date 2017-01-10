<?php 
	require_once("Conexao.php");

	class DaoRecurso{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoRecurso();

			return self::$instancia;
		}

		public function Inserir(Recurso $recurso){
			try{
				$sql = "INSERT INTO recurso (descricao, ativo, excluido) VALUES (:descricao, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":descricao", $recurso->getDescricao());
				$p_sql->bindValue(":ativo", $recurso->getAtivo());
				$p_sql->bindValue(":excluido", $recurso->getExcluido());

				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Recurso $recurso, $id){
			try{
				$sql = "UPDATE recurso SET descricao = :descricao WHERE idRecurso=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":descricao", $recurso->getDescricao());
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE recurso SET ativo = 1 WHERE idRecurso=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Desativar($id){
			try{
				$sql = "UPDATE recurso SET ativo = 0 WHERE idRecurso=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Excluir($id){
			try{
				$sql = "UPDATE recurso SET excluido = 1 WHERE idRecurso=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Listar(){
			try{
				$sql = "SELECT idRecurso, descricao, ativo, excluido,
					( (SELECT count(*) FROM sala_recurso INNER JOIN sala ON sala.idSala = sala_recurso.Sala_idSala WHERE sala.excluido = 0 and sala_recurso.Recurso_idRecurso = recurso.idRecurso) + (SELECT count(*) FROM agregacao_recurso INNER JOIN agregacao ON agregacao.idAgregacao = agregacao_recurso.Agregacao_idAgregacao WHERE agregacao.excluido = 0 and agregacao_recurso.Recurso_idRecurso = recurso.idRecurso)) as dependencias
						FROM recurso WHERE excluido = 0";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarAtivos(){
			try{
				$sql = "SELECT * FROM recurso WHERE excluido = 0 and ativo=1";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function CarregarPorId($id){
			try{
				$sql = "SELECT * FROM recurso WHERE idRecurso = :id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				$p_sql->execute();
				$ar = $p_sql->fetchAll();
				if(sizeof($ar) >= 1)
					return $ar[0];
				else
					return false;
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function CarregarPorSala($salaId){
			try{
				$sql = "SELECT * FROM recurso INNER JOIN sala_recurso ON recurso.idRecurso = sala_recurso.Recurso_idRecurso WHERE sala_recurso.Sala_idSala = :salaId";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":salaId", $salaId);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function CarregarPorAgregacao($agregacaoId){
			try{
				$sql = "SELECT * FROM recurso INNER JOIN agregacao_recurso ON recurso.idRecurso = agregacao_recurso.Recurso_idRecurso WHERE agregacao_recurso.Agregacao_idAgregacao = :agregacaoId";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":agregacaoId", $agregacaoId);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function MapearFlexibilidade($flexibilidade){
			switch ($flexibilidade) {
				case '4':
					return "Obrigatório";
					break;
				case '3':
					return "Altamente Necessário";
					break;
				case '2':
					return "Necessário";
					break;
				case '1':
					return "Dispensável";
					break;
				default:
					# code...
					break;
			}
		}
	}
?>