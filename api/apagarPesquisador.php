<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"]) || ($_POST["id"] === "" || $_POST["id"] == "0")){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de apagar um Pesquisador de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];

    if (isset($_POST["nome"])){
        $nome = "[".$_POST["nome"]."]";
    }
    $nome = "selecionado";
}

if(isset($retorno)){
    http_response_code($retorno["state"]);
    echo json_encode($retorno);
    return;
}

$conn = connection();
$stmt = $conn->prepare("SELECT count(idPesquisador) as total FROM pesquisador");
$stmt->execute(array($id));

if($row = $stmt->fetch()){
    if($row["total"] == 1){
        $retorno = array(
            "result" => "fail",
            "message" => "É obrigatório existir pelo menos um Pesquisador cadastrado",
            "state" => 401
        );
        //retorna
        http_response_code($retorno["state"]);
        echo json_encode($retorno);
        return;
    }
} 

//Pode excluir
$sql = "DELETE FROM pesquisador WHERE idPesquisador = ?";
$stmt = $conn->prepare($sql);
try {
    $stmt->execute(array($id));
    if($stmt->rowCount()){
        $retorno = array(
            "result" => "success",
            "message" => "O Pesquisador [$nome] foi excluído com sucesso",
            "state" => 200
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "O Pesquisador [$nome] não pode ser excluído. Contate o administrador",
            "state" => 500
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao tentar apagar o pesquisador $nome: " . $th,
        "state" => 500
    );
}      

   
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

