function exportar(){
    window.location.href = "../api/exportarRegistros.php";
}

function apagar(id){
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
    xhr.open("POST", `../api/apagarColeta.php`);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`id=${id}`);
}

function apagarPergunta(id){
    Swal.fire({
        title: 'Exclusão!',
        text: `Tem certeza que quer excluir a Coleta [ID: ${id}]?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, Apagar essa coleta!',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
            apagar(id);
        }
      });
}
