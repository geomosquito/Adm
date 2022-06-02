CREATE DATABASE Geomosquito;

USE Geomosquito;

CREATE TABLE coleta (
    idColeta INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    dataColeta TIMESTAMP,
	codigoTubo INTEGER,
	latitude DOUBLE,
	longitude DOUBLE,
	qtdIndividuos INTEGER,
	incidencia INTEGER
);

CREATE TABLE acessos (
    chave VARCHAR(50) NOT NULL
);

CREATE TABLE especie (
    idEspecie INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nomeEspecie VARCHAR(100)
);

CREATE TABLE pesquisador (
    idPesquisador INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nomePesquisador VARCHAR(100),
    emailPesquisador VARCHAR(100),
    senha VARCHAR(500)
);

CREATE TABLE resultado (
    idResultado INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    codigoTubo INTEGER,
    idEspecie INTEGER,
    percentagemEspecie DECIMAL
);


ALTER TABLE resultado ADD CONSTRAINT FK_RESULTADO_ESPECIE FOREIGN KEY(idEspecie) REFERENCES ESPECIE(idEspecie);