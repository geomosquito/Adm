<?php

function Connection(){
    // conecta o banco de dados
    // para obter ajuda, consulte dev: lucas@colinesoft.com.br 
    $host='localhost';
    $banco = new PDO("mysql:host=$host;dbname=SEU_DB_NAME", "SEU_USER_NAME", "SUA_SENHA_DB",
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    return $banco;
}