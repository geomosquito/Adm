<?php
  session_start();
  if(!isset($_SESSION["IPE_GEOMOSQUITO_nomePesquisador"]) || $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] === ""){
    header("location: index.php");
    return;
  } else{
      $username = $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"];
  }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Menu Principal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="viewport" content="maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    
  <link rel="stylesheet" href="../css/site.css">

  <!--Necessário para as mensagens mais bonitas-->
  <link href="../fws/sweetalert/sweetalert2.min.css" rel="stylesheet" > 
  <!--Necessário para os ícones de enfeite-->
  <link href="../fws/fontawesome/all.min.css" rel="stylesheet" >

  <script src="../fws/sweetalert/sweetalert2.min.js"></script>  

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

  <style>

  </style> 
</head>

<body class="margin">

  <div class="preloader">
      <div class="spinloader-box">
          <div class="spinloader-effect"></div>
      </div>
  </div>

  <nav class="navbar navbar-light  bg-faded"  style="background-color: rgb(0, 91, 49);" >
    <div class="container-fluid" >
      <a class="navbar-brand" href="#">
        <img src="../img/ipe_branco_principal_semfundoo.png" alt="" width="200" height="100" class="d-inline-block align-text-top">
      </a>
      <h1  class="text-center" style="color: rgb(255, 221, 0)" style="font-family: Arial, Helvetica, sans-serif">
          Menu de Opções</h1>          
          <span class="username">Pesquisador: <?php echo $username?> (<a href="../api/logout.php">X</a>)</span>
    </div>
  </nav>

  <div class="imgcontainer">
        <img src="../img/ipe_colorido_simplificado-semfund.png" alt="IPE" width="350px">
  </div>


  <div class="container" style="padding: 10px">
    <div class="row" style="padding: 10px">
      <a href="../resultados/index.php" class="btn btn-success">Registrar Resultado</a>
    </div>
    <div class="row" style="padding: 10px">
      <a href="../especies/index.php" class="btn btn-success">Cadastrar Espécies</a>
    </div>
    <div class="row" style="padding: 10px">
      <a href="../pesquisadores/index.php" class="btn btn-success">Cadastrar Pesquisador</a>
    </div>
    <div class="row" style="padding: 10px">
      <a href="../registros/index.php" class="btn btn-success">Ver Registros</a>
    </div>
    <div class="row" style="padding: 10px">
      <a href="../registros/mapa.php" class="btn btn-success">Mapa de Incidência</a>
    </div>
  </div>
</body>

</html>