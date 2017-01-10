<?php
  require_once("modelos/DaoDepartamento.php");
  $departamentos = DaoDepartamento::Instancia()->ListarAtivos();  

  require_once("modelos/DaoCurso.php");
  $cursos = DaoCurso::Instancia()->ListarAtivos(); 
?>

<h1>Adicionar Disciplina</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/disciplina.php?acao=adicionar" class="form-validate">
	<div class="form-group">
    	<label for="codigo">Código</label>
    	<input type="text" name="codigo" class="form-control" id="codigo" minlength="3" required>
  	</div>
  	<div class="form-group">
    	<label for="nome">Nome</label>
    	<input type="text" name="nome" class="form-control" id="nome" minlength="5" required>
  	</div>
  	<div class="form-group">
    	<label for="descricao">Descrição</label>
    	<textarea name="descricao" class="form-control" id="descricao"></textarea>
  	</div>
  	<div class="form-group">
    	<label for="carga_horaria">Carga Horária (horas)</label>
    	<input type="text" name="carga_horaria" class="form-control" id="carga_horaria" minlength="1" required>
  	</div>
  	<div class="form-group">
    	<label for="departamento">Departamento</label>
    	<select name="departamento" class="form-control" id="departamento" required>
    		<option value="">Selecione</option>
        <?php foreach ($departamentos as $key => $value) { ?>
            <option value="<?php echo $value["idDepartamento"]?>"><?php echo $value["nome"]?></option>
        <?php } ?>
    	</select>
  	</div>
  	<div class="form-group cursos-group">
    	<label for="cursos">Curso(s)</label>
    	<br>
      <table>
      <?php foreach ($cursos as $key => $value) { ?>
          <tr>
            <td>
              <input type="checkbox" required name="cursos[]" id="cursos_<?php echo $value["idCurso"]; ?>" value="<?php echo $value["idCurso"]; ?>">  <?php echo $value["nome"]; ?>
            </td>
            <td>
              <div style="width:20px;display:inline-block;"></div>
              <select required name="cursos_periodo[<?php echo $value["idCurso"]; ?>]">
                  <?php for($i = 1; $i<=20; $i++) { ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?>º Período</option>
                  <?php } ?>
              </select>
            </td>
          </td>
      <?php } ?>
      </table>
    	<br>
    </div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>disciplina/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>