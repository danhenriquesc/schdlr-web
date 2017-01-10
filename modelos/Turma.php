<?php 
	class Turma{
		private $descricao;
		private $capacidade;
		private $ativo;
		private $excluido;
		private $idDisciplina;
		private $cursoPreferencial;

		public function __construct($descricao, $capacidade, $idDisciplina, $cursoPreferencial, $ativo = "1", $excluido = "0"){
			$this->descricao = $descricao;
			$this->capacidade = $capacidade;
			$this->idDisciplina = $idDisciplina;
			$this->cursoPreferencial = $cursoPreferencial;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
		} 

		public function getCapacidade(){
			return $this->capacidade;
		}

		public function setCapacidade($capacidade){
			$this->capacidade = $capacidade;
		}

		public function getCursoPreferencial(){
			return $this->cursoPreferencial;
		}

		public function setCursoPreferencial($cursoPreferencial){
			$this->cursoPreferencial = $cursoPreferencial;
		}

		public function getIdDisciplina(){
			return $this->idDisciplina;
		}

		public function setIdDisciplina($idDisciplina){
			$this->idDisciplina = $idDisciplina;
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