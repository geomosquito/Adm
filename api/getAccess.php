<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

extract($_REQUEST);

if(!isset($key)){
    $retorno = array(
        "result" => "fail",
        "message" => "Faltou a chave de acesso"
    );
    echo json_encode($retorno);
    return;
}

$conn = connection();
$stmt = $conn->prepare("SELECT * FROM acessos WHERE chave = ?");
$stmt->execute(array($key));

if($row = $stmt->fetch()){
    $retorno = array(
        "result" => "success",
        "message" => "Bem vindo!",
        "state" => 200
    );
} else {
    $retorno = array(
        "result" => "fail",
        "message" => "Chave inválida $key",
        "state" => 500
    );    
}

unset($conn);

echo json_encode($retorno);
