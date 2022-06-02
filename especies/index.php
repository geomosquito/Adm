<?php
  session_start();
  if(!isset($_SESSION["IPE_GEOMOSQUITO_nomePesquisador"]) || $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] === ""){
    header("location: index.php");
    return;
  } else{
      $username = $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"];
      include_once "../api/connection.php";
  }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Espécies</title>
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
          Cadastro de Espécies</h1>    
          <span class="username">Pesquisador: <?php echo $username?> (<a href="../api/logout.php">X</a>)</span>
    </div>
    <a href="../login/sucesso.php" style="padding-left:10px; color: #fff"> Voltar</a>
  </nav>


  <form>
    <div class="imgcontainer">
          <img src="../img/mosquito.jpg" alt="mosquito" width="250px">
    </div>

    <div class="container">
        <input type="text" name="id" id="id" hidden>
        <label for="email"><b>Espécie</b></label>
        <input type="text" placeholder="Digite uma nova espécie" name="especie" id="especie" required>

        <button type="submit">Gravar</button>
        <button type="button" class="btn btn-secondary" onclick="exportar()">Exportar XLS</button>

    </div>
  </form>

  <div class="container">
    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Espécies</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $conn = Connection();
        $stmt = $conn->prepare("SELECT * FROM especie ORDER BY nomeEspecie ");
        $stmt->execute();
        
        while($row = $stmt->fetch()){
          echo "<tr>";
          echo "<th scope='row'>".$row["idEspecie"]."</th>";
          echo "<td>".$row["nomeEspecie"]."</td>";
          echo "<td onclick=\"editar(".$row["idEspecie"].",'".$row["nomeEspecie"]."')\"><a href='#'>Alterar</a></td>";
          echo "<td onclick=\"apagarPergunta(".$row["idEspecie"].",'".$row["nomeEspecie"]."')\"><a href='#'>Excluir</a></td>";
        }

        unset($conn);
      ?>
    </tbody>
    </table>
  </div>

</body>

</html>
<script>
  function editar(id, especie){
    $("#id").val(id);
    $("#especie").val(especie);
  }
</script>