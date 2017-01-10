<?php 
	if(!isset($_GET['id']) || trim($_GET['id']) == "") header("location: ".Manipulador::getDir()."disciplina");

	$id = $_GET['id'];
	require_once("modelos/DaoDisciplina.php");

	$dados = DaoDisciplina::Instancia()->CarregarPorId($id);
	if(!$dados) header("location: ".Manipulador::getDir()."curso");

  require_once("modelos/DaoDepartamento.php");
  $departamentos = DaoDepartamento::Instancia()->ListarAtivos();  

  require_once("modelos/DaoCurso.php");
  $cursos = DaoCurso::Instancia()->ListarAtivos(); 
?>

<h1>Editar Disciplina</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/disciplina.php?acao=editar" class="form-validate">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <div class="form-group">
      <label for="codigo">Código</label>
      <input type="text" name="codigo" class="form-control" id="codigo" minlength="3" required value="<?php echo $dados['codigo']; ?>">
    </div>
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" class="form-control" id="nome" minlength="5" required value="<?php echo $dados['nome']; ?>">
    </div>
    <div class="form-group">
      <label for="descricao">Descrição</label>
      <textarea name="descricao" class="form-control" id="descricao"><?php echo $dados['descricao']; ?></textarea>
    </div>
    <div class="form-group">
      <label for="carga_horaria">Carga Horária (horas)</label>
      <input type="text" name="carga_horaria" class="form-control" id="carga_horaria" minlength="1" required value="<?php echo $dados['carga_horaria']; ?>">
    </div>
    <div class="form-group">
      <label for="departamento">Departamento</label>
      <select name="departamento" class="form-control" id="departamento" required>
        <option value="">Selecione</option>
        <?php foreach ($departamentos as $key => $value) { ?>
            <option value="<?php echo $value["idDepartamento"]?>" <?php echo ($dados["Departamento_idDepartamento"] == $value["idDepartamento"])?"selected":""; ?>><?php echo $value["nome"]?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group cursos-group">
      <label for="cursos">Curso(s)</label>
      <br>
      <table>
      <?php 
          $cursosDisciplina = DaoCurso::Instancia()->CarregarPorDisciplina($id);
          $cursosDisciplinaId = array();
          $cursosPeriodo = array();
          foreach ($cursosDisciplina as $key => $value) {
              $cursosDisciplinaId[] = $value["idCurso"];
              $cursosPeriodo[$value["idCurso"]] = $value["periodo"];
          }

      foreach ($cursos as $key => $value) { ?>
          <tr>
            <td>
              <input type="checkbox" required name="cursos[]" id="cursos_<?php echo $value["idCurso"]; ?>" value="<?php echo $value["idCurso"]; ?>" <?php echo (in_array($value["idCurso"], $cursosDisciplinaId))?"checked":""; ?>>  <?php echo $value["nome"]; ?>
            </td>
            <td>
              <div style="width:20px;display:inline-block;"></div>
              <select required name="cursos_periodo[<?php echo $value["idCurso"]; ?>]">
                  <?php for($i = 1; $i<=20; $i++) { ?>
                      <option value="<?php echo $i;?>" <?php echo ((isset($cursosPeriodo[$value["idCurso"]]) && $cursosPeriodo[$value["idCurso"]] == $i)?"selected":""); ?>><?php echo $i;?>º Período</option>
                  <?php } ?>
              </select>
            </td>
          </td>
      <?php } ?>
      </table>
      <br>
    </div>
    <button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
    <a href="<?php echo Manipulador::getDir(); ?>disciplina/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
    <div class="clear"></div>
</form>
<br>