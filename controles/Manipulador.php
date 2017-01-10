<?php 
	class Manipulador{
		public static $instancia;
		private static $titulo = "Schdlr";
		private static $dir = "http://localhost/tcc/";

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new Manipulador();

			return self::$instancia;
		}

		public function getTitulo(){
			return self::$titulo;
		}

		public function setTitulo($titulo){
			self::$titulo = $titulo;
		}

		public function Cabecalho(){
			echo '<!DOCTYPE html>
						<html lang="pt-br">
							  <head>
								    <meta charset="utf-8">
								    <meta http-equiv="X-UA-Compatible" content="IE=edge">
								    <meta name="viewport" content="width=device-width, initial-scale=1">';

			echo 				     '<title>'.$this->getTitulo().'</title>';


			echo 					 '<link rel="stylesheet" type="text/css" href="'.self::$dir.'lib/bootstrap-3.3.5/css/bootstrap.min.css">';
			echo 					 '<link rel="stylesheet" type="text/css" href="'.self::$dir.'css/custom.css">';
			echo 			  '</head>
							  <body>';
		}

		public function Menu(){
			$dados = array("recurso", "sala", "departamento", "curso", "disciplina", "turma");
			$configuracoes = array("configuracoes");

			$pagina = (isset($_GET['pagina']) && trim($_GET['pagina']) != "")?$_GET['pagina']:"";
			$pagina = strtolower($pagina);

			$acao = (isset($_GET['acao']) && trim($_GET['acao']) != "")?$_GET['acao']:"";
			$acao = strtolower($acao);

			$superpagina = "inicio";
			if(in_array($pagina, $dados)) $superpagina = "dados";
			if(in_array($pagina, $configuracoes)) $superpagina = "configuracoes";

			echo '<nav class="navbar navbar-inverse">
  					<div class="container">
						<div class="navbar-header">
  							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    							<span class="sr-only">Toggle navigation</span>
    							<span class="icon-bar"></span>
    							<span class="icon-bar"></span>
    							<span class="icon-bar"></span>
  							</button>
  							<a class="navbar-brand" href="'.self::$dir.'">Schdlr</a>
        				</div>
        				<div id="navbar" class="collapse navbar-collapse">
          					<ul class="nav navbar-nav">
            					<li class="'.(($superpagina=="inicio")?'active':'').'"><a href="'.self::$dir.'">Início</a><span></span></li>
            					<li class="dropdown '.(($superpagina=="dados")?'active':'').'">
							          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dados <span class="caret"></span></a>
							          <ul class="dropdown-menu">
							          		<li class="'.(($pagina=="recurso")?'active':'').'"><a href="'.self::$dir.'recurso/">Recursos</a></li>
								            <li class="'.(($pagina=="sala")?'active':'').'"><a href="'.self::$dir.'sala/">Salas</a></li>
								            <li role="separator" class="divider"></li>
								            <li class="'.(($pagina=="instituto")?'active':'').'"><a href="'.self::$dir.'instituto/">Instituto/Faculdade</a></li>
								            <li class="'.(($pagina=="departamento")?'active':'').'"><a href="'.self::$dir.'departamento/">Departamentos</a></li>
								            <li class="'.(($pagina=="professor")?'active':'').'"><a href="'.self::$dir.'professor/">Professor</a></li>
								            <li class="'.(($pagina=="curso")?'active':'').'"><a href="'.self::$dir.'curso/">Cursos</a></li>
								            <li role="separator" class="divider"></li>
								            <li class="'.(($pagina=="disciplina")?'active':'').'"><a href="'.self::$dir.'disciplina/">Disciplinas</a></li>
								            <!--<li class="'.(($pagina=="turma")?'active':'').'"><a href="'.self::$dir.'turma/">Turmas</a></li>-->
							          </ul>
							          <span></span>
						        </li>
								<li class="dropdown '.(($superpagina=="configuracoes")?'active':'').'">
							          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configurações <span class="caret"></span></a>
							          <ul class="dropdown-menu">
							          		<li class="'.(($acao=="sistema")?'active':'').'"><a href="'.self::$dir.'configuracoes/sistema">Sistema</a></li>
								            <li class="'.(($acao=="algoritmo")?'active':'').'"><a href="'.self::$dir.'configuracoes/algoritmo">Algoritmo</a></li>
								            <li role="separator" class="divider"></li>
								            <li class="'.(($acao=="usuario")?'active':'').'"><a href="'.self::$dir.'configuracoes/usuario">Usuário</a></li>
								            <li class="'.(($acao=="permissao")?'active':'').'"><a href="'.self::$dir.'configuracoes/permissao">Permissão</a></li>
								            <li role="separator" class="divider"></li>
								            <li class="'.(($acao=="exportar")?'active':'').'"><a href="'.self::$dir.'configuracoes/exportar">Exportar</a></li>
							          </ul>
							          <span></span>
						        </li>
          					</ul>
        				</div>
      				</div>
    				</nav>';
		}

		public function Conteudo(){
			echo '<div class="container">';
			self::CarregarPagina();
			echo '</div>';
		}

		public function CarregarPagina(){
			$pagina = (isset($_GET['pagina']) && trim($_GET['pagina']) != "")?$_GET['pagina']:"";
			$acao = (isset($_GET['acao']) && trim($_GET['acao']) != "")?($_GET['acao']):"index";

			$id = (isset($_GET['id']) && trim($_GET['id']) != "")?($_GET['id']):"";
			$aux1 = (isset($_GET['aux1']) && trim($_GET['aux1']) != "")?($_GET['aux1']):"index";

			//var_dump($_GET);

			if(trim($pagina) == ""){
				//include("visoes/".$pagina."/".$acao);
				echo 'main';
			}else if(!intval($acao)){
				include("visoes/".$pagina."/".$acao.".php");
			}else{
				include("visoes/".$id."/".$aux1.".php");
			}
			
		}

		public function getDir(){
			return self::$dir;
		}

		public function Rodape(){
			echo '<script src="'.self::$dir.'scripts/jquery.min.js"></script>';
    		echo '<script src="'.self::$dir.'lib/bootstrap-3.3.5/js/bootstrap.min.js"></script>';
    		echo '<script src="'.self::$dir.'scripts/jquery.validate.min.js"></script>';
    		echo '<script src="'.self::$dir.'scripts/custom.js"></script>';

			echo 			  '</body>
						</html>';
		}
	}
?>