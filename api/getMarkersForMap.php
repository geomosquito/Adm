<?php

include_once "../api/connection.php";
$posicoes = array();

try {
    $conn = Connection();
    $stmt = $conn->prepare("SELECT * FROM coleta");
    $stmt->execute();
    
    
    while($row = $stmt->fetch()){
        $posicao = array(
            "tubo" => "tubo ".$row["codigoTubo"],
            "lat" => $row["latitude"],
            "lng" => $row["longitude"]
        );
    
        array_push($posicoes,$posicao);
    }
    $retorno = array(
        "result" => "success",
        "message" => "Coleta realizada",
        "state" => 200,
        "posicoes" => $posicoes
    );    
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Ocorreu um erro ao tentar realizar a coleta ". $th,
        "state" => 500        
    );    
}
unset($conn);
http_response_code($retorno["state"]);
echo json_encode($retorno);