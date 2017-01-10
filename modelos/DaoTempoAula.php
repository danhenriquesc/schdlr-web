<?php 
	require_once("Conexao.php");

	class DaoTempoAula{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoTempoAula();

			return self::$instancia;
		}

		public function CarregarPorSala($salaId){
			try{
				$sql = "SELECT * FROM sala_tempoaula WHERE Sala_idSala = :salaId";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":salaId", $salaId);
				$p_sql->execute();

				$dias = array("SEG", "TER", "QUA", "QUI", "SEX", "SAB","DOM");
				$turnos = array("M","T","N");
				$aulas = array();

				for($i = 0; $i < sizeof($dias); $i++){
					for($j = 0; $j < sizeof($turnos); $j++){
						for($k = 1; $k<=6; $k++){
							$aulas[$dias[$i]][$turnos[$j].$k] = 0;
						}
					}
				}

				$consulta = $p_sql->fetchAll();

				foreach ($consulta as $key => $value) {
					$aulas[$value["TempoAula_dia"]][$value["TempoAula_horario"]] = 1;
				}

				return $aulas;
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function CarregarPorAgregacao($agregacaoId, $tempos=1){
			try{
				$sql = "SELECT * FROM agregacao_tempoaula WHERE Agregacao_idAgregacao = :agregacaoId";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":agregacaoId", $agregacaoId);
				$p_sql->execute();

				$dias = array("SEG", "TER", "QUA", "QUI", "SEX", "SAB","DOM");
				$turnos = array("M","T","N");
				$horarios = array();
				$horarios_flip = array();
				$aulas = array();

				for($j = 0; $j < sizeof($turnos); $j++){
					for($k = 1; $k<=6; $k++){
						$horarios[] = $turnos[$j].$k;
					}
				}
				$horarios_flip = array_flip($horarios);

				for($i = 0; $i < sizeof($dias); $i++){
					for($j = 0; $j < sizeof($turnos); $j++){
						for($k = 1; $k<=6; $k++){
							$aulas[$dias[$i]][$turnos[$j].$k] = 0;
						}
					}
				}

				$consulta = $p_sql->fetchAll();

				foreach ($consulta as $key => $value) {
					$indice = $horarios_flip[$value["TempoAula_horario"]];
					for($i = 0; $i<$tempos; $i++){
						$aulas[$value["TempoAula_dia"]][$horarios[$indice+$i]] = 1;
					}
				}

				return $aulas;
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}
	}
?>