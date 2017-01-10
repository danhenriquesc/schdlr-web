<?php 
	require_once("Conexao.php");

	class DaoTurma{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoTurma();

			return self::$instancia;
		}

		public function Inserir(Turma $turma){
			try{
				//Salvando Informações
				$sql = "INSERT INTO turma (descricao, capacidade, Disciplina_idDisciplina, CursoPreferencial_idCurso, ativo, excluido) VALUES (:descricao, :capacidade, :idDisciplina, :idCurso, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":descricao", $turma->getDescricao());
				$p_sql->bindValue(":capacidade", $turma->getCapacidade());
				$p_sql->bindValue(":idDisciplina", $turma->getIdDisciplina());
				$p_sql->bindValue(":idCurso", $turma->getCursoPreferencial());
				$p_sql->bindValue(":ativo", $turma->getAtivo());
				$p_sql->bindValue(":excluido", $turma->getExcluido());

				return $p_sql->execute();
			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Turma $turma, $id){
			try{
				//Salvando Informações
				$sql = "UPDATE turma SET descricao = :descricao, capacidade = :capacidade, CursoPreferencial_idCurso = :idCurso WHERE idTurma = :id";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":descricao", $turma->getDescricao());
				$p_sql->bindValue(":capacidade", $turma->getCapacidade());
				$p_sql->bindValue(":idCurso", $turma->getCursoPreferencial());
				$p_sql->bindValue(":id", $id);

				return $p_sql->execute();
			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE turma SET ativo = 1 WHERE idTurma=:id";
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
				$sql = "UPDATE turma SET ativo = 0 WHERE idTurma=:id";
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
				$sql = "UPDATE turma SET excluido = 1 WHERE idTurma=:id";
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
				$sql = "SELECT * FROM turma WHERE excluido = 0";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarPorDisciplina($idDisciplina, $valores = array("*")){
			try{
				$sql = "SELECT ".implode(',',$valores).", (SELECT COUNT(*) FROM aula WHERE aula.Turma_idTurma = turma.idTurma and aula.excluido = 0) as aulas FROM turma WHERE excluido = 0 and Disciplina_idDisciplina = :idDisciplina";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idDisciplina", $idDisciplina);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarAtivos(){
			try{
				$sql = "SELECT * FROM turma WHERE excluido = 0 and ativo=1";
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
				$sql = "SELECT turma.idTurma, turma.CursoPreferencial_idCurso, turma.descricao, turma.Disciplina_idDisciplina, turma.capacidade, turma.ativo, turma.excluido, disciplina.nome as disciplina FROM turma 
							INNER JOIN disciplina ON turma.Disciplina_idDisciplina = disciplina.idDisciplina 
								WHERE turma.idTurma = :id";
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