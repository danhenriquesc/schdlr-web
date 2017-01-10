<h1>Adicionar Recurso</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/recurso.php?acao=adicionar" class="form-validate">
	<div class="form-group">
    	<label for="descricao">Descrição</label>
    	<input type="text" name="descricao" class="form-control" id="descricao" minlength="5" required>
  	</div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>recurso/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>