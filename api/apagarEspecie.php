<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"]) || ($_POST["id"] === "" || $_POST["id"] == "0")){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de apagar uma espécie de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];

    if (isset($_POST["especie"])){
        $especie = "[".$_POST["especie"]."]";
    }
    $especie = "selecionada";
}

if(isset($retorno)){
    http_response_code($retorno["state"]);
    echo json_encode($retorno);
    return;
}

$conn = connection();
$stmt = $conn->prepare("SELECT idEspecie FROM resultado WHERE idEspecie = ?");
$stmt->execute(array($id));

if($row = $stmt->fetch()){
    $retorno = array(
        "result" => "fail",
        "message" => "A espécie $especie não pode ser excluída porque está sendo usada em resultados",
        "state" => 401
    );
} else {
    //Pode excluir
    $sql = "DELETE FROM especie WHERE idEspecie = ?";
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute(array($id));
        if($stmt->rowCount()){
            $retorno = array(
                "result" => "success",
                "message" => "A espécie [$especie] foi excluída com sucesso",
                "state" => 200
            );
        } else {
            $retorno = array(
                "result" => "fail",
                "message" => "A espécie [$especie] não pode ser excluída. Contate o administrador",
                "state" => 500
            );
        }
    } catch (\Throwable $th) {
        $retorno = array(
            "result" => "fail",
            "message" => "Erro ao tentar apagar a espécie $especie: " . $th,
            "state" => 500
        );
    }      
}
   
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

