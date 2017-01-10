<?php 
if(!isset($_GET['aux2']) || trim($_GET['aux2']) == "") header("location: ".Manipulador::getDir()."turma/".$_GET["acao"]."/aula");

  $id = $_GET['aux2'];
  require_once("modelos/DaoAula.php");

  $dados = DaoAula::Instancia()->CarregarPorId($id);
  if(!$dados) header("location: ".Manipulador::getDir()."turma/".$_GET["acao"]."/aula");

  require_once("modelos/DaoRecurso.php");
  $recursos = DaoRecurso::Instancia()->ListarAtivos();

  require_once("modelos/DaoTempoAula.php");
  require_once("modelos/DaoTurma.php");
  require_once("modelos/DaoSala.php");
  require_once("modelos/DaoProfessor.php");

  $salas = DaoSala::Instancia()->ListarAtivos();
  $professores = DaoProfessor::Instancia()->ListarAtivos();

  $turma = DaoTurma::Instancia()->CarregarPorId($dados["idTurma"]);

  $aulasAgregadas = DaoAula::Instancia()->ListarPorAgregacao($dados["idAgregacao"], $id);
?>

<h1>Editar Aula</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/aula.php?acao=editar" class="form-validate">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="page-header">
      <h4>Informações Gerais</h4>
    </div>

    <div class="form-group">
      <label for="turma">Turma</label>
      <input type="text" class="form-control" id="turma" disabled value="<?php echo $turma["disciplina"]." - ".$turma["descricao"]; ?>">
      <input type="hidden" class="form-control" name="idTurma" value="<?php echo $turma["idTurma"]; ?>">
      <input type="hidden" class="form-control" name="idAgregacao" value="<?php echo $dados["idAgregacao"]; ?>">
    </div>
   <div class="form-group">
      <label for="descricao">Descrição</label>
      <input type="text" name="descricao" class="form-control" id="descricao" minlength="1" required value="<?php echo $dados['descricao']; ?>">
    </div>
    <div class="form-group">
      <label for="tempos">Tempos</label>
      <select name="tempos" class="form-control" id="aulaTempos" required>
        <option value="1" <?php echo (($dados["tempos"] == "1")?"selected":""); ?>>1</option>
        <option value="2" <?php echo (($dados["tempos"] == "2")?"selected":""); ?>>2</option>
        <option value="3" <?php echo (($dados["tempos"] == "3")?"selected":""); ?>>3</option>
        <option value="4" <?php echo (($dados["tempos"] == "4")?"selected":""); ?>>4</option>
        <option value="5" <?php echo (($dados["tempos"] == "5")?"selected":""); ?>>5</option>
        <option value="6" <?php echo (($dados["tempos"] == "6")?"selected":""); ?>>6</option>
      </select>
    </div>
    <div class="form-group">
      <label for="comentarios">Comentários</label>
      <input type="text" name="comentarios" class="form-control" id="comentarios" value="<?php echo $dados['comentarios']; ?>">
    </div>
    <div class="form-group">
        <label for="idProfessor">Professor</label>

        <select name="idProfessor" class="form-control" id="professor">
            <option value="">Sem Professor</option>
            <?php foreach ($professores as $key => $value) { ?>
              <option value="<?php echo $value["idProfessor"]; ?>" <?php echo (($dados['Professor_idProfessor']==$value["idProfessor"])?"selected":""); ?>><?php echo $value["nome"]; ?></option>
            <?php } ?>
      </select>
    </div>
    <div class="form-group">
        <label for="idSala">Fixar Sala</label>
        <select name="idSala" class="form-control" id="sala">
          <option value="">Não</option>
          <?php foreach ($salas as $key => $value) { ?>
            <option value="<?php echo $value["idSala"]; ?>" <?php echo (($dados['Sala_idSala']==$value["idSala"])?"selected":""); ?>><?php echo $value["descricao"]; ?></option>
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
        $recursosAula = DaoRecurso::Instancia()->CarregarPorAgregacao($dados["idAgregacao"]);
        $recursosAulaId = array();
        $recursosAulaQuantidade = array();
        $recursosAulaFlexibilidade = array();
        foreach ($recursosAula as $key => $value) {
            $recursosAulaId[] = $value["idRecurso"];
            $recursosAulaQuantidade[$value["idRecurso"]] = $value["quantidade"];
            $recursosAulaFlexibilidade[$value["idRecurso"]] = $value["flexibilidade"];
        }

        foreach ($recursos as $key => $value) {
    ?>
              <tr>
                <td width="3%"><input type="checkbox" name="recursos[<?php echo $value["idRecurso"]; ?>][ativo]" id="recursos_<?php echo $value["idRecurso"]; ?>" value="1" <?php echo (in_array($value["idRecurso"], $recursosAulaId))?"checked":""; ?>></td>
                <td><?php echo $value["descricao"]; ?></td>
                <td width="5%"><input type="number" min="0" required name="recursos[<?php echo $value["idRecurso"]; ?>][quantidade]" class="form-control" id="recursos_quantidade_<?php echo $value["idRecurso"]; ?>" value="<?php echo (in_array($value["idRecurso"], $recursosAulaId))?$recursosAulaQuantidade[$value["idRecurso"]]:"1"; ?>"></td>
                <td width="15%">
                  <select required name="recursos[<?php echo $value["idRecurso"]; ?>][flexibilidade]" class="form-control" id="recursos_flexibilidade_<?php echo $value["idRecurso"]; ?>">
                    <option value="4" <?php echo (in_array($value["idRecurso"], $recursosAulaId))?(($recursosAulaFlexibilidade[$value["idRecurso"]] == "4")?"selected":""):"selected"; ?>>Obrigatório</option>
                    <option value="3" <?php echo (in_array($value["idRecurso"], $recursosAulaId))?(($recursosAulaFlexibilidade[$value["idRecurso"]] == "3")?"selected":""):""; ?>>Altamente Necessário</option>
                    <option value="2" <?php echo (in_array($value["idRecurso"], $recursosAulaId))?(($recursosAulaFlexibilidade[$value["idRecurso"]] == "2")?"selected":""):""; ?>>Necessário</option>
                    <option value="1" <?php echo (in_array($value["idRecurso"], $recursosAulaId))?(($recursosAulaFlexibilidade[$value["idRecurso"]] == "1")?"selected":""):""; ?>>Dispensável</option>
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
            <th width="14%" class="text-center">Segunda</th>
            <th width="14%" class="text-center">Terça</th>
            <th width="14%" class="text-center">Quarta</th>
            <th width="14%" class="text-center">Quinta</th>
            <th width="14%" class="text-center">Sexta</th>
            <th width="14%" class="text-center">Sábado</th>
            <th width="14%" class="text-center">Domingo</th>
          </tr>
        </thead>
        <tbody>
            <?php 
              $tempoAulas = DaoTempoAula::Instancia()->CarregarPorAgregacao($dados["idAgregacao"], $dados["tempos"]);
              $tempoAulasValor = DaoTempoAula::Instancia()->CarregarPorAgregacao($dados["idAgregacao"]);
              $horarios = array("M","T","N");

              for($i=0;$i<3;$i++){
                for($j=1; $j<=6; $j++){
                  ?>
                    <tr>
                      <td width="2%"  class="inselecionavel<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?>"><?php echo $horarios[$i].$j;?></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['SEG'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SEG-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['SEG'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['TER'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[TER-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['TER'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['QUA'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[QUA-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['QUA'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['QUI'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[QUI-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['QUI'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['SEX'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SEX-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['SEX'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['SAB'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SAB-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['SAB'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['DOM'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[DOM-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulasValor['DOM'][$horarios[$i].$j]; ?>"/></td>
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

    <div class="modal fade" id="modal-editar-aula" tabindex="-1" role="dialog" aria-labelledby="modal-label-editar-aula">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Você está certo disso?</h4>
            </div>
            <div class="modal-body">
              Esta aula possui outras aulas agregadas.<br><br>
              Alterando os recursos e horários desta aula, todas as aulas agregadas também terão seus recursos e horários alterados.<br><br>
              As aulas agregadas são:<br><br>
              <?php foreach ($aulasAgregadas as $key => $value) {
                  echo "<b>Disciplina: </b>".$value["disciplina"]."<br><b>Turma: </b>".$value["turma"]."<br><b>Aula: </b>".$value["descricao"]."<br><br>";
              } ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
              <button type="submit" class="btn btn-salvar btn-success pull-right">Confirmar</button>
            </div>
          </div>
        </div>
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

    <?php if(sizeof($aulasAgregadas) == 0) { ?>
      <button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
    <?php } else { ?>
      <button type="submit" class="btn btn-confirmar btn-success pull-right" onclick="$('#modal-editar-aula').addClass('fade'); abrirModal('#modal-editar-aula'); return false;">Salvar</button>
    <?php } ?>

    <a href="<?php echo Manipulador::getDir(); ?>turma/<?php echo $turma["idTurma"]; ?>/aula/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
    <div class="clear"></div>
</form>
<br>