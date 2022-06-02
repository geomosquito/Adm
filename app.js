//Assim que o document é carregado, executa o DOMContentLoaded
document.addEventListener("DOMContentLoaded", function(event) {
    //atribui um evento ao submit do form
    document.querySelector("form").addEventListener('submit', (event)=>{
        //Cancela o evento padrão do submit
        event.preventDefault();
        login();
    });
});

function login(){   
    $('.preloader').fadeIn();
    let u = document.getElementById("email").value;
    let s = document.getElementById("senha").value;
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
            if(_resultado === "Sucesso"){
                window.open("../login/sucesso.php","_self");
            } else {
                //Exibe a mensagem
                Swal.fire({
                    title: _resultado,
                    icon: _icone,
                    text: _mensagem,
                    confirmButtonText: 'OK'
                });
            }
        }
    }
    //Define o parâmetros para fazer um AJAX
    xhr.open("POST", `../api/loginAccess.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`email=${u}&senha=${s}`);
}
