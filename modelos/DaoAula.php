<?php 
	require_once("Conexao.php");

	class DaoAula{
		public static $instancia;

		private function __construct(){
			//
		}

		public static function Instancia(){
			if (!isset(self::$instancia))
				self::$instancia = new DaoAula();

			return self::$instancia;
		}

		public function Inserir(Aula $aula){
			try{
				Conexao::Instancia()->beginTransaction();

				//Criando Nova Agregação
				$sql = "INSERT INTO agregacao (tempos, excluido, Sala_idSala, Professor_idProfessor) VALUES (:tempos, :excluido,:sala,:professor)";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":tempos", $aula->getTempos());
				$p_sql->bindValue(":sala", $aula->getIdSala());
				$p_sql->bindValue(":professor", $aula->getIdProfessor());
				$p_sql->bindValue(":excluido", $aula->getExcluido());
				
				$p_sql->execute();
				$agregacaoID = Conexao::Instancia()->lastInsertId();


				//Salvando Aula
				$sql = "INSERT INTO aula (descricao, comentarios, Turma_idTurma, Agregacao_idAgregacao, ativo, excluido) VALUES (:descricao, :comentarios, :idTurma, :idAgregacao, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":descricao", $aula->getDescricao());
				$p_sql->bindValue(":comentarios", $aula->getComentarios());
				$p_sql->bindValue(":idTurma", $aula->getIdTurma());
				$p_sql->bindValue(":idAgregacao", $agregacaoID);
				$p_sql->bindValue(":ativo", $aula->getAtivo());
				$p_sql->bindValue(":excluido", $aula->getExcluido());

				$p_sql->execute();

				//Salvando Recursos
				foreach ($aula->getRecursos() as $indice => $values) {
					if(isset($values['ativo']) && $values['ativo'] == "1"){
						$sql = "INSERT INTO agregacao_recurso (Agregacao_idAgregacao, Recurso_idRecurso, quantidade, flexibilidade) VALUES (:idAgregacao, :idRecurso, :quantidade, :flexibilidade)";
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idAgregacao", $agregacaoID);
						$p_sql->bindValue(":idRecurso", $indice);
						$p_sql->bindValue(":quantidade", $values['quantidade']);
						$p_sql->bindValue(":flexibilidade", $values['flexibilidade']);
						$p_sql->execute();
					}
				}

				//Salvando Horários
				foreach ($aula->getTempoAula() as $horario => $value) {
					if($value == "1"){
						$sql = "INSERT INTO agregacao_tempoaula (Agregacao_idAgregacao, TempoAula_dia, TempoAula_horario) VALUES (:idAgregacao, :dia, :horario)";
						list($dia, $tempo) = explode("-", $horario);
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idAgregacao", $agregacaoID);
						$p_sql->bindValue(":dia", $dia);
						$p_sql->bindValue(":horario", $tempo);
						$p_sql->execute();
					}
				}

				return Conexao::Instancia()->commit();

			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Agregar(Aula $aula){
			try{
				Conexao::Instancia()->beginTransaction();

				$agregacaoID = $aula->getIdAgregacao();

				//Salvando Aula
				$sql = "INSERT INTO aula (descricao, comentarios, Turma_idTurma, Agregacao_idAgregacao, ativo, excluido) VALUES (:descricao, :comentarios, :idTurma, :idAgregacao, :ativo, :excluido)";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":descricao", $aula->getDescricao());
				$p_sql->bindValue(":comentarios", $aula->getComentarios());
				$p_sql->bindValue(":idTurma", $aula->getIdTurma());
				$p_sql->bindValue(":idAgregacao", $agregacaoID);
				$p_sql->bindValue(":ativo", $aula->getAtivo());
				$p_sql->bindValue(":excluido", $aula->getExcluido());

				$p_sql->execute();

				return Conexao::Instancia()->commit();

			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Editar(Aula $aula, $id){
			try{
				Conexao::Instancia()->beginTransaction();

				//Atualizando Agregação
				$sql = "UPDATE agregacao SET tempos = :tempos, Sala_idSala = :sala, Professor_idProfessor = :professor WHERE idAgregacao = :idAgregacao";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":tempos", $aula->getTempos());
				$p_sql->bindValue(":sala", $aula->getIdSala());
				$p_sql->bindValue(":professor", $aula->getIdProfessor());
				$p_sql->bindValue(":idAgregacao", $aula->getIdAgregacao());
				$p_sql->execute();

				//Atualizando Aula
				$sql = "UPDATE aula SET descricao = :descricao, comentarios = :comentarios WHERE idAula = :id";
				$p_sql = Conexao::Instancia()->prepare($sql);

				$p_sql->bindValue(":id", $id);
				$p_sql->bindValue(":descricao", $aula->getDescricao());
				$p_sql->bindValue(":comentarios", $aula->getComentarios());
				$p_sql->execute();

				//Atualizando Recursos
				$sql = "DELETE FROM agregacao_recurso WHERE Agregacao_idAgregacao = :idAgregacao";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idAgregacao", $aula->getIdAgregacao());
				$p_sql->execute();

				foreach ($aula->getRecursos() as $indice => $values) {
					if(isset($values['ativo']) && $values['ativo'] == "1"){
						$sql = "INSERT INTO agregacao_recurso (Agregacao_idAgregacao, Recurso_idRecurso, quantidade, flexibilidade) VALUES (:idAgregacao, :idRecurso, :quantidade, :flexibilidade)";
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idAgregacao", $aula->getIdAgregacao());
						$p_sql->bindValue(":idRecurso", $indice);
						$p_sql->bindValue(":quantidade", $values['quantidade']);
						$p_sql->bindValue(":flexibilidade", $values['flexibilidade']);
						$p_sql->execute();
					}
				}

				//Atualizando Horarios
				$sql = "DELETE FROM agregacao_tempoaula WHERE Agregacao_idAgregacao = :idAgregacao";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idAgregacao", $aula->getIdAgregacao());
				$p_sql->execute();

				foreach ($aula->getTempoAula() as $horario => $value) {
					if($value == "1"){
						$sql = "INSERT INTO agregacao_tempoaula (Agregacao_idAgregacao, TempoAula_dia, TempoAula_horario) VALUES (:idAgregacao, :dia, :horario)";
						list($dia, $tempo) = explode("-", $horario);
						$p_sql = Conexao::Instancia()->prepare($sql);
						$p_sql->bindValue(":idAgregacao", $aula->getIdAgregacao());
						$p_sql->bindValue(":dia", $dia);
						$p_sql->bindValue(":horario", $tempo);
						$p_sql->execute();
					}
				}

				return Conexao::Instancia()->commit();

			}
			catch(Exception $e){
				Conexao::Instancia()->rollback();
				echo "Exception >>> ".$e;
			}
		}

		public function Ativar($id){
			try{
				$sql = "UPDATE aula SET ativo = 1 WHERE idAula=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Desativar($id){
			try{
				$sql = "UPDATE aula SET ativo = 0 WHERE idAula=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				return $p_sql->execute();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Excluir($id){
			try{
				Conexao::Instancia()->beginTransaction();

				/* Seta como excluido */
				$sql = "UPDATE aula SET excluido = 1 WHERE idAula=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				$p_sql->execute();

				/* Obtem agregação */
				$sql = "SELECT Agregacao_idAgregacao FROM aula WHERE idAula=:id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				$p_sql->execute();
				$ar = $p_sql->fetchAll();
				$idAgregacao = $ar[0]["Agregacao_idAgregacao"];

				/* Obtem aulas da agregacao */
				$sql = "SELECT * FROM aula WHERE Agregacao_idAgregacao=:idAgregacao AND excluido = 0";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idAgregacao", $idAgregacao);
				$p_sql->execute();
				$ar = $p_sql->fetchAll();

				/* Se não tiver mais aulas, exclui agregacao */
				if(sizeof($ar) == 0){
					$sql = "UPDATE agregacao SET excluido = 1 WHERE idAgregacao=:idAgregacao";
					$p_sql = Conexao::Instancia()->prepare($sql);
					$p_sql->bindValue(":idAgregacao", $idAgregacao);
					$p_sql->execute();
				}
				return Conexao::Instancia()->commit();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function Listar(){
			try{
				$sql = "SELECT * FROM aula WHERE excluido = 0";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarPorTurma($idTurma){
			try{
				$sql = "SELECT A.idAula, A.descricao, A.comentarios, A.Turma_idTurma as idTurma, A.ativo, A.excluido, A.Agregacao_idAgregacao as idAgregacao, agregacao.tempos ,
							(
							    SELECT GROUP_CONCAT(DISTINCT CONCAT('- ', disciplina.codigo, ' ', disciplina.nome, ' | ', turma.descricao, ' | ', aula.descricao) SEPARATOR '<br>') 
							 	FROM agregacao 
							 	INNER JOIN aula ON aula.Agregacao_idAgregacao = agregacao.idAgregacao 
							    INNER JOIN turma ON aula.Turma_idTurma = turma.idTurma
							    INNER JOIN disciplina ON turma.Disciplina_idDisciplina = disciplina.idDisciplina
							 	WHERE aula.excluido = 0 AND agregacao.idAgregacao = A.Agregacao_idAgregacao AND aula.idAula != A.idAula
							    GROUP BY agregacao.idAgregacao
							    ORDER BY aula.descricao
							) as agregacoes

							FROM aula as A
								INNER JOIN agregacao ON A.Agregacao_idAgregacao = agregacao.idAgregacao
									WHERE A.excluido = 0 and Turma_idTurma = :idTurma";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idTurma", $idTurma);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarPorAgregacao($idAgregacao, $idAula = 0){
			try{
				$sql = "SELECT aula.idAula, aula.descricao, aula.comentarios, aula.Turma_idTurma as idTurma, aula.ativo, aula.excluido, aula.Agregacao_idAgregacao as idAgregacao, agregacao.tempos, turma.descricao as turma, CONCAT(disciplina.codigo, ' ', disciplina.nome) as disciplina FROM aula
							INNER JOIN agregacao ON aula.Agregacao_idAgregacao = agregacao.idAgregacao
							INNER JOIN turma ON aula.Turma_idTurma = turma.idTurma
							INNER JOIN disciplina ON turma.Disciplina_idDisciplina = disciplina.idDisciplina
							WHERE aula.excluido = 0 AND aula.Agregacao_idAgregacao = :idAgregacao AND aula.idAula != :idAula";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":idAgregacao", $idAgregacao);
				$p_sql->bindValue(":idAula", $idAula);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function ListarAtivos(){
			try{
				$sql = "SELECT * FROM aula WHERE excluido = 0 and ativo=1";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		public function CarregarPorId($id){
			try{
				$sql = "SELECT aula.idAula, aula.descricao, agregacao.Sala_idSala, agregacao.Professor_idProfessor, aula.comentarios, aula.Turma_idTurma as idTurma, aula.ativo, aula.excluido, aula.Agregacao_idAgregacao as idAgregacao, agregacao.tempos FROM aula 
							INNER JOIN agregacao ON aula.Agregacao_idAgregacao = agregacao.idAgregacao
								WHERE idAula = :id";
				$p_sql = Conexao::Instancia()->prepare($sql);
				$p_sql->bindValue(":id", $id);
				$p_sql->execute();
				$ar = $p_sql->fetchAll();
				if(sizeof($ar) >= 1)
					return $ar[0];
				else
					return false;
			}
			catch(Exception $e){
				echo "Exception >>> ".$e;
			}
		}

		
	}
?>