<?php 

class Conexao{ 
	public static $instancia;

	private function __construct() { 
		//
	} 

	public static function Instancia() { 
		if (!isset(self::$instancia)) { 
			self::$instancia = new PDO('mysql:host=localhost;dbname=tcc', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			self::$instancia->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING); 
		} 
		return self::$instancia; 
	} 

	public static function jsonExport($name = "file.json"){
		$dados = array();

		$sql = "SELECT idSala, descricao, numero, capacidade FROM sala WHERE ativo = 1 and excluido = 0";
		$p_sql = self::Instancia()->prepare($sql);
		$p_sql->execute();
		$result = $p_sql->fetchAll(PDO::FETCH_ASSOC);
		
		$dados["salas"] = array();
		foreach ($result as $k1 => $v1) {
			$sql = "SELECT SR.Recurso_idRecurso as idRecurso, SR.quantidade FROM Sala_Recurso SR INNER JOIN recurso R ON R.idRecurso = SR.Recurso_idRecurso WHERE SR.Sala_idSala = :sala AND R.ativo = 1 AND R.excluido = 0";
			$p_sql = self::Instancia()->prepare($sql);
			$p_sql->bindValue(":sala", $v1["idSala"]);
			$p_sql->execute();
			$v1["recursos"] = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$sql = "SELECT STA.TempoAula_dia as dia, STA.TempoAula_horario as horario FROM Sala_TempoAula STA WHERE Sala_idSala = :sala";
			$p_sql = self::Instancia()->prepare($sql);
			$p_sql->bindValue(":sala", $v1["idSala"]);
			$p_sql->execute();
			$v1["temposAula"] = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$dados["salas"][] = $v1;
		}

		$sql = "SELECT A.idAgregacao, A.tempos, A.Professor_idProfessor as idProfessor, A.Sala_idSala as idSala FROM agregacao A INNER JOIN aula AU ON AU.Agregacao_idAgregacao = A.idAgregacao WHERE A.excluido = 0 AND AU.excluido = 0 AND AU.ativo = 1";
		$p_sql = self::Instancia()->prepare($sql);
		$p_sql->execute();
		$result = $p_sql->fetchAll(PDO::FETCH_ASSOC);

		$dados["agregacoes"] = array();
		foreach ($result as $k1 => $v1) {
			$sql = "SELECT AR.Recurso_idRecurso as idRecurso, AR.quantidade, AR.flexibilidade FROM Agregacao_Recurso AR INNER JOIN recurso R ON R.idRecurso = AR.Recurso_idRecurso WHERE AR.Agregacao_idAgregacao = :agregacao AND R.ativo = 1 AND R.excluido = 0";
			$p_sql = self::Instancia()->prepare($sql);
			$p_sql->bindValue(":agregacao", $v1["idAgregacao"]);
			$p_sql->execute();
			$v1["recursos"] = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$sql = "SELECT ATA.TempoAula_dia as dia, ATA.TempoAula_horario as horario FROM Agregacao_TempoAula ATA WHERE Agregacao_idAgregacao = :agregacao";
			$p_sql = self::Instancia()->prepare($sql);
			$p_sql->bindValue(":agregacao", $v1["idAgregacao"]);
			$p_sql->execute();
			$v1["temposAula"] = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$sql = "SELECT A.idAula, A.descricao aulaDescricao, T.idTurma, T.descricao turmaDescricao, T.capacidade, T.CursoPreferencial_idCurso as idCursoPreferencial, DC.periodo as periodoCursoPrefencial FROM Aula A 
				INNER JOIN turma T ON t.idTurma = A.Turma_idTurma
				INNER JOIN disciplina D ON D.idDisciplina = T.Disciplina_idDisciplina
				INNER JOIN disciplina_curso DC ON DC.Disciplina_idDisciplina = D.idDisciplina AND DC.Curso_idCurso = T.CursoPreferencial_idCurso
				INNER JOIN curso C ON C.idCurso = T.CursoPreferencial_idCurso
					WHERE A.ativo = 1 AND A.excluido = 0 AND T.ativo = 1 and T.excluido = 0 AND D.excluido = 0 AND D.ativo = 1 and c.ativo = 1 AND C.excluido = 0 AND A.Agregacao_idAgregacao =:agregacao";
			$p_sql = self::Instancia()->prepare($sql);
			$p_sql->bindValue(":agregacao", $v1["idAgregacao"]);
			$p_sql->execute();
			$v1["aulas"] = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$dados["agregacoes"][] = $v1;
		}

		$arquivo = fopen("dados/".$name, "a+");
		fwrite($arquivo, json_encode($dados));
		fclose($arquivo);
	}
} 

?>