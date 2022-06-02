//Assim que o document é carregado, executa o DOMContentLoaded
document.addEventListener("DOMContentLoaded", function(event) {
    //atribui um evento ao submit do form
    document.querySelector("form").addEventListener('submit', (event)=>{
        //Cancela o evento padrão do submit
        event.preventDefault();
        gravar();
    }); 
});

function exportar(){
    window.location.href = "../api/exportarResultados.php";
}

function apagar(id, tubo, especie){
    $('.preloader').fadeIn();
    const xhr = new XMLHttpRequest();
    //Uma espécie de listening que aguarda o retorno do xhr.send()
    xhr.onreadystatechange = function(){
        if(this.readyState === 4){ //4 é quando retorna do servidor
            let _mensagem = "";
            let _resultado = "Erro";
            let _icone = "error";

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
            } else{
                location.reload();
            }

            document.getElementById("id").value = "";
            document.getElementById("tubo").value = "";
            document.getElementById("idEspecie").value = "";
            document.getElementById("porcentagem").value = "";
        }
    }

    //Define o parâmetros para fazer um AJAX
    xhr.open("POST", `../api/apagarResultado.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}&tubo=${tubo}&especie=${especie}`);
}

function apagarPergunta(id){
    Swal.fire({
        title: 'Exclusão!',
        text: `Tem certeza que quer excluir o Resultado [ID: ${id}]?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, Apagar esse resultado!',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            apagar(id);
        }
      });
}

function gravar() {
    $('.preloader').fadeIn();
    var id = document.getElementById("id").value;
    var tubo = document.getElementById("tubo").value;
    var idEspecie = document.getElementById("idEspecie").value;
    var porcentagem = document.getElementById("porcentagem").value;

    const xhr = new XMLHttpRequest();
    //Uma espécie de listening que aguarda o retorno do xhr.send()
    xhr.onreadystatechange = function(){
        if(this.readyState === 4){ //4 é quando retorna do servidor
            let _mensagem = "";
            let _resultado = "Erro";
            let _icone = "error";

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
            } else{
                location.reload();
            }
        }
    }

    //Define o parâmetros para fazer um AJAX
    xhr.open("POST", `../api/gravarResultado.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}&tubo=${tubo}&idEspecie=${idEspecie}&porcentagem=${porcentagem}`);
}