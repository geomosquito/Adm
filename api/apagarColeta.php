<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de apagar uma Coleta de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];
}

if(isset($retorno)){
    http_response_code($retorno["state"]);
    echo json_encode($retorno);
    return;
}
$conn = Connection();
//Pode excluir
$sql = "DELETE FROM coleta WHERE idColeta = ?";
$stmt = $conn->prepare($sql);
try {
    $stmt->execute(array($id));
    if($stmt->rowCount()){
        $retorno = array(
            "result" => "success",
            "message" => "A Coleta $id foi excluída com sucesso",
            "state" => 200
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "A Coleta $id não pode ser excluída. Contate o administrador",
            "state" => 500
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao tentar apagar a coleta $id: " . $th,
        "state" => 500
    );
}      
   
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

