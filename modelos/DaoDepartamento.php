<?php 
	require_once("Conexao.php");

	class DaoDepartamento{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoDepartamento();

			return self::$instancia;
		}

		public function Inserir(Departamento $departamento){
			try{
				$sql = "INSERT INTO departamento (nome, Instituto_idInstituto, ativo, excluido) VALUES (:nome, :instituto,, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $departamento->getNome());
				$p_sql->bindValue(":instituto", $departamento->getIdInstituto());
				$p_sql->bindValue(":ativo", $departamento->getAtivo());
				$p_sql->bindValue(":excluido", $departamento->getExcluido());

				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Departamento $departamento, $id){
			try{
				$sql = "UPDATE departamento SET nome = :nome, Instituto_idInstituto = :instituto  WHERE idDepartamento=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $departamento->getNome());
				$p_sql->bindValue(":instituto", $departamento->getIdInstituto());
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE departamento SET ativo = 1 WHERE idDepartamento=:id";
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
				$sql = "UPDATE departamento SET ativo = 0 WHERE idDepartamento=:id";
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
				$sql = "UPDATE departamento SET excluido = 1 WHERE idDepartamento=:id";
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
				$sql = "SELECT idDepartamento,(SELECT nome FROM instituto WHERE idInstituto = departamento.Instituto_idInstituto) as instituto, nome, ativo, excluido, (SELECT count(*) FROM disciplina WHERE disciplina.excluido = 0 and disciplina.Departamento_idDepartamento = departamento.idDepartamento) as dependencias 
							FROM departamento WHERE excluido = 0";
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
				$sql = "SELECT * FROM departamento WHERE excluido = 0 and ativo=1 ORDER BY NOME ASC";
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
				$sql = "SELECT * FROM departamento WHERE idDepartamento = :id";
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