<?php 
	class Curso{
		private $nome;
		private $descricao;
		private $idInstituto;
		private $ativo;
		private $excluido;

		public function __construct($nome, $descricao, $idInstituto, $ativo = "1", $excluido = "0"){
			$this->nome = $nome;
			$this->descricao = $descricao;
			$this->idInstituto = $idInstituto;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
		}

		public function getIdInstituto(){
			return $this->idInstituto;
		}

		public function setIdInstituto($idInstituto){
			$this->idInstituto = $idInstituto;
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