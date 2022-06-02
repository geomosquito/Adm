<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

//Inicia um SESSION
session_start();
$_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] = "";
$_SESSION["IPE_GEOMOSQUITO_emailPesquisador"] = "";

header("location: ../login/index.php");