<?php
  session_start();
  if(!isset($_SESSION["IPE_GEOMOSQUITO_nomePesquisador"]) || $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"] === ""){
    header("location: index.php");
    return;
  } else{
      $username = $_SESSION["IPE_GEOMOSQUITO_nomePesquisador"];
      include_once "../api/connection.php";
  }

  $html = "
  <table>
  <thead>
    <tr>
      <th scope=\"col\">#</th>
      <th scope=\"col\">Especies</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>";
      $conn = Connection();
      $stmt = $conn->prepare("SELECT * FROM especie ORDER BY nomeEspecie ");
      $stmt->execute();
      
      while($row = $stmt->fetch()){
        $html .= "<tr>";
        $html .= "<th scope='row'>".$row["idEspecie"]."</th>";
        $html .= "<td>".$row["nomeEspecie"]."</td>";
      }

      unset($conn);
  $html .= "</tbody>
  </table>";

    // Configurações header para forçar o download
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"especies.xls\"" );
    header ("Content-Description: PHP Generated Data" );

    echo $html;
?>