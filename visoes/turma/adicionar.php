<?php 
  $idDisciplina = $_GET['acao'];

  require_once("modelos/DaoDisciplina.php");
  $disciplina = DaoDisciplina::Instancia()->CarregarPorId($idDisciplina);

  require_once("modelos/DaoCurso.php");
  $cursos = DaoCurso::Instancia()->CarregarPorDisciplina($idDisciplina);
?>


<h1>Adicionar Turma</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/turma.php?acao=adicionar" class="form-validate">
  <div class="form-group">
      <label for="disciplina">Disciplina</label>
      <input type="text" class="form-control" id="disciplina" minlength="5" disabled value="<?php echo $disciplina["codigo"]." ".$disciplina["nome"]; ?>">
      <input type="hidden" class="form-control" name="idDisciplina" value="<?php echo $idDisciplina; ?>">
    </div>
	 <div class="form-group">
    	<label for="descricao">Descrição</label>
    	<input type="text" name="descricao" class="form-control" id="descricao" minlength="5" required>
  	</div>
  	<div class="form-group">
    	<label for="capacidade">Capacidade</label>
    	<input type="text" name="capacidade" class="form-control" id="capacidade" minlength="1" required>
  	</div>
    <div class="form-group">
      <label for="cursopreferencial">Curso Preferencial</label>
      <select name="cursopreferencial" class="form-control" id="cursopreferencial" required>
        <option value="">Selecione</option>
        <?php foreach ($cursos as $key => $value) { ?>
            <option value="<?php echo $value["idCurso"]?>"><?php echo $value["nome"]?></option>
        <?php } ?>
      </select>
    </div>
  	<button type="submit" class="btn btn-salvar btn-success pull-right">Adicionar</button>
  	<a href="<?php echo Manipulador::getDir(); ?>disciplina/<?php echo $idDisciplina; ?>/turma/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
  	<div class="clear"></div>
</form>
<br>