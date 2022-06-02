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
  <title>Resulados</title>
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
          Cadastro de Resultados</h1>    
          <span class="username">Pesquisador: <?php echo $username?> (<a href="../api/logout.php">X</a>)</span>
    </div>
    <a href="../login/sucesso.php" style="padding-left:10px; color: #fff"> Voltar</a>
  </nav>


  <form>
    <div class="imgcontainer">
          <img src="../img/resultados.png" alt="resultados" width="350px">
    </div>

    <div class="container">
        <input type="text" name="id" id="id" hidden>
        <label for="nome"><b>Código do Tubo</b></label>
        <input type="number" placeholder="Informe o código do tubo" name="tubo" id="tubo" min="1" required>

        <label for="idEspecie"><b>Espécie</b></label>
        <select name="idEspecie" class="form-select" id="idEspecie" required>
          <option selected disabled value=""> Selecionar</option>          
          <?php
        $stmt = $conn->prepare("SELECT * FROM especie ORDER BY nomeEspecie");
        $stmt->execute();
        
        while($row = $stmt->fetch()){
          echo "<option value=\"".$row["idEspecie"]."\">".$row["nomeEspecie"]."</option>";
        }
          ?>          
        </select>

        <label for="senha"><b>Porcentagem</b></label>
        <input type="number" placeholder="Informe a porcentagem encontrada" name="porcentagem" id="porcentagem"  min="1" max="100" required>

        <button type="submit">Gravar</button>
        <button type="button" class="btn btn-secondary" onclick="exportar()">Exportar XLS</button>
    </div>
  </form>

    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Código Tubo</th>
        <th scope="col">Espécie</th>
        <th scope="col">Porcentagem</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php         
        $stmt = $conn->prepare("SELECT 
            r.idResultado,
            r.codigoTubo,
            r.idEspecie,
            e.nomeEspecie,
            r.percentagemEspecie 
          FROM 
            resultado r
          INNER JOIN especie e ON e.idEspecie = r.idEspecie");

        $stmt->execute();
        
        while($row = $stmt->fetch()){
          echo "<tr>";
          echo "<th scope='row'>".$row["idResultado"]."</th>";
          echo "<td>".$row["codigoTubo"]."</td>";
          echo "<td>".$row["nomeEspecie"]."</td>";
          echo "<td>".$row["percentagemEspecie"]."</td>";
          echo "<td onclick=\"editar(".$row["idResultado"].",'".$row["codigoTubo"]."','".$row["idEspecie"]."','".$row["percentagemEspecie"]."')\"><a href='#'>Alterar</a></td>";
          echo "<td onclick=\"apagarPergunta(".$row["idResultado"].")\"><a href='#'>Excluir</a></td>";
        }

        unset($conn);
      ?>
    </tbody>
    </table>

</body>

</html>
<script>
  function editar(id, tubo, idEspecie, porcentagem){
    $("#id").val(id);
    $("#tubo").val(tubo);
    $("#idEspecie").val(idEspecie);
    $("#porcentagem").val(porcentagem);
  }
</script>