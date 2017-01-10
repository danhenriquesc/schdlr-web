<?php 
	require_once("modelos/DaoRecurso.php");
	$dados = DaoRecurso::Instancia()->Listar();
?>

<div class="row">
	<div class="col-md-10">
		<h1>Recursos</h1>
	</div>
	<div class="col-md-2">
		<a href="<?php echo Manipulador::Instancia()->getDir(); ?>recurso/adicionar"><button type="button" class="btn btn-success pull-right add-button">Adicionar Novo</button></a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php if(sizeof($dados) > 0){ ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
				    <thead>
				    	<tr>
				    		<th>Descrição</th>
				    		<th width="7%">Status</th>
				    		<th width="20%">Ações</th>
				    	</tr>
				    </thead>
				    <tbody>
				    	<?php foreach($dados as $key=>$value){ ?>
							<tr>
					    		<td><?php echo $value["descricao"]; ?></td>
					    		<td><?php echo ($value["ativo"]?"Ativo":"Inativo"); ?></td>
					    		<td><a href="<?php echo Manipulador::Instancia()->getDir()."recurso/editar/".$value["idRecurso"]; ?>">Editar</a> <a href="<?php echo Manipulador::getDir(); ?>controles/recurso.php?acao=<?php echo ($value["ativo"]?"desativar":"ativar"); ?>&id=<?php echo $value["idRecurso"]; ?>"><?php echo ($value["ativo"]?"Desativar":"Ativar"); ?></a> <?php if ($value["dependencias"] == 0) { ?> <a href="#" onclick="abrirModal('#modal-<?php echo $value["idRecurso"]; ?>')">Excluir</a> <?php } ?></td>
					    	</tr>

					    	<div class="modal fade" id="modal-<?php echo $value["idRecurso"]; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-label-<?php echo $value["idRecurso"]; ?>">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Você está certo disso?</h4>
							      </div>
							      <div class="modal-body">
							       	Você deseja mesmo excluir o recurso: <b><?php echo $value["descricao"]; ?></b>? A exclusão não poderá ser revertida.
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
							        <a href="<?php echo Manipulador::getDir(); ?>controles/recurso.php?acao=excluir&id=<?php echo $value["idRecurso"]; ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
							      </div>
							    </div>
							  </div>
							</div>
				    	<?php } ?>
				    </tbody>
				</table>
		</div>
		<?php } else { ?>
			<p>Não há dados a serem exibidos</p>
		<?php } ?>
	</div>
</div>