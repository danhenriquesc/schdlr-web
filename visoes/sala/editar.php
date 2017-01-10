<?php 
	if(!isset($_GET['id']) || trim($_GET['id']) == "") header("location: ".Manipulador::getDir()."sala");

	$id = $_GET['id'];
	require_once("modelos/DaoSala.php");

	$dados = DaoSala::Instancia()->CarregarPorId($id);
	if(!$dados) header("location: ".Manipulador::getDir()."sala");

  require_once("modelos/DaoRecurso.php");
  $recursos = DaoRecurso::Instancia()->ListarAtivos();

  require_once("modelos/DaoTempoAula.php");
?>

<h1>Editar Sala</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/sala.php?acao=editar" class="form-validate">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="page-header">
      <h4>Informações Gerais</h4>
    </div>

   <div class="form-group">
      <label for="descricao">Descrição</label>
      <input type="text" name="descricao" class="form-control" id="descricao" minlength="3" required value="<?php echo $dados['descricao']; ?>">
    </div>
    <div class="form-group">
      <label for="capacidade">Capacidade</label>
      <input type="text" name="capacidade" class="form-control" id="capacidade" minlength="1" required value="<?php echo $dados['capacidade']; ?>">
    </div>
    <div class="form-group">
      <label for="numero">Número</label>
      <input type="text" name="numero" class="form-control" id="numero" minlength="1" required value="<?php echo $dados['numero']; ?>">
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
              </tr>
            </thead>
            <tbody>
    <?php 
        $recursosSala = DaoRecurso::Instancia()->CarregarPorSala($id);
        $recursosSalaId = array();
        $recursosSalaQuantidade = array();
        foreach ($recursosSala as $key => $value) {
            $recursosSalaId[] = $value["idRecurso"];
            $recursosSalaQuantidade[$value["idRecurso"]] = $value["quantidade"];
        }

        foreach ($recursos as $key => $value) {
    ?>
              <tr>
                <td width="3%"><input type="checkbox" name="recursos[<?php echo $value["idRecurso"]; ?>][ativo]" id="recursos_<?php echo $value["idRecurso"]; ?>" value="1" <?php echo (in_array($value["idRecurso"], $recursosSalaId))?"checked":""; ?>></td>
                <td><?php echo $value["descricao"]; ?></td>
                <td width="5%"><input type="number" min="0" required name="recursos[<?php echo $value["idRecurso"]; ?>][quantidade]" class="form-control" id="recursos_quantidade_<?php echo $value["idRecurso"]; ?>" value="<?php echo (in_array($value["idRecurso"], $recursosSalaId))?$recursosSalaQuantidade[$value["idRecurso"]]:"1"; ?>"></td>
              </tr>
          
    <?php
        }
    ?>
            </tbody>
        </table>
    </div>

    <div class="page-header">
      <h4>Horários Disponíveis</h4>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered" id="tabela-horarios-disponiveis-sala">
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
              $tempoAulas = DaoTempoAula::Instancia()->CarregarPorSala($id);
              $horarios = array("M","T","N");

              for($i=0;$i<3;$i++){
                for($j=1; $j<=6; $j++){
                  ?>
                    <tr>
                      <td width="2%"  class="inselecionavel<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?>"><?php echo $horarios[$i].$j;?></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['SEG'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SEG-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['SEG'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['TER'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[TER-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['TER'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['QUA'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[QUA-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['QUA'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['QUI'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[QUI-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['QUI'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['SEX'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SEX-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['SEX'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['SAB'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SAB-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['SAB'][$horarios[$i].$j]; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($tempoAulas['DOM'][$horarios[$i].$j] == 0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[DOM-<?php echo $horarios[$i].$j; ?>]" value="<?php echo $tempoAulas['DOM'][$horarios[$i].$j]; ?>"/></td>
                    </tr>
                  <?php
                }
              }
            ?>
        </tbody>
        <tfoot>
          <tr>
              <td colspan="8">
                <div class="legenda"><span class="disponivel"></span><p>Disponível</p></div>
                <div class="legenda"><span class="indisponivel"></span><p>Indisponível</p></div> 
              </td>
          </tr>
        </tfoot>
      </table>
    </div>

    <button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
    <a href="<?php echo Manipulador::getDir(); ?>sala/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
    <div class="clear"></div>
</form>
<br>