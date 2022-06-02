<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include_once 'connection.php';

if(!isset($_POST["codigoTubo"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Faltou o número do tubo"
    );
} else {
    $codigoTubo = $_POST["codigoTubo"];
}
if(!isset($_POST["incidencia"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Faltou o número de incidência dos mosquitos"
    );
} else {
    $incidencia = $_POST["incidencia"];
}
if(!isset($_POST["latitude"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Faltou a latitude da coordenada do coletor"
    );
} else {
    $latitude = $_POST["latitude"];
}
if(!isset($_POST["longitude"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Faltou a longitude da coordenada do coletor"
    );
} else {
    $longitude = $_POST["longitude"];
}
if(!isset($_POST["qtdIndividuos"])){
    $retorno = array(
        "result" => "fail",
        "message" => "Faltou a quantidade de Indivíduos "
    );    
} else {
    $qtdIndividuos = $_POST["qtdIndividuos"];
}

if(isset($retorno)){
    echo json_encode($retorno);
    return;
}

$conn = connection();
$sql = "INSERT INTO coleta (codigoTubo, incidencia, latitude, longitude, qtdIndividuos) VALUES (?, ?, ?, ?, ?)";
$comando = $conn->prepare($sql);

try {
    if($comando->execute(array($codigoTubo, $incidencia, $latitude , $longitude, $qtdIndividuos))){
        $retorno = array(
            "result" => "success",
            "message" => "Coletado com sucesso"
        );
    } else {
        $retorno = array(
            "result" => "fail",
            "message" => "Erro ao gravar a coleta"
        );
    }
} catch (\Throwable $th) {
    $retorno = array(
        "result" => "fail",
        "message" => "Erro ao gravar a coleta: " . $th
    );
}
//retorna
echo json_encode($retorno);
