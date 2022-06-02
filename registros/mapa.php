<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Incidências</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="maximum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/site.css">
    <link href="../fws/sweetalert/sweetalert2.min.css" rel="stylesheet" > 
    <link href="../fws/fontawesome/all.min.css" rel="stylesheet" >
    <script src="../fws/sweetalert/sweetalert2.min.js"></script>  
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
   integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
   crossorigin=""/>
   
   <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>

   <style>
       #map { height: 1500px; }
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
          Mapa de Incidência</h1>          
    </div>
    <a href="../login/sucesso.php" style="padding-left:10px; color: #fff"> Voltar</a>

  </nav>
  <div id="map"></div>
</body>
</html>
<script>
	var map = L.map('map').setView([-23.1080776, -46.2944139 ], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var LeafIcon = L.Icon.extend({
        options: {
            //shadowUrl: 'leaf-shadow.png',
            iconSize:     [32, 32],
            //shadowSize:   [50, 64],
            //iconAnchor:   [22, 94],
            //shadowAnchor: [4, 62],
            //popupAnchor:  [-3, -76]
        }
    });

    var icone = new LeafIcon({iconUrl: '../img/bullet.png'});
    getMarkers(L, map, icone);

function getMarkers(L, map, image){
    $('.preloader').fadeIn();
    const xhr = new XMLHttpRequest();
    //Uma espécie de listening que aguarda o retorno do xhr.send()
    xhr.onreadystatechange = function(){
        if(this.readyState === 4){ //4 é quando retorna do servidor
            let _mensagem = "";
            let _resultado = "Erro";
            let _icone = "error";
            let _posicoes = [];

            //uTILIZEI O SWITCH PARA O CASO DE QUERER TESTAR OUTROS STATUS
            switch(this.status){
                case 404:
                    _mensagem = "404 - Página não encontrada.";
                    break;
                default:
                    //O retorno pode ser 200 (normal) ou qualquer erro de servidor
                    let result = JSON.parse(xhr.responseText);
                    _mensagem = xhr.status + " - " + result.message;
                    _icone = result.result === "fail" ? "error" : "success";
                    _resultado = result.result === "fail" ? "Erro" : "Sucesso";
                    _posicoes = result.posicoes;


                    break;
            }

            $('.preloader').fadeOut();
            
            //Retorna o result
            if(_resultado !== "Sucesso"){
                //Exibe a mensagem
                Swal.fire({
                    title: _resultado,
                    icon: _icone,
                    text: _mensagem,
                    confirmButtonText: 'OK'
                });
            } else {
              //Inicia a plotagem
              _posicoes.forEach(element => {
                /*GOOGLE MAPS
                let p = {lat: element.lat, lng:element.lng}
                new google.maps.Marker({
                  position: { lat: parseFloat(element.lat), lng: parseFloat(element.lng) },
                  map,
                  title: element.tubo,
                  icon: image
                });
                */
               /*leafletjs*/ 
               var tmp = L.marker([parseFloat(element.lat), 
                parseFloat(element.lng)], 
                {icon: image}).bindPopup(element.tubo).addTo(map);                            
              });
            }
        }
    }
    //Define o parâmetros para fazer um AJAX
    xhr.open("POST", `../api/getMarkersForMap.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
}
</script>