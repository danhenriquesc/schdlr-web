<?php 
	class Recurso{
		private $descricao;
		private $ativo;
		private $excluido;

		public function __construct($descricao, $ativo = "1", $excluido = "0"){
			$this->descricao = $descricao;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
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