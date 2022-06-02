<?php
  session_start();
  if(!isset($_SESSION["IPE_GEOMOSQUITO_nomePesquisador"]) || $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] === ""){
    header("location: index.php");
    return;
  } else{
      $username = $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"];
      include_once "../api/connection.php";
  }

  $conn = Connection();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Registros</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="viewport" content="maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    
  <link rel="stylesheet" href="../css/site.css">
  <script src="app.js"></script>

  <!--Necessário para as mensagens mais bonitas-->
  <link href="../fws/sweetalert/sweetalert2.min.css" rel="stylesheet" > 
  <!--Necessário para os ícones de enfeite-->
  <link href="../fws/fontawesome/all.min.css" rel="stylesheet" >

  <script src="../fws/sweetalert/sweetalert2.min.js"></script>  

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
          Listagem de Registro de Coleta</h1>    
          <span class="username">Pesquisador: <?php echo $username?> (<a href="../api/logout.php">X</a>)</span>
    </div>
    <a href="../login/sucesso.php" style="padding-left:10px; color: #fff"> Voltar</a>
  </nav>


    <div class="imgcontainer">
          <img src="../img/mosquito.jpg" alt="resultados" width="200px">
    </div>
    
    <div class="container">
      <button type="button" class="btn btn-secondary" onclick="exportar()">Exportar XLS</button>
    </div>
    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Código Tubo</th>
        <th scope="col">Data Coleta</th>
        <th scope="col">Latitude</th>
        <th scope="col">Longitude</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php         
        $stmt = $conn->prepare("SELECT * FROM coleta");

        $stmt->execute();
        
        while($row = $stmt->fetch()){
          echo "<tr>";
          echo "<th scope='row'>".$row["idColeta"]."</th>";
          echo "<td>".$row["codigoTubo"]."</td>";
          echo "<td>".$row["dataColeta"]."</td>";
          echo "<td>".$row["latitude"]."</td>";
          echo "<td>".$row["longitude"]."</td>";
          echo "<td onclick=\"apagarPergunta(".$row["idColeta"].")\"><a href='#'>Excluir</a></td>";
        }

        unset($conn);
      ?>
    </tbody>
    </table>

</body>

</html>