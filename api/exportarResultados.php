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
      <th scope=\"col\">Codigo Tubo</th>
      <th scope=\"col\">Especie</th>
      <th scope=\"col\">Porcentagem</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>";
      $conn = Connection();
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
        $html .= "<tr>";
        $html .= "<th scope='row'>".$row["idResultado"]."</th>";
        $html .= "<td>".$row["codigoTubo"]."</td>";
        $html .= "<td>".$row["nomeEspecie"]."</td>";
        $html .= "<td>".$row["percentagemEspecie"]."</td>";
      }

      unset($conn);
  $html .="</tbody>
  </table>";

    // Configurações header para forçar o download
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"resultados.xls\"");
    header ("Content-Description: PHP Generated Data" );

    echo $html;
?>