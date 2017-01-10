<?php
  $idTurma = $_GET['acao'];

  require_once("modelos/DaoRecurso.php");
  require_once("modelos/DaoTurma.php");

  require_once("modelos/DaoSala.php");
  require_once("modelos/DaoProfessor.php");
  

  $recursos = DaoRecurso::Instancia()->ListarAtivos();
  $turma = DaoTurma::Instancia()->CarregarPorId($idTurma);
  $salas = DaoSala::Instancia()->ListarAtivos();
  $professores = DaoProfessor::Instancia()->ListarAtivos();
?>

<h1>Adicionar Aula</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/aula.php?acao=adicionar" class="form-validate">
    <div class="page-header">
      <h4>Informações Gerais</h4>
    </div>

    <div class="form-group">
      <label for="turma">Turma</label>
      <input type="text" class="form-control" id="turma" disabled value="<?php echo $turma["disciplina"]." - ".$turma["descricao"]; ?>">
      <input type="hidden" class="form-control" name="idTurma" value="<?php echo $idTurma; ?>">
    </div>
	 <div class="form-group">
    	<label for="descricao">Descrição</label>
    	<input type="text" name="descricao" class="form-control" id="descricao" minlength="1" required>
  	</div>
    <div class="form-group">
      <label for="tempos">Tempos</label>
      <select name="tempos" class="form-control" id="aulaTempos" required>
        <option value="1">1</option>
        <option value="2" selected>2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
      </select>
    </div>
  	<div class="form-group">
    	<label for="comentarios">Comentários</label>
    	<input type="text" name="comentarios" class="form-control" id="comentarios">
  	</div>
    <div class="form-group">
        <label for="idProfessor">Professor</label>

        <select name="idProfessor" class="form-control" id="professor">
            <option value="">Sem Professor</option>
            <?php foreach ($professores as $key => $value) { ?>
              <option value="<?php echo $value["idProfessor"]; ?>"><?php echo $value["nome"]; ?></option>
            <?php } ?>
      </select>
    </div>
    <div class="form-group">
        <label for="idSala">Fixar Sala</label>
        <select name="idSala" class="form-control" id="sala">
          <option value="">Não</option>
          <?php foreach ($salas as $key => $value) { ?>
            <option value="<?php echo $value["idSala"]; ?>"><?php echo $value["descricao"]; ?></option>
          <?php } ?>
      </select>
    </div>



    <div class="page-header">
      <h4>Recursos</h4>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="3%"></th>
                <th>Recurso</th>
                <th width="5%">Quantidade</th>
                <th width="15%">Flexibilidade</th>
              </tr>
            </thead>
            <tbody>
    <?php 
        foreach ($recursos as $key => $value) {
    ?>
              <tr>
                <td width="3%"><input type="checkbox" name="recursos[<?php echo $value["idRecurso"]; ?>][ativo]" id="recursos_<?php echo $value["idRecurso"]; ?>" value="1"></td>
                <td><?php echo $value["descricao"]; ?></td>
                <td width="5%"><input type="number" min="0" required name="recursos[<?php echo $value["idRecurso"]; ?>][quantidade]" class="form-control" id="recursos_quantidade_<?php echo $value["idRecurso"]; ?>" value="1"></td>
                <td width="15%">
                  <select required name="recursos[<?php echo $value["idRecurso"]; ?>][flexibilidade]" class="form-control" id="recursos_flexibilidade_<?php echo $value["idRecurso"]; ?>">
                    <option value="4" selected>Obrigatório</option>
                    <option value="3">Altamente Necessário</option>
                    <option value="2">Necessário</option>
                    <option value="1">Dispensável</option>
                  </select>
                </td>
              </tr>
          
    <?php
        }
    ?>
            </tbody>
        </table>
    </div>

    <div class="page-header">
      <h4>Horários</h4>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered" id="tabela-horarios-aula">
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
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[SEG-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[TER-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[QUA-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[QUI-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[SEX-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[SAB-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[DOM-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
                    </tr>
                  <?php
                }
              }
            ?>
        </tbody>
        <tfoot>
          <tr>
              <td colspan="4">
                <div class="legenda texto"><p>Clique com o Botão Direito para remover alguma alocação</p></div>
              </td>
              <td colspan="4">
                <div class="legenda"><span class="disponivel"></span><p>Disponível</p></div>
                <div class="legenda"><span class="indisponivel"></span><p>Selecionado</p></div> 
                <div class="legenda"><span class="disponivel hover"></span><p>Conflito</p></div>
              </td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="modal fade" id="modal-aula-conflito" tabindex="-1" role="dialog" aria-labelledby="modal-label-aula-conflito">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Ocorreu um conflito</h4>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Entendi</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-aula-vazio" tabindex="-1" role="dialog" aria-labelledby="modal-label-aula-vazio">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nenhum horário selecionado</h4>
          </div>
          <div class="modal-body">
            Você precisa selecionar possíveis horários para a aula.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Entendi</button>
          </div>
        </div>
      </div>
    </div>

  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>turma/<?php echo $idTurma; ?>/aula/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>