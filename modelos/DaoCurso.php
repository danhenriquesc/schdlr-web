<?php 
	require_once("Conexao.php");

	class DaoCurso{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoCurso();

			return self::$instancia;
		}

		public function Inserir(Curso $curso){
			try{
				$sql = "INSERT INTO curso (nome, descricao, Instituto_idInstituto, ativo, excluido) VALUES (:nome, :descricao, :instituto, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $curso->getNome());
				$p_sql->bindValue(":descricao", $curso->getDescricao());
				$p_sql->bindValue(":instituto", $curso->getIdInstituto());
				$p_sql->bindValue(":ativo", $curso->getAtivo());
				$p_sql->bindValue(":excluido", $curso->getExcluido());

				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Curso $curso, $id){
			try{
				$sql = "UPDATE curso SET nome = :nome, descricao = :descricao, Instituto_idInstituto = :instituto  WHERE idCurso=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":nome", $curso->getNome());
				$p_sql->bindValue(":descricao", $curso->getDescricao());
				$p_sql->bindValue(":instituto", $curso->getIdInstituto());
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE curso SET ativo = 1 WHERE idCurso=:id";
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
				$sql = "UPDATE curso SET ativo = 0 WHERE idCurso=:id";
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
				$sql = "UPDATE curso SET excluido = 1 WHERE idCurso=:id";
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
				$sql = "SELECT idCurso, nome, (SELECT nome FROM instituto WHERE idInstituto = curso.Instituto_idInstituto) as instituto, ativo, excluido, ((SELECT count(*) FROM disciplina_curso INNER JOIN disciplina ON disciplina.idDisciplina = disciplina_curso.Disciplina_idDisciplina WHERE disciplina.excluido = 0 and disciplina_curso.Curso_idCurso = curso.idCurso)+(SELECT count(*) FROM turma WHERE turma.excluido = 0 and turma.CursoPreferencial_idCurso = curso.idCurso)) as dependencias FROM curso WHERE excluido = 0";
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
				$sql = "SELECT * FROM curso WHERE excluido = 0 and ativo = 1";
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
				$sql = "SELECT * FROM curso WHERE idCurso = :id";
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

		public function CarregarPorDisciplina($disciplinaId){
			try{
				$sql = "SELECT * FROM curso INNER JOIN disciplina_curso ON curso.idCurso = disciplina_curso.Curso_idCurso WHERE disciplina_curso.Disciplina_idDisciplina = :disciplinaId";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":disciplinaId", $disciplinaId);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}
	}
?>