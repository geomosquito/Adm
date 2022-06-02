function initMap() {
  const image =
  "../img/bullet.png";

  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 9,
    center: { lat: -23.1080776, lng: -46.2944139 },
    mapTypeId: 'satellite'
  });

  getMarkers(map, image);
}
  
function getMarkers(map, image){
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

window.initMap = initMap;