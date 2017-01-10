<?php 
	class Aula{
		private $descricao;
		private $comentarios;
		private $idAgregacao;
		private $idTurma;
		private $tempos;
		private $idProfessor;
		private $idSala;
		private $recursos;
		private $tempoAula;
		private $ativo;
		private $excluido;

		public function __construct($descricao, $comentarios, $tempos, $idTurma, $recursos, $tempoAula, $idProfessor, $idSala, $idAgregacao = 0, $ativo = "1", $excluido = "0"){
			$this->descricao = $descricao;
			$this->comentarios = $comentarios;
			$this->tempos = $tempos;
			$this->idTurma = $idTurma;
			$this->recursos = $recursos;
			$this->tempoAula = $tempoAula;
			$this->idProfessor = $idProfessor;
			$this->idSala = $idSala;
			$this->idAgregacao = $idAgregacao;
			$this->ativo = $ativo;
			$this->excluido = $excluido;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
		}

		public function getComentarios(){
			return $this->comentarios;
		}

		public function setComentarios($comentarios){
			$this->comentarios = $comentarios;
		}

		public function getTempos(){
			return $this->tempos;
		}

		public function setTempos($tempos){
			$this->tempos = $tempos;
		}

		public function getIdTurma(){
			return $this->idTurma;
		}

		public function setIdTurma($idTurma){
			$this->idTurma = $idTurma;
		}

		public function getRecursos(){
			return $this->recursos;
		}

		public function setRecursos($recursos){
			$this->recursos = $recursos;
		}

		public function getTempoAula(){
			return $this->tempoAula;
		}

		public function setTempoAula($tempoAula){
			$this->tempoAula = $tempoAula;
		}
		
		public function getIdProfessor(){
			return $this->idProfessor;
		}

		public function setIdProfessor($idProfessor){
			$this->idProfessor = $idProfessor;
		}

		public function getIdSala(){
			return $this->idSala;
		}

		public function setIdSala($idSala){
			$this->idSala = $idSala;
		}

		public function getIdAgregacao(){
			return $this->idAgregacao;
		}

		public function setIdAgregacao($idAgregacao){
			$this->idAgregacao = $idAgregacao;
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