<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"]) || !isset($_POST["especie"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de gravar uma espécie de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];
    $especie = $_POST["especie"];
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
    $sql = "SELECT * FROM especie WHERE nomeEspecie = ?";
    $comando = $conn->prepare($sql);
    $comando->execute(array($especie));

    if($row = $comando->fetch()){
        $retorno = array(
            "result" => "fail",
            "message" => "A espécie [$especie] já existe cadastrada.",
            "state" => 401
        );

        http_response_code($retorno["state"]);
        echo json_encode($retorno);
        return;
    }
    $sql = "INSERT INTO especie (nomeEspecie) VALUES (?)";
    $arr = array($especie);
} else {
    //Edição de espécie
    $sql = "UPDATE especie set nomeEspecie = ? WHERE idEspecie = ?";
    $arr = array($especie, $id);
}

try {
    $comando = $conn->prepare($sql);
    if($comando->execute($arr)){
        $retorno = array(
            "result" => "success",
            "message" => "A espécie [$especie] foi gravada com sucesso",
            "state" => 200
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "Erro ao gravar a espécie",
            "state" => 500
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao gravar a espécie: " . $th,
        "state" => 500
    );
}        
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

