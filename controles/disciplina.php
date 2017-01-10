<?php 
	require_once("Manipulador.php");	
	require_once("../modelos/DaoDisciplina.php");
	require_once("../modelos/Disciplina.php");

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];

		switch ($acao) {
			case 'adicionar':
				DaoDisciplina::Instancia()->Inserir(new Disciplina($_POST["nome"], $_POST["codigo"], $_POST["descricao"], $_POST["carga_horaria"], $_POST["departamento"], $_POST["cursos"],$_POST["cursos_periodo"]));
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/");
				break;
			case 'editar':
				DaoDisciplina::Instancia()->Editar(new Disciplina($_POST["nome"], $_POST["codigo"], $_POST["descricao"], $_POST["carga_horaria"], $_POST["departamento"], $_POST["cursos"],$_POST["cursos_periodo"]), $_POST['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/");
				break;
			case 'ativar':
				DaoDisciplina::Instancia()->Ativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/");
				break;
			case 'desativar':
				DaoDisciplina::Instancia()->Desativar($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/");
				break;
			case 'excluir':
				DaoDisciplina::Instancia()->Excluir($_GET['id']);
				header('Location: '.Manipulador::Instancia()->getDir()."disciplina/");
				break;
			default:
				# code...
				break;
		}

	}
?>