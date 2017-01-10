<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoAula.php");
	require_once("../modelos/Aula.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoAula::Instancia()->Inserir(new Aula($_POST["descricao"], $_POST["comentarios"], $_POST["tempos"], $_POST["idTurma"], $_POST["recursos"], $_POST["tempoAula"], $_POST["idProfessor"], $_POST["idSala"]));
				header('Location: '.Manipulador::Instancia()->getDir()."turma/".$_POST["idTurma"]."/aula/");
				break;
			case 'agregar':
				DaoAula::Instancia()->Agregar(new Aula($_POST["descricao"], $_POST["comentarios"], 0, $_POST["idTurma"], 0, 0,0, 0, $_POST["idAgregacao"]));
				header('Location: '.Manipulador::Instancia()->getDir()."turma/".$_POST["idTurma"]."/aula/");
				break;
			case 'editar':
				DaoAula::Instancia()->Editar(new Aula($_POST["descricao"], $_POST["comentarios"], $_POST["tempos"], $_POST["idTurma"], $_POST["recursos"], $_POST["tempoAula"], $_POST["idProfessor"], $_POST["idSala"], $_POST["idAgregacao"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."turma/".$_POST["idTurma"]."/aula/");
				break;
			case 'ativar':
				DaoAula::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."turma/".$_GET["idTurma"]."/aula/");
				break;
			case 'desativar':
				DaoAula::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."turma/".$_GET["idTurma"]."/aula/");
				break;
			case 'excluir':
				DaoAula::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."turma/".$_GET["idTurma"]."/aula/");
				break;
			default:
				# code...
				break;
		}

	}
?>