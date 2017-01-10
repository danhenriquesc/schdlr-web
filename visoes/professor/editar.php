<?php 
	if(!isset($_GET['id']) || trim($_GET['id']) == "") header("location: ".Manipulador::getDir()."professor");

	$id = $_GET['id'];
	require_once("modelos/DaoProfessor.php");

  require_once("modelos/DaoInstituto.php");
  $institutos = DaoInstituto::Instancia()->ListarAtivos();

	$dados = DaoProfessor::Instancia()->CarregarPorId($id);
	if(!$dados) header("location: ".Manipulador::getDir()."professor");
?>

<h1>Editar Professor</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/professor.php?acao=editar" class="form-validate">
	<div class="form-group">
    	<label for="nome">Nome</label>
    	<input type="text" name="nome" class="form-control" id="nome" minlength="5" required value="<?php echo $dados['nome']; ?>">
    	<input type="hidden" name="id" value="<?php echo $id; ?>">
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
  	<a href="<?php echo Manipulador::getDir(); ?>professor/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>