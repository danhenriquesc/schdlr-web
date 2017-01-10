<?php 
	if(!isset($_GET['aux2']) || trim($_GET['aux2']) == "") header("location: ".Manipulador::getDir()."disciplina/".$_GET["acao"]."/turma");

	$id = $_GET['aux2'];
	require_once("modelos/DaoTurma.php");

	$dados = DaoTurma::Instancia()->CarregarPorId($id);

  require_once("modelos/DaoCurso.php");
  $cursos = DaoCurso::Instancia()->CarregarPorDisciplina($dados['Disciplina_idDisciplina']);

	if(!$dados) header("location: ".Manipulador::getDir()."disciplina/".$_GET["acao"]."/turma");
?>

<h1>Editar Turma</h1>
<form method="POST" action="<?php echo Manipulador::getDir(); ?>controles/turma.php?acao=editar" class="form-validate">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="idDisciplina" value="<?php echo $dados['Disciplina_idDisciplina']; ?>">
    
   <div class="form-group">
      <label for="descricao">Descrição</label>
      <input type="text" name="descricao" class="form-control" id="descricao" minlength="5" required value="<?php echo $dados['descricao']; ?>">
    </div>
    <div class="form-group">
      <label for="capacidade">Capacidade</label>
      <input type="text" name="capacidade" class="form-control" id="capacidade" minlength="1" required value="<?php echo $dados['capacidade']; ?>">
    </div>
    <div class="form-group">
      <label for="cursopreferencial">Curso Preferencial</label>
      <select name="cursopreferencial" class="form-control" id="cursopreferencial" required>
        <option value="">Selecione</option>
        <?php foreach ($cursos as $key => $value) { ?>
            <option value="<?php echo $value["idCurso"]?>" <?php echo ($dados["CursoPreferencial_idCurso"] == $value["idCurso"])?"selected":""; ?>><?php echo $value["nome"]?></option>
        <?php } ?>
      </select>
    </div>

    <button type="submit" class="btn btn-salvar btn-success pull-right">Salvar</button>
    <a href="<?php echo Manipulador::getDir(); ?>disciplina/<?php echo $_GET["acao"]; ?>/turma/"><button type="button" class="btn btn-default pull-right">Voltar</button></a>
    <div class="clear"></div>
</form>
<br>