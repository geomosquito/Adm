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
    window.location.href = "../api/exportarPesquisador.php";
}

function apagar(id, nome){
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
            document.getElementById("nome").value = "";
            document.getElementById("email").value = "";
            document.getElementById("senha").value = "";
        }
    }

    //Define o parâmetros para fazer um AJAX
    xhr.open("POST", `../api/apagarPesquisador.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}&especie=${nome}`);
}

function apagarPergunta(id, nome){
    Swal.fire({
        title: 'Exclusão!',
        text: `Tem certeza que quer excluir o Pesquisador [${nome}]?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, Apagar esse pesquisador!',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            apagar(id, nome);
        }
      });
}

function gravar() {
    $('.preloader').fadeIn();
    var id = document.getElementById("id").value;
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;

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
    xhr.open("POST", `../api/gravarPesquisador.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}&nome=${nome}&email=${email}&senha=${senha}`);
}