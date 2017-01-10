<?php 
	switch ($_POST['acao']) {
		case 'departamento':

			require_once("../modelos/DaoDisciplina.php");
			$disciplinas = DaoDisciplina::Instancia()->ListarPorDepartamento($_POST['idDepartamento'], array("idDisciplina", "codigo", "nome"));

			$retorno = '';

			if(sizeof($disciplinas) == 0){
				$retorno = '<option value="">Não existem disciplinas neste departamento</option>';
			}else{
				$retorno = '<option value="">Selecione</option>';
				foreach ($disciplinas as $key => $value) {
					$retorno .= '<option value="'.$value["idDisciplina"].'">'.$value["codigo"].' '.$value["nome"].'</option>';
				}
			}

			echo $retorno;
			break;
		
		case 'disciplina':

			require_once("../modelos/DaoTurma.php");
			$turmas = DaoTurma::Instancia()->ListarPorDisciplina($_POST['idDisciplina'], array("idTurma", "descricao"));

			$retorno = '';

			if(sizeof($turmas) == 0){
				$retorno = '<option value="">Não existem turmas nesta disciplina</option>';
			}else{
				$retorno = '<option value="">Selecione</option>';
				foreach ($turmas as $key => $value) {
					$retorno .= '<option value="'.$value["idTurma"].'">'.$value["descricao"].'</option>';
				}
			}

			echo $retorno;
			break;

		case 'turma':

			require_once("../modelos/DaoAula.php");
			$aulas = DaoAula::Instancia()->ListarPorTurma($_POST['idTurma']);

			$retorno = '';

			if(sizeof($aulas) == 0){
				$retorno = '<option value="">Não existem aulas nesta turma</option>';
			}else{
				$retorno = '<option value="">Selecione</option>';
				foreach ($aulas as $key => $value) {
					$retorno .= '<option value="'.$value["idAula"].'">'.$value["descricao"].'</option>';
				}
			}

			echo $retorno;
			break;

		case 'aula':

			require_once("../modelos/DaoRecurso.php");
			require_once("../modelos/DaoTempoAula.php");
			require_once("../modelos/DaoAula.php");
			
			$dados = DaoAula::Instancia()->CarregarPorId($_POST["idAula"]);
			$recursosAula = DaoRecurso::Instancia()->CarregarPorAgregacao($dados["idAgregacao"]);
			$tempoAulas = DaoTempoAula::Instancia()->CarregarPorAgregacao($dados["idAgregacao"], $dados["tempos"]);
			$agregacoes = DaoAula::Instancia()->ListarPorAgregacao($dados["idAgregacao"]);
			$agregacoes = json_encode($agregacoes);

			$idAgregacao = $dados["idAgregacao"];

			$recursos = "";

			if(sizeof($recursosAula) > 0){
				foreach ($recursosAula as $key => $value) {
					$recursos .= "<tr><td>".$value["descricao"]."</td><td>".$value["quantidade"]."</td><td>".DaoRecurso::Instancia()->MapearFlexibilidade($value["flexibilidade"])."</td></tr>";
				}
			}else{
				$recursos = "<tr><td colspan='3' align='center'>Não há recursos solicitados para esta agregação</td></tr>";
			}

			$aulas = json_encode($tempoAulas);

			echo $idAgregacao."|||".$recursos."|||".$aulas."|||".$agregacoes."|||".$dados["tempos"];

			break;

		default:
			# code...
			break;
	}
	
?>