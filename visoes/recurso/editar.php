<?php 
	if(!isset($_GET['id']) || trim($_GET['id']) == "") header("location: ".Manipulador::getDir()."recurso");

	$id = $_GET['id'];
	require_once("modelos/DaoRecurso.php");

	$dados = DaoRecurso::Instancia()->CarregarPorId($id);
	if(!$dados) header("location: ".Manipulador::getDir()."recurso");
?>

<h1>Editar Recurso</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/recurso.php?acao=editar" class="form-validate">
	<div class="form-group">
    	<label for="descricao">Descrição</label>
    	<input type="text" name="descricao" class="form-control" id="descricao" minlength="5" required value="<?php echo $dados['descricao']; ?>">
    	<input type="hidden" name="id" value="<?php echo $id; ?>">
  	</div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>recurso/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>