--DROP DATABASE TrabalhoMurylo;

CREATE DATABASE TrabalhoMurylo;

USE TrabalhoMurylo;

CREATE TABLE usuario (
  usuario varchar(8) NOT NULL,
  senha varchar(60) NOT NULL,
  nome varchar(50) NOT NULL
);

INSERT INTO usuario (usuario, senha, nome) 
VALUES 
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador'), -- senha admin
('usuario1', '6367c48dd193d56ea7b0baad25b19455e529f5ee', 'Usuario1'),  -- senha abc123
('mumf', '57b2ad99044d337197c0c39fd3823568ff81e48a', 'mumf'); -- senha p@ssw0rd

CREATE TABLE contato (
  idc bigint(20) NOT NULL,
  nomec varchar(60) NOT NULL,
  emailc varchar(60) NOT NULL
);

INSERT INTO contato (idc, nomec, emailc) VALUES
(1, 'João', 'joao@gmail.com'),
(2, 'Maria', 'maria@hotmail.com'),
(3, 'Carlos', 'carlos@terra.com.br'),
(4, 'Marcos', 'marcos@hotmail.com'),
(5, 'Ana', 'ana@hotmail.com'),
(6, 'Sonia', 'sonia@gmail.com');
