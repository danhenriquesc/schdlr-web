<?php 
	require_once("Conexao.php");

	class DaoDisciplina{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoDisciplina();

			return self::$instancia;
		}

		public function Inserir(Disciplina $disciplina){
			try{
				Conexao::Instancia()->beginTransaction();

				$sql = "INSERT INTO disciplina (nome, codigo, descricao, carga_horaria, Departamento_idDepartamento, ativo, excluido) VALUES (:nome, :codigo, :descricao, :carga_horaria, :departamento_idDepartamento, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":nome", $disciplina->getNome());
				$p_sql->bindValue(":codigo", $disciplina->getCodigo());
				$p_sql->bindValue(":descricao", $disciplina->getDescricao());
				$p_sql->bindValue(":carga_horaria", $disciplina->getCargaHoraria());
				$p_sql->bindValue(":departamento_idDepartamento", $disciplina->getidDepartamento());
				$p_sql->bindValue(":ativo", $disciplina->getAtivo());
				$p_sql->bindValue(":excluido", $disciplina->getExcluido());

				$p_sql->execute();
				$disciplinaID = Conexao::Instancia()->lastInsertId();

				$cursos_periodos = $disciplina->getCursosPeriodos();
				foreach ($disciplina->getCursos() as $indice => $cursoID) {
					$sql = "INSERT INTO disciplina_curso (Disciplina_idDisciplina, Curso_idCurso, periodo) VALUES (:idDisciplina, :idCurso, :periodo)";
					$p_sql = Conexao::Instancia()->prepare($sql);
					$p_sql->bindValue(":idDisciplina", $disciplinaID);
					$p_sql->bindValue(":idCurso", $cursoID);
					$p_sql->bindValue(":periodo", $cursos_periodos[$cursoID]);
					$p_sql->execute();
				}

				return Conexao::Instancia()->commit();

			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Disciplina $disciplina, $id){
			try{
				Conexao::Instancia()->beginTransaction();

				$sql = "UPDATE disciplina SET nome = :nome, codigo = :codigo, descricao = :descricao, carga_horaria = :carga_horaria, Departamento_idDepartamento = :departamento_idDepartamento WHERE idDisciplina = :id";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":nome", $disciplina->getNome());
				$p_sql->bindValue(":codigo", $disciplina->getCodigo());
				$p_sql->bindValue(":descricao", $disciplina->getDescricao());
				$p_sql->bindValue(":carga_horaria", $disciplina->getCargaHoraria());
				$p_sql->bindValue(":departamento_idDepartamento", $disciplina->getidDepartamento());
				$p_sql->bindValue(":id", $id);

				$p_sql->execute();
				$disciplinaID = $id;

				$sql = "DELETE FROM Disciplina_Curso WHERE Disciplina_idDisciplina = :idDisciplina";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idDisciplina", $disciplinaID);
				$p_sql->execute();

				$cursos_periodos = $disciplina->getCursosPeriodos();
				foreach ($disciplina->getCursos() as $indice => $cursoID) {
					$sql = "INSERT INTO disciplina_curso (Disciplina_idDisciplina, Curso_idCurso, periodo) VALUES (:idDisciplina, :idCurso, :periodo)";
					$p_sql = Conexao::Instancia()->prepare($sql);
					$p_sql->bindValue(":idDisciplina", $disciplinaID);
					$p_sql->bindValue(":idCurso", $cursoID);
					$p_sql->bindValue(":periodo", $cursos_periodos[$cursoID]);
					$p_sql->execute();
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
				$sql = "UPDATE disciplina SET ativo = 1 WHERE idDisciplina=:id";
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
				$sql = "UPDATE disciplina SET ativo = 0 WHERE idDisciplina=:id";
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
				$sql = "UPDATE disciplina SET excluido = 1 WHERE idDisciplina=:id";
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
				$sql = "SELECT disciplina.*, departamento.nome as departamento, GROUP_CONCAT(curso.nome SEPARATOR ',<br>') as cursos, (SELECT COUNT(*) FROM turma WHERE turma.Disciplina_idDisciplina = disciplina.idDisciplina and turma.excluido = 0) as turmas FROM disciplina 
							INNER JOIN departamento ON disciplina.Departamento_idDepartamento = departamento.idDepartamento
							INNER JOIN disciplina_curso ON disciplina_curso.Disciplina_idDisciplina = disciplina.idDisciplina
							INNER JOIN curso ON disciplina_curso.Curso_idCurso = curso.idCurso
								WHERE disciplina.excluido = 0
									GROUP BY disciplina.idDisciplina
									ORDER BY disciplina.nome, curso.nome";
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
				$sql = "SELECT * FROM disciplina WHERE excluido = 0 and ativo=1";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarPorDepartamento($idDepartamento, $valores = array("*")){
			try{
				$sql = "SELECT ".implode(",", $valores)." FROM disciplina WHERE excluido = 0 and ativo=1 and Departamento_idDepartamento = :idDepartamento";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idDepartamento", $idDepartamento);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function CarregarPorId($id){
			try{
				$sql = "SELECT * FROM disciplina WHERE idDisciplina = :id";
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