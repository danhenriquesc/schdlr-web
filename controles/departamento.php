<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoDepartamento.php");
	require_once("../modelos/Departamento.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoDepartamento::Instancia()->Inserir(new Departamento($_POST["nome"], $_POST["instituto"]));
				header('Location: '.Manipulador::Instancia()->getDir()."departamento/");
				break;
			case 'editar':
				DaoDepartamento::Instancia()->Editar(new Departamento($_POST["nome"], $_POST["instituto"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."departamento/");
				break;
			case 'ativar':
				DaoDepartamento::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."departamento/");
				break;
			case 'desativar':
				DaoDepartamento::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."departamento/");
				break;
			case 'excluir':
				DaoDepartamento::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."departamento/");
				break;
			default:
				# code...
				break;
		}

	}
?>