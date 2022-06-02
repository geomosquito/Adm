<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["email"]) || !isset($_POST["senha"])){
    $retorno = array(
        "result" => "fail",
        "message" => "O email e a senha do pesquisador são obrigatórios"
    );
    echo json_encode($retorno);
    return;
} else {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
}

$conn = connection();
$stmt = $conn->prepare("SELECT * FROM pesquisador WHERE emailPesquisador = ? and senha = MD5(?)");
$stmt->execute(array($email, $senha));

if($row = $stmt->fetch()){
    $retorno = array(
        "result" => "success",
        "message" => "Bem vindo! " . $row["nomePesquisador"],
        "dados" => array(
            "nomePesquisador" => $row["nomePesquisador"],
            "emailPesquisador" => $row["emailPesquisador"]
        ),
        "state" => 200
    );

    //Inicia um SESSION
    session_start();
    $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] = $row["nomePesquisador"];
    $_SESSION["IPE_GEOMOSQUITO_senhaPesquisador"] = $row["emailPesquisador"];
} else {
    $retorno = array(
        "result" => "fail",
        "message" => "O email $email e senha $senha são inválidos",
        "dados" => array(
            "nomePesquisador" => "",
            "emailPesquisador" => ""
        ),
        "state" => 500
    );    
}

unset($conn);
http_response_code($retorno["state"]);
echo json_encode($retorno);
return;
