<?php 
	require_once("Conexao.php");

	class DaoInstituto{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoInstituto();

			return self::$instancia;
		}

		public function Inserir(Instituto $instituto){
			try{
				$sql = "INSERT INTO instituto (nome, ativo, excluido) VALUES (:nome, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $instituto->getNome());
				$p_sql->bindValue(":ativo", $instituto->getAtivo());
				$p_sql->bindValue(":excluido", $instituto->getExcluido());

				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Instituto $instituto, $id){
			try{
				$sql = "UPDATE instituto SET nome = :nome WHERE idInstituto=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $instituto->getNome());
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE instituto SET ativo = 1 WHERE idInstituto=:id";
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
				$sql = "UPDATE instituto SET ativo = 0 WHERE idInstituto=:id";
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
				$sql = "UPDATE instituto SET excluido = 1 WHERE idInstituto=:id";
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
				$sql = "SELECT idInstituto, nome, ativo, excluido, ((SELECT count(*) FROM curso WHERE curso.excluido = 0 and curso.Instituto_idInstituto = instituto.idInstituto)+(SELECT count(*) FROM departamento WHERE departamento.excluido = 0 and departamento.Instituto_idInstituto = instituto.idInstituto)+(SELECT count(*) FROM professor WHERE professor.excluido = 0 and professor.Instituto_idInstituto = instituto.idInstituto)) as dependencias FROM instituto 
WHERE excluido = 0";
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
				$sql = "SELECT * FROM instituto WHERE excluido = 0 and ativo=1 ORDER BY NOME ASC";
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
				$sql = "SELECT * FROM instituto WHERE idInstituto = :id";
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
	}
?>