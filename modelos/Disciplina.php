<?php 
	class Disciplina{
		private $nome;
		private $codigo;
		private $descricao;
		private $cargaHoraria;
		private $ativo;
		private $excluido;
		private $idDepartamento;
		private $cursos;
		private $cursos_periodo;

		public function __construct($nome, $codigo, $descricao, $cargaHoraria, $idDepartamento, $cursos,$cursos_periodo, $ativo = "1", $excluido = "0"){
			$this->nome = $nome;
			$this->codigo = $codigo;
			$this->descricao = $descricao;
			$this->cargaHoraria = $cargaHoraria;
			$this->idDepartamento = $idDepartamento;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
			$this->cursos = $cursos;
			$this->cursos_periodo = $cursos_periodo;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getCodigo(){
			return $this->codigo;
		}

		public function setCodigo($codigo){
			$this->codigo = $codigo;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
		}

		public function getCargaHoraria(){
			return $this->cargaHoraria;
		}

		public function setCargaHoraria($cargaHoraria){
			$this->cargaHoraria = $cargaHoraria;
		}

		public function getIdDepartamento(){
			return $this->idDepartamento;
		}

		public function setIdDepartamentoo($idDepartamento){
			$this->idDepartamento = $idDepartamento;
		}

		public function getCursos(){
			return $this->cursos;
		}

		public function setCursos($cursos){
			$this->cursos = $cursos;
		}

		public function getCursosPeriodos(){
			return $this->cursos_periodo;
		}

		public function setCursosPeriodos($cursos_periodo){
			$this->cursos_periodo = $cursos_periodo;
		}

		public function getAtivo(){
			return $this->ativo;
		}

		public function setAtivo($ativo){
			$this->ativo = $ativo;
		}

		public function getExcluido(){
			return $this->excluido;
		}

		public function setExcluido($excluido){
			$this->excluido = $excluido;
		}
	}
?>