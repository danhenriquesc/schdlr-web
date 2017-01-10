<?php 
	$idTurma = $_GET['acao'];

	require_once("modelos/DaoAula.php");
	require_once("modelos/DaoTurma.php");

	$dados = DaoAula::Instancia()->ListarPorTurma($idTurma);
	$turma = DaoTurma::Instancia()->CarregarPorId($idTurma);
?>

<div class="row">
	<div class="col-md-8">
		<h1>[<?php echo $turma["disciplina"]." - ".$turma["descricao"]; ?>] Aulas</h1>
	</div>
	<div class="col-md-4">
		<a href="<?php echo Manipulador::Instancia()->getDir(); ?>turma/<?php echo $idTurma; ?>/aula/agregar"><button type="button" class="btn btn-success pull-right add-button">Agregar Existente</button></a>
		<a href="<?php echo Manipulador::Instancia()->getDir(); ?>turma/<?php echo $idTurma; ?>/aula/adicionar"><button type="button" class="btn btn-success pull-right add-button" style="margin-right:5px;">Adicionar Nova</button></a>
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
				    		<th>Tempos</th>
				    		<th>Agregações</th>
				    		<th width="7%">Status</th>
				    		<th width="20%">Ações</th>
				    	</tr>
				    </thead>
				    <tbody>
				    	<?php foreach($dados as $key=>$value){ ?>
							<tr>
								<td><?php echo $value["descricao"]; ?></td>
								<td><?php echo $value["tempos"]; ?></td>
								<td><?php echo $value["agregacoes"]; ?></td>
					    		<td><?php echo ($value["ativo"]?"Ativo":"Inativo"); ?></td>
					    		<td><a href="<?php echo Manipulador::Instancia()->getDir()."turma/".$idTurma."/aula/editar/".$value["idAula"]; ?>">Editar</a> <a href="<?php echo Manipulador::getDir(); ?>controles/aula.php?acao=<?php echo ($value["ativo"]?"desativar":"ativar"); ?>&id=<?php echo $value["idAula"]; ?>&idTurma=<?php echo $idTurma; ?>"><?php echo ($value["ativo"]?"Desativar":"Ativar"); ?></a> <a href="#" onclick="abrirModal('#modal-<?php echo $value["idAula"]; ?>')">Excluir</a></td>
					    	</tr>

					    	<div class="modal fade" id="modal-<?php echo $value["idAula"]; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-label-<?php echo $value["idAula"]; ?>">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Você está certo disso?</h4>
							      </div>
							      <div class="modal-body">
							       	Você deseja mesmo excluir a aula: <b><?php echo $value["descricao"]; ?></b>? A exclusão não poderá ser revertida.
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
							        <a href="<?php echo Manipulador::getDir(); ?>controles/aula.php?acao=excluir&id=<?php echo $value["idAula"]; ?>&idTurma=<?php echo $idTurma; ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
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