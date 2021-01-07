
create database tetris_bd;
use tetris_bd;

CREATE TABLE `usuario` (
  `id_usuario` int(1) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(254) NOT NULL,
  `data_nasc` date NOT NULL,
  `CPF` varchar(14) NOT NULL UNIQUE,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL UNIQUE,
  `senha` varchar(200) NOT NULL
);

CREATE TABLE `ranking` (
  `id_ranking` int(1) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `pontuacao_usu` integer(100) NOT NULL,
  `nivel_atingido` varchar(30) NOT NULL,
  `tempo_partida` integer(20) NOT NULL,
  `username_usu` varchar(200) NOT NULL,
  foreign key (username_usu) references usuario(username)
);

insert into usuario(`nome`, `data_nasc`, `CPF`, `telefone`, `email`, `username`, `senha`) VALUES ('jvccorsiferrera@hotmail.com', 0000-00-00, '23', '19 994753282', 'jvccorsiferrera@hotmail.com', 'cORSI', 'ASDAD');
insert into usuario(`nome`, `data_nasc`, `CPF`, `telefone`, `email`, `username`, `senha`) VALUES ('Fortnelson', 0000-00-00, '22222222', '19 222222', 'fort_bonitao@hotmail.com', 'fortnelson', 'fort123');
INSERT INTO `ranking`( `pontuacao_usu`, `nivel_atingido`, `tempo_partida`, `username_usu`) VALUES (3000,3,500,'cORSI');
INSERT INTO `ranking`( `pontuacao_usu`, `nivel_atingido`, `tempo_partida`, `username_usu`) VALUES (3000,3,500,'fortnelson');