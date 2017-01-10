<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoInstituto.php");
	require_once("../modelos/Instituto.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoInstituto::Instancia()->Inserir(new Instituto($_POST["nome"]));
				header('Location: '.Manipulador::Instancia()->getDir()."instituto/");
				break;
			case 'editar':
				DaoInstituto::Instancia()->Editar(new Instituto($_POST["nome"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."instituto/");
				break;
			case 'ativar':
				DaoInstituto::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."instituto/");
				break;
			case 'desativar':
				DaoInstituto::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."instituto/");
				break;
			case 'excluir':
				DaoInstituto::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."instituto/");
				break;
			default:
				# code...
				break;
		}

	}
?>