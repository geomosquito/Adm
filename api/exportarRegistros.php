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
      <th scope=\"col\">Código Tubo</th>
      <th scope=\"col\">Data Coleta</th>
      <th scope=\"col\">Latitude</th>
      <th scope=\"col\">Longitude</th>
      <th></th>
    </tr>
  </thead>
  <tbody>";

      $conn = Connection();
      $stmt = $conn->prepare("SELECT * FROM coleta");
      $stmt->execute();
      
      while($row = $stmt->fetch()){
        $html .= "<tr>";
        $html .= "<th scope='row'>".$row["idColeta"]."</th>";
        $html .= "<td>".$row["codigoTubo"]."</td>";
        $html .= "<td>".$row["dataColeta"]."</td>";
        $html .= "<td>".$row["latitude"]."</td>";
        $html .= "<td>".$row["longitude"]."</td>";
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
    header ("Content-Disposition: attachment; filename=\"registros.xls\"");
    header ("Content-Description: PHP Generated Data" );

    echo $html;
?>