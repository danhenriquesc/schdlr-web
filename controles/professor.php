<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoProfessor.php");
	require_once("../modelos/Professor.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoProfessor::Instancia()->Inserir(new Professor($_POST["nome"], $_POST["instituto"]));
				header('Location: '.Manipulador::Instancia()->getDir()."professor/");
				break;
			case 'editar':
				DaoProfessor::Instancia()->Editar(new Professor($_POST["nome"], $_POST["instituto"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."professor/");
				break;
			case 'ativar':
				DaoProfessor::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."professor/");
				break;
			case 'desativar':
				DaoProfessor::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."professor/");
				break;
			case 'excluir':
				DaoProfessor::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."professor/");
				break;
			default:
				# code...
				break;
		}

	}
?>