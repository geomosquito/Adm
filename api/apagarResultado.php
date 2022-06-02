<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"]) || ($_POST["tubo"] == "0" || $_POST["tubo"] === "" || $_POST["especie"] == "")){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de apagar um Resultado de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];

    if (isset($_POST["tubo"])){
        $tubo = "[Tubo: ".$_POST["tubo"]." - ".$_POST["especie"]."]";
    }
    if (isset($_POST["tubo"])){
        $tubo = "[".$_POST["tubo"]."]";
    }
    $tubo = "selecionado";
}

if(isset($retorno)){
    http_response_code($retorno["state"]);
    echo json_encode($retorno);
    return;
}
$conn = Connection();
//Pode excluir
$sql = "DELETE FROM resultado WHERE idResultado = ?";
$stmt = $conn->prepare($sql);
try {
    $stmt->execute(array($id));
    if($stmt->rowCount()){
        $retorno = array(
            "result" => "success",
            "message" => "O Resultado $tubo do ID: $id foi excluído com sucesso",
            "state" => 200
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "O Resultado $tubo  do ID: $id não pode ser excluído. Contate o administrador",
            "state" => 500
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao tentar apagar o resultado $tubo para o ID: $id: " . $th,
        "state" => 500
    );
}      

   
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

