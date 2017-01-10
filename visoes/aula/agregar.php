<?php
  $idTurma = $_GET['acao'];

  require_once("modelos/DaoRecurso.php");
  require_once("modelos/DaoTurma.php");
  require_once("modelos/DaoDepartamento.php");
  $recursos = DaoRecurso::Instancia()->ListarAtivos();
  $turma = DaoTurma::Instancia()->CarregarPorId($idTurma);
  $departamentos = DaoDepartamento::Instancia()->ListarAtivos();

?>

<h1>Agregar Aula</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/aula.php?acao=agregar" class="form-validate">
    <div class="page-header">
      <h4>Informações Gerais</h4>
    </div>

    <div class="form-group">
      <label for="turma">Turma</label>
      <input type="text" class="form-control" id="turma" disabled value="<?php echo $turma["disciplina"]." - ".$turma["descricao"]; ?>">
      <input type="hidden" class="form-control" name="idTurma" value="<?php echo $idTurma; ?>">
      <input type="hidden" class="form-control" name="idAgregacao" id="idAgregacao">
    </div>
	 <div class="form-group">
    	<label for="descricao">Descrição</label>
    	<input type="text" name="descricao" class="form-control" id="descricao" minlength="1" required>
  	</div>
  	<div class="form-group">
    	<label for="comentarios">Comentários</label>
    	<input type="text" name="comentarios" class="form-control" id="comentarios">
  	</div>

    <div class="page-header">
      <h4>Agregar à</h4>
    </div>
    <div class="form-group">
      <label for="departamento">Departamento</label>
      <select class="form-control" id="departarmento_ajax">
          <option value="">Selecione</option>
          <?php foreach ($departamentos as $key => $value) { ?>
              <option value="<?php echo $value["idDepartamento"]; ?>"><?php echo $value["nome"]; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="disciplina">Disciplina</label>
      <select class="form-control" id="disciplina_ajax">
          <option value="">Selecione um Departamento</option>
      </select>
    </div>
    <div class="form-group">
      <label for="turma">Turma</label>
      <select class="form-control" id="turma_ajax">
          <option value="">Selecione uma Disciplina</option>
      </select>
    </div>
    <div class="form-group">
      <label for="idAula">Aula</label>
      <select name="idAula" class="form-control" id="aula_ajax" required>
          <option value="">Selecione uma Turma</option>
      </select>
    </div>

    <div id="agregar-informacoes">
      <div class="page-header">
        <h4>Informações da Agregação</h4>
      </div>
      <div id="info">
      </div>


      <div class="page-header">
        <h4>Recursos</h4>
      </div>

      <div class="table-responsive">
          <table class="table table-striped table-bordered" id="tabela-agregacao-recursos-detalhes">
              <thead>
                <tr>
                  <th>Recurso</th>
                  <th width="5%">Quantidade</th>
                  <th width="15%">Flexibilidade</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
      </div>

      <div class="page-header">
        <h4>Horários</h4>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered" id="tabela-horarios-aula-detalhes">
          <thead>
            <tr>
              <th width="2%"></th>
              <th width="14%" class="text-center inselecionavel">Segunda</th>
              <th width="14%" class="text-center inselecionavel">Terça</th>
              <th width="14%" class="text-center inselecionavel">Quarta</th>
              <th width="14%" class="text-center inselecionavel">Quinta</th>
              <th width="14%" class="text-center inselecionavel">Sexta</th>
              <th width="14%" class="text-center inselecionavel">Sábado</th>
              <th width="14%" class="text-center inselecionavel">Domingo</th>
            </tr>
          </thead>
          <tbody>
              <?php 
                $horarios = array("M","T","N");

                for($i=0;$i<3;$i++){
                  for($j=1; $j<=6; $j++){
                    ?>
                      <tr>
                        <td width="2%"  class="inselecionavel<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?>"><?php echo $horarios[$i].$j;?></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                        <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"></td>
                      </tr>
                    <?php
                  }
                }
              ?>
          </tbody>
        </table>
      </div>
    </div>

  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>turma/<?php echo $idTurma; ?>/aula/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>