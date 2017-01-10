<?php 
	require_once("Conexao.php");

	class DaoSala{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoSala();

			return self::$instancia;
		}

		public function Inserir(Sala $sala){
			try{
				Conexao::Instancia()->beginTransaction();

				//Salvando Informações
				$sql = "INSERT INTO sala (descricao, capacidade, numero, ativo, excluido) VALUES (:descricao, :capacidade, :numero, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":descricao", $sala->getDescricao());
				$p_sql->bindValue(":capacidade", $sala->getCapacidade());
				$p_sql->bindValue(":numero", $sala->getNumero());
				$p_sql->bindValue(":ativo", $sala->getAtivo());
				$p_sql->bindValue(":excluido", $sala->getExcluido());

				$p_sql->execute();
				$salaID = Conexao::Instancia()->lastInsertId();

				//Salvando Recursos
				foreach ($sala->getRecursos() as $indice => $values) {
					if(isset($values['ativo']) && $values['ativo'] == "1"){
						$sql = "INSERT INTO sala_recurso (Sala_idSala, Recurso_idRecurso, quantidade) VALUES (:idSala, :idRecurso, :quantidade)";
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idSala", $salaID);
						$p_sql->bindValue(":idRecurso", $indice);
						$p_sql->bindValue(":quantidade", $values['quantidade']);
						$p_sql->execute();
					}
				}

				//Salvando Horários
				foreach ($sala->getTempoAula() as $horario => $value) {
					if($value == "1"){
						$sql = "INSERT INTO sala_tempoaula (Sala_idSala, TempoAula_dia, TempoAula_horario) VALUES (:idSala, :dia, :horario)";
						list($dia, $tempo) = explode("-", $horario);
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idSala", $salaID);
						$p_sql->bindValue(":dia", $dia);
						$p_sql->bindValue(":horario", $tempo);
						$p_sql->execute();
					}
				}

				return Conexao::Instancia()->commit();

			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Sala $sala, $id){
			try{
				Conexao::Instancia()->beginTransaction();

				//Salvando Informações
				$sql = "UPDATE sala SET descricao = :descricao, capacidade = :capacidade, numero = :numero WHERE idSala = :id";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":descricao", $sala->getDescricao());
				$p_sql->bindValue(":capacidade", $sala->getCapacidade());
				$p_sql->bindValue(":numero", $sala->getNumero());
				$p_sql->bindValue(":id", $id);

				$p_sql->execute();
				$salaID = $id;

				//Atualizando Recursos
				$sql = "DELETE FROM sala_recurso WHERE Sala_idSala = :idSala";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idSala", $salaID);
				$p_sql->execute();

				foreach ($sala->getRecursos() as $indice => $values) {
					if(isset($values['ativo']) && $values['ativo'] == "1"){
						$sql = "INSERT INTO sala_recurso (Sala_idSala, Recurso_idRecurso, quantidade) VALUES (:idSala, :idRecurso, :quantidade)";
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idSala", $salaID);
						$p_sql->bindValue(":idRecurso", $indice);
						$p_sql->bindValue(":quantidade", $values['quantidade']);
						$p_sql->execute();
					}
				}

				//Atualizando Horarios
				$sql = "DELETE FROM sala_tempoaula WHERE Sala_idSala = :idSala";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idSala", $salaID);
				$p_sql->execute();

				foreach ($sala->getTempoAula() as $horario => $value) {
					if($value == "1"){
						$sql = "INSERT INTO sala_tempoaula (Sala_idSala, TempoAula_dia, TempoAula_horario) VALUES (:idSala, :dia, :horario)";
						list($dia, $tempo) = explode("-", $horario);
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idSala", $salaID);
						$p_sql->bindValue(":dia", $dia);
						$p_sql->bindValue(":horario", $tempo);
						$p_sql->execute();
					}
				}

				return Conexao::Instancia()->commit();

			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE sala SET ativo = 1 WHERE idSala=:id";
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
				$sql = "UPDATE sala SET ativo = 0 WHERE idSala=:id";
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
				$sql = "UPDATE sala SET excluido = 1 WHERE idSala=:id";
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
				$sql = "SELECT * FROM sala WHERE excluido = 0";
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
				$sql = "SELECT * FROM sala WHERE excluido = 0 and ativo=1";
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
				$sql = "SELECT * FROM sala WHERE idSala = :id";
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