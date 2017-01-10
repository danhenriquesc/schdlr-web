<?php 
	$idDisciplina = $_GET['acao'];

	require_once("modelos/DaoTurma.php");
	require_once("modelos/DaoDisciplina.php");

	$dados = DaoTurma::Instancia()->ListarPorDisciplina($idDisciplina);
	$disciplina = DaoDisciplina::Instancia()->CarregarPorId($idDisciplina);
?>

<div class="row">
	<div class="col-md-10">
		<h1>[<?php echo $disciplina["codigo"]." ".$disciplina["nome"]; ?>] Turmas</h1>
	</div>
	<div class="col-md-2">
		<a href="<?php echo Manipulador::Instancia()->getDir(); ?>disciplina/<?php echo $idDisciplina; ?>/turma/adicionar"><button type="button" class="btn btn-success pull-right add-button">Adicionar Nova</button></a>
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
				    		<th>Capacidade</th>
				    		<th width="7%">Status</th>
				    		<th width="20%">Ações</th>
				    	</tr>
				    </thead>
				    <tbody>
				    	<?php foreach($dados as $key=>$value){ ?>
							<tr>
								<td><?php echo $value["descricao"]; ?></td>
								<td><?php echo $value["capacidade"]; ?></td>
					    		<td><?php echo ($value["ativo"]?"Ativo":"Inativo"); ?></td>
					    		<td><a href="<?php echo Manipulador::Instancia()->getDir()."turma/".$value["idTurma"]; ?>/aula ">Aulas (<?php echo $value["aulas"]; ?>)</a> <a href="<?php echo Manipulador::Instancia()->getDir()."disciplina/".$idDisciplina."/turma/editar/".$value["idTurma"]; ?>">Editar</a> <a href="<?php echo Manipulador::getDir(); ?>controles/turma.php?acao=<?php echo ($value["ativo"]?"desativar":"ativar"); ?>&id=<?php echo $value["idTurma"]; ?>&idDisciplina=<?php echo $idDisciplina; ?>"><?php echo ($value["ativo"]?"Desativar":"Ativar"); ?></a> <a href="#" onclick="abrirModal('#modal-<?php echo $value["idTurma"]; ?>')">Excluir</a></td>
					    	</tr>

					    	<div class="modal fade" id="modal-<?php echo $value["idTurma"]; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-label-<?php echo $value["idTurma"]; ?>">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Você está certo disso?</h4>
							      </div>
							      <div class="modal-body">
							       	Você deseja mesmo excluir a turma: <b><?php echo $value["descricao"]; ?></b>? A exclusão não poderá ser revertida.
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
							        <a href="<?php echo Manipulador::getDir(); ?>controles/turma.php?acao=excluir&id=<?php echo $value["idTurma"]; ?>&idDisciplina=<?php echo $idDisciplina; ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
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