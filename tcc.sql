-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23-Set-2016 às 21:06
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agregacao`
--

CREATE TABLE `agregacao` (
  `idAgregacao` int(11) NOT NULL,
  `tempos` int(11) NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Sala_idSala` int(11) DEFAULT NULL,
  `Professor_idProfessor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agregacao_recurso`
--

CREATE TABLE `agregacao_recurso` (
  `Agregacao_idAgregacao` int(11) NOT NULL,
  `Recurso_idRecurso` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `flexibilidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agregacao_tempoaula`
--

CREATE TABLE `agregacao_tempoaula` (
  `Agregacao_idAgregacao` int(11) NOT NULL,
  `TempoAula_dia` varchar(3) NOT NULL,
  `TempoAula_horario` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aula`
--

CREATE TABLE `aula` (
  `idAula` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `comentarios` varchar(45) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Turma_idTurma` int(11) NOT NULL,
  `Agregacao_idAgregacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `idCurso` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Instituto_idInstituto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Instituto_idInstituto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `idDisciplina` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `carga_horaria` varchar(45) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Departamento_idDepartamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina_curso`
--

CREATE TABLE `disciplina_curso` (
  `Disciplina_idDisciplina` int(11) NOT NULL,
  `Curso_idCurso` int(11) NOT NULL,
  `periodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituto`
--

CREATE TABLE `instituto` (
  `idInstituto` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `idProfessor` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Instituto_idInstituto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recurso`
--

CREATE TABLE `recurso` (
  `idRecurso` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `restricoes`
--

CREATE TABLE `restricoes` (
  `codRestricao` varchar(50) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala`
--

CREATE TABLE `sala` (
  `idSala` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `numero` int(11) NOT NULL,
  `capacidade` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Instituto_idInstituto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala_recurso`
--

CREATE TABLE `sala_recurso` (
  `Sala_idSala` int(11) NOT NULL,
  `Recurso_idRecurso` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala_tempoaula`
--

CREATE TABLE `sala_tempoaula` (
  `Sala_idSala` int(11) NOT NULL,
  `TempoAula_dia` varchar(3) NOT NULL,
  `TempoAula_horario` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tempoaula`
--

CREATE TABLE `tempoaula` (
  `dia` varchar(3) NOT NULL,
  `horario` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `idTurma` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `capacidade` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  `Disciplina_idDisciplina` int(11) NOT NULL,
  `CursoPreferencial_idCurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agregacao`
--
ALTER TABLE `agregacao`
  ADD PRIMARY KEY (`idAgregacao`);

--
-- Indexes for table `agregacao_recurso`
--
ALTER TABLE `agregacao_recurso`
  ADD PRIMARY KEY (`Agregacao_idAgregacao`,`Recurso_idRecurso`),
  ADD KEY `fk_Agregacao_has_Recursos/Requisitos_Recursos/Requisitos1_idx` (`Recurso_idRecurso`),
  ADD KEY `fk_Agregacao_has_Recursos/Requisitos_Agregacao1_idx` (`Agregacao_idAgregacao`);

--
-- Indexes for table `agregacao_tempoaula`
--
ALTER TABLE `agregacao_tempoaula`
  ADD PRIMARY KEY (`Agregacao_idAgregacao`,`TempoAula_dia`,`TempoAula_horario`),
  ADD KEY `fk_Agregacao_has_TempoAula_TempoAula1_idx` (`TempoAula_dia`,`TempoAula_horario`),
  ADD KEY `fk_Agregacao_has_TempoAula_Agregacao1_idx` (`Agregacao_idAgregacao`);

--
-- Indexes for table `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`idAula`,`Turma_idTurma`,`Agregacao_idAgregacao`),
  ADD KEY `fk_SalasNecessidade_Turma1_idx` (`Turma_idTurma`),
  ADD KEY `fk_Aula_Agregacao1_idx` (`Agregacao_idAgregacao`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idCurso`),
  ADD KEY `fk_Curso_Instituto1_idx` (`Instituto_idInstituto`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`),
  ADD KEY `fk_Departamento_Instituto1_idx` (`Instituto_idInstituto`);

--
-- Indexes for table `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`idDisciplina`),
  ADD KEY `fk_Disciplina_Departamento1_idx` (`Departamento_idDepartamento`);

--
-- Indexes for table `disciplina_curso`
--
ALTER TABLE `disciplina_curso`
  ADD PRIMARY KEY (`Disciplina_idDisciplina`,`Curso_idCurso`),
  ADD KEY `fk_Disciplina_has_Curso_Curso1_idx` (`Curso_idCurso`),
  ADD KEY `fk_Disciplina_has_Curso_Disciplina1_idx` (`Disciplina_idDisciplina`);

--
-- Indexes for table `instituto`
--
ALTER TABLE `instituto`
  ADD PRIMARY KEY (`idInstituto`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`idProfessor`),
  ADD KEY `fk_Professor_Instituto1_idx` (`Instituto_idInstituto`);

--
-- Indexes for table `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`idRecurso`);

--
-- Indexes for table `restricoes`
--
ALTER TABLE `restricoes`
  ADD PRIMARY KEY (`codRestricao`);

--
-- Indexes for table `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`idSala`),
  ADD KEY `fk_Sala_Instituto1_idx` (`Instituto_idInstituto`);

--
-- Indexes for table `sala_recurso`
--
ALTER TABLE `sala_recurso`
  ADD PRIMARY KEY (`Sala_idSala`,`Recurso_idRecurso`),
  ADD KEY `fk_Salas_has_Recursos/Requisitos_Recursos/Requisitos1_idx` (`Recurso_idRecurso`),
  ADD KEY `fk_Salas_has_Recursos/Requisitos_Salas1_idx` (`Sala_idSala`);

--
-- Indexes for table `sala_tempoaula`
--
ALTER TABLE `sala_tempoaula`
  ADD PRIMARY KEY (`Sala_idSala`,`TempoAula_dia`,`TempoAula_horario`),
  ADD KEY `fk_Sala_has_TempoAula_TempoAula1_idx` (`TempoAula_dia`,`TempoAula_horario`),
  ADD KEY `fk_Sala_has_TempoAula_Sala1_idx` (`Sala_idSala`);

--
-- Indexes for table `tempoaula`
--
ALTER TABLE `tempoaula`
  ADD PRIMARY KEY (`dia`,`horario`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`idTurma`,`Disciplina_idDisciplina`,`CursoPreferencial_idCurso`),
  ADD KEY `fk_Turma_Disciplina_idx` (`Disciplina_idDisciplina`),
  ADD KEY `fk_Turma_Curso1_idx` (`CursoPreferencial_idCurso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agregacao`
--
ALTER TABLE `agregacao`
  MODIFY `idAgregacao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aula`
--
ALTER TABLE `aula`
  MODIFY `idAula` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `idDisciplina` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instituto`
--
ALTER TABLE `instituto`
  MODIFY `idInstituto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `idProfessor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `recurso`
--
ALTER TABLE `recurso`
  MODIFY `idRecurso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sala`
--
ALTER TABLE `sala`
  MODIFY `idSala` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `turma`
--
ALTER TABLE `turma`
  MODIFY `idTurma` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `agregacao_recurso`
--
ALTER TABLE `agregacao_recurso`
  ADD CONSTRAINT `fk_Agregacao_has_Recursos/Requisitos_Agregacao1` FOREIGN KEY (`Agregacao_idAgregacao`) REFERENCES `agregacao` (`idAgregacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Agregacao_has_Recursos/Requisitos_Recursos/Requisitos1` FOREIGN KEY (`Recurso_idRecurso`) REFERENCES `recurso` (`idRecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `agregacao_tempoaula`
--
ALTER TABLE `agregacao_tempoaula`
  ADD CONSTRAINT `fk_Agregacao_has_TempoAula_Agregacao1` FOREIGN KEY (`Agregacao_idAgregacao`) REFERENCES `agregacao` (`idAgregacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Agregacao_has_TempoAula_TempoAula1` FOREIGN KEY (`TempoAula_dia`,`TempoAula_horario`) REFERENCES `tempoaula` (`dia`, `horario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `aula`
--
ALTER TABLE `aula`
  ADD CONSTRAINT `fk_Aula_Agregacao1` FOREIGN KEY (`Agregacao_idAgregacao`) REFERENCES `agregacao` (`idAgregacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_SalasNecessidade_Turma1` FOREIGN KEY (`Turma_idTurma`) REFERENCES `turma` (`idTurma`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_Curso_Instituto1` FOREIGN KEY (`Instituto_idInstituto`) REFERENCES `instituto` (`idInstituto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_Departamento_Instituto1` FOREIGN KEY (`Instituto_idInstituto`) REFERENCES `instituto` (`idInstituto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `fk_Disciplina_Departamento1` FOREIGN KEY (`Departamento_idDepartamento`) REFERENCES `departamento` (`idDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `disciplina_curso`
--
ALTER TABLE `disciplina_curso`
  ADD CONSTRAINT `fk_Disciplina_has_Curso_Curso1` FOREIGN KEY (`Curso_idCurso`) REFERENCES `curso` (`idCurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Disciplina_has_Curso_Disciplina1` FOREIGN KEY (`Disciplina_idDisciplina`) REFERENCES `disciplina` (`idDisciplina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `fk_Professor_Instituto1` FOREIGN KEY (`Instituto_idInstituto`) REFERENCES `instituto` (`idInstituto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `fk_Sala_Instituto1` FOREIGN KEY (`Instituto_idInstituto`) REFERENCES `instituto` (`idInstituto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `sala_recurso`
--
ALTER TABLE `sala_recurso`
  ADD CONSTRAINT `fk_Salas_has_Recursos/Requisitos_Recursos/Requisitos1` FOREIGN KEY (`Recurso_idRecurso`) REFERENCES `recurso` (`idRecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Salas_has_Recursos/Requisitos_Salas1` FOREIGN KEY (`Sala_idSala`) REFERENCES `sala` (`idSala`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `sala_tempoaula`
--
ALTER TABLE `sala_tempoaula`
  ADD CONSTRAINT `fk_Sala_has_TempoAula_Sala1` FOREIGN KEY (`Sala_idSala`) REFERENCES `sala` (`idSala`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sala_has_TempoAula_TempoAula1` FOREIGN KEY (`TempoAula_dia`,`TempoAula_horario`) REFERENCES `tempoaula` (`dia`, `horario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `fk_Turma_Curso1` FOREIGN KEY (`CursoPreferencial_idCurso`) REFERENCES `curso` (`idCurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Turma_Disciplina` FOREIGN KEY (`Disciplina_idDisciplina`) REFERENCES `disciplina` (`idDisciplina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
