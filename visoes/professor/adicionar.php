<?php
	require_once("modelos/DaoInstituto.php");
	$institutos = DaoInstituto::Instancia()->ListarAtivos();
?>

<h1>Adicionar Professor</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/professor.php?acao=adicionar" class="form-validate">
	<div class="form-group">
    	<label for="nome">Nome</label>
    	<input type="text" name="nome" class="form-control" id="nome" minlength="5" required>
  	</div>
  	<div class="form-group">
    	<label for="instituto">Instituto</label>
    	<select name="instituto" class="form-control" id="instituto" required>
			<?php foreach ($institutos as $key => $value) { ?>
			  <option value="<?php echo $value["idInstituto"]; ?>"><?php echo $value["nome"]; ?></option>
			<?php } ?>
		</select>
	</div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>professor/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>