<?php 
	if(!isset($_GET['id']) || trim($_GET['id']) == "") header("location: ".Manipulador::getDir()."curso");

	$id = $_GET['id'];
	require_once("modelos/DaoCurso.php");

  require_once("modelos/DaoInstituto.php");
  $institutos = DaoInstituto::Instancia()->ListarAtivos();

	$dados = DaoCurso::Instancia()->CarregarPorId($id);
	if(!$dados) header("location: ".Manipulador::getDir()."curso");
?>

<h1>Editar Curso</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/curso.php?acao=editar" class="form-validate">
	<div class="form-group">
    	<label for="nome">Nome</label>
    	<input type="text" name="nome" class="form-control" id="nome" minlength="5" required value="<?php echo $dados['nome']; ?>">
    	<input type="hidden" name="id" value="<?php echo $id; ?>">
  	</div>
    <div class="form-group">
      <label for="descricao">Descrição</label>
      <input type="text" name="descricao" class="form-control" id="descricao" value="<?php echo $dados['descricao']; ?>">
    </div>
    <div class="form-group">
      <label for="instituto">Instituto</label>
      <select name="instituto" class="form-control" id="instituto" required>
        <?php foreach ($institutos as $key => $value) { ?>
          <option value="<?php echo $value["idInstituto"]; ?>" <?php echo (($dados['Instituto_idInstituto']==$value["idInstituto"])?"selected":""); ?>><?php echo $value["nome"]; ?></option>
        <?php } ?>
      </select>
    </div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>curso/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>