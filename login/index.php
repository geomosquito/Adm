<?php
  session_start();
  if(isset($_SESSION["IPE_GEOMOSQUITO_nomePesquisador"])){
    if($_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] != ""){
      header("location: sucesso.php");
      return;
    }
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="viewport" content="maximum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    
  <link rel="stylesheet" href="../css/site.css">
  <script src="../app.js"></script>

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
          Login IPE</h1>
    </div>
  </nav>

  <form>
    <div class="imgcontainer">
        <img src="../img/escudo.png" alt="Escudo" class="avatar">
    </div>

    <div class="container">
        <label for="email"><b>Email do Pesquisador</b></label>
        <input type="text" placeholder="Informe o email do Pesquisador" name="email" id="email" required>

        <label for="senha"><b>Senha de Acesso</b></label>
        <input type="password" placeholder="Informa a senha cadastrada" name="senha" id="senha" required>

        <button type="submit">Logar</button>
    </div>
  </form>
</body>

</html>





