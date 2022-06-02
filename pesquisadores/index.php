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
  <title>Pesquisadores</title>
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
          Cadastro de Pesquisadores</h1>    
          <span class="username">Pesquisador: <?php echo $username?> (<a href="../api/logout.php">X</a>)</span>
    </div>
    <a href="../login/sucesso.php" style="padding-left:10px; color: #fff"> Voltar</a>
  </nav>


  <form>
    <div class="imgcontainer">
          <img src="../img/pesquisador.png" alt="pesquisador" width="150px">
    </div>

    <div class="container">
        <input type="text" name="id" id="id" hidden>
        <label for="nome"><b>Nome do Pesquisador</b></label>
        <input type="text" placeholder="Informe o nome do pesquisador" name="nome" id="nome" required>

        <label for="email"><b>Email do Pesquisador</b></label>
        <input type="text" placeholder="Informe o email do pesquisador" name="email" id="email" required>

        <label for="senha"><b>Senha do Acesso</b></label>
        <input type="password" placeholder="Informe uma senha para o pesquisador" name="senha" id="senha" required>

        <button type="submit">Gravar</button>
        <button type="button" class="btn btn-secondary" onclick="exportar()">Exportar XLS</button>
    </div>
  </form>

    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $conn = Connection();
        $stmt = $conn->prepare("SELECT * FROM pesquisador ORDER BY nomePesquisador");
        $stmt->execute();
        
        while($row = $stmt->fetch()){
          echo "<tr>";
          echo "<th scope='row'>".$row["idPesquisador"]."</th>";
          echo "<td>".$row["nomePesquisador"]."</td>";
          echo "<td>".$row["emailPesquisador"]."</td>";
          echo "<td onclick=\"editar(".$row["idPesquisador"].",'".$row["nomePesquisador"]."','".$row["emailPesquisador"]."','".$row["senha"]."')\"><a href='#'>Alterar</a></td>";
          echo "<td onclick=\"apagarPergunta(".$row["idPesquisador"].",'".$row["nomePesquisador"]."')\"><a href='#'>Excluir</a></td>";
        }

        unset($conn);
      ?>
    </tbody>
    </table>

</body>

</html>
<script>
  function editar(id, nome, email, senha){
    $("#id").val(id);
    $("#nome").val(nome);
    $("#email").val(email);
    $("#senha").val(senha);
  }
</script>