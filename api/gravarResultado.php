<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"]) || !isset($_POST["idEspecie"]) || !isset($_POST["porcentagem"]) || !isset($_POST["tubo"]) ){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de gravar um Resultado de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];
    $tubo = $_POST["tubo"];
    $idEspecie = $_POST["idEspecie"];
    $porcentagem = $_POST["porcentagem"];
}

if(isset($retorno)){
    http_response_code($retorno["state"]);
    echo json_encode($retorno);
    return;
}

$conn = connection();

if($id === "" || $id === 0 ){
    //Nova espécie
    //Verifica se a mesma já não existe
    $sql = "SELECT * FROM resultado WHERE codigoTubo = ? AND idEspecie = ? AND percentagemEspecie = ?";
    $comando = $conn->prepare($sql);
    $comando->execute(array($tubo, $idEspecie, $porcentagem));

    if($row = $comando->fetch()){
        $retorno = array(
            "result" => "fail",
            "message" => "Um resultado com Código do Tubo, Espécie e mesma porcentagem já existe no cadastro.",
            "state" => 401
        );

        http_response_code($retorno["state"]);
        echo json_encode($retorno);
        return;
    }
    $sql = "INSERT INTO resultado (codigoTubo, idEspecie, percentagemEspecie) VALUES (?, ?, ?)";
    $arr = array($tubo, $idEspecie, $porcentagem);
} else {

    $sql = "UPDATE resultado set codigoTubo = ?, idEspecie = ?, percentagemEspecie = ? WHERE idResultado = ?";    
    $arr = array($tubo, $idEspecie, $porcentagem, $id);
}

try {
    $comando = $conn->prepare($sql);
    if($comando->execute($arr)){
        $retorno = array(
            "result" => "success",
            "message" => "O Resultado foi gravado com sucesso",
            "state" => 200
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "Erro ao gravar o Resultado",
            "state" => 500
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao gravar o Resultado: " . $th,
        "state" => 500
    );
}        
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

