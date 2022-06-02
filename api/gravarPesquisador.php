<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["id"]) || !isset($_POST["nome"]) || !isset($_POST["email"]) || !isset($_POST["senha"]) ){
    $retorno = array(
        "result" => "fail",
        "message" => "Tentativa de gravar um Pesquisador de maneira errada",
        "state" => 500
    );
} else {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
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
    $sql = "SELECT * FROM pesquisador WHERE nomePesquisador = ? AND emailPesquisador = ?";
    $comando = $conn->prepare($sql);
    $comando->execute(array($nome, $email));

    if($row = $comando->fetch()){
        $retorno = array(
            "result" => "fail",
            "message" => "Um pesquisador com nome e email: [$nome - $email] já existe no cadastro.",
            "state" => 401
        );

        http_response_code($retorno["state"]);
        echo json_encode($retorno);
        return;
    }
    $sql = "INSERT INTO pesquisador (nomePesquisador, emailPesquisador, senha) VALUES (?, ?, ?)";
    $arr = array($nome, $email, MD5($senha));
} else {

    //Obtem a senha para verificar se foi alterada
    $sql = "SELECT * FROM pesquisador WHERE idPesquisador = ?";
    $comando = $conn->prepare($sql);
    $comando->execute(array($id));

    if($row = $comando->fetch()){
        if($senha != $row["senha"]){
            $senha = MD5($senha);
        }
    }

    $sql = "UPDATE pesquisador set nomePesquisador = ?, emailPesquisador = ?, senha = ? WHERE idPesquisador = ?";    
    $arr = array($nome, $email, $senha, $id);
}

try {
    $comando = $conn->prepare($sql);
    if($comando->execute($arr)){
        $retorno = array(
            "result" => "success",
            "message" => "O Pesquisador [$nome] foi gravado com sucesso",
            "state" => 200
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "Erro ao gravar o Pesquisador",
            "state" => 500
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao gravar o Pesquisador: " . $th,
        "state" => 500
    );
}        
//retorna
http_response_code($retorno["state"]);
echo json_encode($retorno);

