<h1>Adicionar Instituto</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/instituto.php?acao=adicionar" class="form-validate">
	<div class="form-group">
    	<label for="nome">Nome</label>
    	<input type="text" name="nome" class="form-control" id="nome" minlength="5" required>
  	</div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>instituto/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>