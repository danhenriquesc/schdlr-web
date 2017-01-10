<?php 
	require_once("modelos/Curso.php");
	require_once("modelos/DaoCurso.php");
	require_once("controles/Manipulador.php");

	Manipulador::Instancia()->Cabecalho();
	Manipulador::Instancia()->Menu();
	Manipulador::Instancia()->Conteudo();
	Manipulador::Instancia()->Rodape();
?>