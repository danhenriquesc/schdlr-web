<?php 
	if(!isset($_GET['id']) || trim($_GET['id']) == "") header("location: ".Manipulador::getDir()."instituto");

	$id = $_GET['id'];
	require_once("modelos/DaoInstituto.php");

	$dados = DaoInstituto::Instancia()->CarregarPorId($id);
	if(!$dados) header("location: ".Manipulador::getDir()."instituto");
?>

<h1>Editar Instituto</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/instituto.php?acao=editar" class="form-validate">
	<div class="form-group">
    	<label for="nome">Nome</label>
    	<input type="text" name="nome" class="form-control" id="nome" minlength="5" required value="<?php echo $dados['nome']; ?>">
    	<input type="hidden" name="id" value="<?php echo $id; ?>">
  	</div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>instituto/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>