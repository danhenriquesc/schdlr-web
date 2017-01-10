<?php 
	class Sala{
		private $descricao;
		private $capacidade;
		private $numero;
		private $ativo;
		private $excluido;
		private $recursos;
		private $tempoAula;

		public function __construct($descricao, $capacidade, $numero, $recursos, $tempoAula, $ativo = "1", $excluido = "0"){
			$this->descricao = $descricao;
			$this->capacidade = $capacidade;
			$this->numero = $numero;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
			$this->recursos = $recursos;
			$this->tempoAula = $tempoAula;
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

		public function getNumero(){
			return $this->numero;
		}

		public function setNumero($numero){
			$this->numero = $numero;
		}

		public function getRecursos(){
			return $this->recursos;
		}

		public function setRecursos($recursos){
			$this->recursos = $recursos;
		}

		public function setTempoAula($tempoAula){
			$this->tempoAula = $tempoAula;
		}

		public function getTempoAula(){
			return $this->tempoAula;
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