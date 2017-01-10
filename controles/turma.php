<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoTurma.php");
	require_once("../modelos/Turma.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoTurma::Instancia()->Inserir(new Turma($_POST["descricao"], $_POST["capacidade"], $_POST["idDisciplina"], $_POST["cursopreferencial"]));
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/".$_POST["idDisciplina"]."/turma/");
				break;
			case 'editar':
				DaoTurma::Instancia()->Editar(new Turma($_POST["descricao"], $_POST["capacidade"], $_POST["idDisciplina"], $_POST["cursopreferencial"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/".$_POST["idDisciplina"]."/turma/");
				break;
			case 'ativar':
				DaoTurma::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/".$_GET["idDisciplina"]."/turma/");
				break;
			case 'desativar':
				DaoTurma::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/".$_GET["idDisciplina"]."/turma/");
				break;
			case 'excluir':
				DaoTurma::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/".$_GET["idDisciplina"]."/turma/");
				break;
			default:
				# code...
				break;
		}

	}
?>