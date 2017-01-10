<?php 
	require_once("Conexao.php");

	class DaoProfessor{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoProfessor();

			return self::$instancia;
		}

		public function Inserir(Professor $professor){
			try{
				$sql = "INSERT INTO professor (nome, Instituto_idInstituto, ativo, excluido) VALUES (:nome, :instituto,:ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $professor->getNome());
				$p_sql->bindValue(":instituto", $professor->getIdInstituto());
				$p_sql->bindValue(":ativo", $professor->getAtivo());
				$p_sql->bindValue(":excluido", $professor->getExcluido());

				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Professor $professor, $id){
			try{
				$sql = "UPDATE professor SET nome = :nome, Instituto_idInstituto = :instituto  WHERE idProfessor=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $professor->getNome());
				$p_sql->bindValue(":instituto", $professor->getIdInstituto());
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE professor SET ativo = 1 WHERE idProfessor=:id";
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
				$sql = "UPDATE professor SET ativo = 0 WHERE idProfessor=:id";
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
				$sql = "UPDATE professor SET excluido = 1 WHERE idProfessor=:id";
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
				$sql = "SELECT idProfessor,(SELECT nome FROM instituto WHERE idInstituto = professor.Instituto_idInstituto) as instituto, nome, ativo, excluido, (SELECT count(*) FROM agregacao WHERE agregacao.excluido = 0 and agregacao.Professor_idProfessor = professor.idProfessor) as dependencias 
							FROM professor WHERE excluido = 0";
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
				$sql = "SELECT * FROM professor WHERE excluido = 0 and ativo=1 ORDER BY NOME ASC";
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
				$sql = "SELECT * FROM professor WHERE idProfessor = :id";
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