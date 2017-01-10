<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoRecurso.php");
	require_once("../modelos/Recurso.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoRecurso::Instancia()->Inserir(new Recurso($_POST["descricao"]));
				header('Location: '.Manipulador::Instancia()->getDir()."recurso/");
				break;
			case 'editar':
				DaoRecurso::Instancia()->Editar(new Recurso($_POST["descricao"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."recurso/");
				break;
			case 'ativar':
				DaoRecurso::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."recurso/");
				break;
			case 'desativar':
				DaoRecurso::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."recurso/");
				break;
			case 'excluir':
				DaoRecurso::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."recurso/");
				break;
			default:
				# code...
				break;
		}

	}
?>