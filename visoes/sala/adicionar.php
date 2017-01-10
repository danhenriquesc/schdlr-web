<?php
  require_once("modelos/DaoRecurso.php");
  $recursos = DaoRecurso::Instancia()->ListarAtivos();
?>

<h1>Adicionar Sala</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/sala.php?acao=adicionar" class="form-validate">
    <div class="page-header">
      <h4>Informações Gerais</h4>
    </div>

	 <div class="form-group">
    	<label for="descricao">Descrição</label>
    	<input type="text" name="descricao" class="form-control" id="descricao" minlength="3" required>
  	</div>
  	<div class="form-group">
    	<label for="capacidade">Capacidade</label>
    	<input type="text" name="capacidade" class="form-control" id="capacidade" minlength="1" required>
  	</div>
    <div class="form-group">
      <label for="numero">Número</label>
      <input type="text" name="numero" class="form-control" id="numero" minlength="1" required>
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
        foreach ($recursos as $key => $value) {
    ?>
              <tr>
                <td width="3%"><input type="checkbox" name="recursos[<?php echo $value["idRecurso"]; ?>][ativo]" id="recursos_<?php echo $value["idRecurso"]; ?>" value="1"></td>
                <td><?php echo $value["descricao"]; ?></td>
                <td width="5%"><input type="number" min="0" required name="recursos[<?php echo $value["idRecurso"]; ?>][quantidade]" class="form-control" id="recursos_quantidade_<?php echo $value["idRecurso"]; ?>" value="1"></td>
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
              $horarios = array("M","T","N");

              for($i=0;$i<3;$i++){
                for($j=1; $j<=6; $j++){
                  ?>
                    <tr>
                      <td width="2%"  class="inselecionavel<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?>"><?php echo $horarios[$i].$j;?></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> disponivel"><input type="hidden" name="tempoAula[SEG-<?php echo $horarios[$i].$j; ?>]" value="1"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> disponivel"><input type="hidden" name="tempoAula[TER-<?php echo $horarios[$i].$j; ?>]" value="1"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> disponivel"><input type="hidden" name="tempoAula[QUA-<?php echo $horarios[$i].$j; ?>]" value="1"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> disponivel"><input type="hidden" name="tempoAula[QUI-<?php echo $horarios[$i].$j; ?>]" value="1"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> disponivel"><input type="hidden" name="tempoAula[SEX-<?php echo $horarios[$i].$j; ?>]" value="1"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> <?php echo ($i>0)?"in":""; ?>disponivel"><input type="hidden" name="tempoAula[SAB-<?php echo $horarios[$i].$j; ?>]" value="<?php echo ($i>0)?"0":"1"; ?>"/></td>
                      <td width="14%" class="text-center<?php echo ($j==6 && $i!=2)?" borda-inferior":""; ?> indisponivel"><input type="hidden" name="tempoAula[DOM-<?php echo $horarios[$i].$j; ?>]" value="0"/></td>
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

  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>sala/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>