<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoCurso.php");
	require_once("../modelos/Curso.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoCurso::Instancia()->Inserir(new Curso($_POST["nome"], $_POST["descricao"], $_POST["instituto"]));
				header('Location: '.Manipulador::Instancia()->getDir()."curso/");
				break;
			case 'editar':
				DaoCurso::Instancia()->Editar(new Curso($_POST["nome"], $_POST["descricao"], $_POST["instituto"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."curso/");
				break;
			case 'ativar':
				DaoCurso::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."curso/");
				break;
			case 'desativar':
				DaoCurso::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."curso/");
				break;
			case 'excluir':
				DaoCurso::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."curso/");
				break;
			default:
				# code...
				break;
		}

	}
?>