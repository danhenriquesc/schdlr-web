<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoSala.php");
	require_once("../modelos/Sala.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoSala::Instancia()->Inserir(new Sala($_POST["descricao"], $_POST["capacidade"], $_POST["numero"], $_POST["recursos"], $_POST["tempoAula"]));
				header('Location: '.Manipulador::Instancia()->getDir()."sala/");
				break;
			case 'editar':
				DaoSala::Instancia()->Editar(new Sala($_POST["descricao"], $_POST["capacidade"], $_POST["numero"], $_POST["recursos"], $_POST["tempoAula"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."sala/");
				break;
			case 'ativar':
				DaoSala::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."sala/");
				break;
			case 'desativar':
				DaoSala::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."sala/");
				break;
			case 'excluir':
				DaoSala::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."sala/");
				break;
			default:
				# code...
				break;
		}

	}
?>