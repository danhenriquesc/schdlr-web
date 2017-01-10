<?php 
	class Instituto{
		private $nome;
		private $ativo;
		private $excluido;

		public function __construct($nome, $ativo = "1", $excluido = "0"){
			$this->nome = $nome;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
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