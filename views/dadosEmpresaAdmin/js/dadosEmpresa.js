let foto64 = ""; 
let cameraStream = null;


$(document).ready( async function() {    
    $('#controlador').removeClass('hidden');
   setTimeout(() => {
}, 4000);

    $('#btn-editar-empresa').on('click', function () {
        $('#modal-editar-empresa').removeClass('hidden');
    });

    $('#fechar-modal-edicao').on('click', function () {
        $('#modal-editar-empresa').addClass('hidden');
    });
    
    $("#btnSalvarEdicao").on('click', async function() {
        const nome = $('#inputNome').val();
        const endereco = $('#inputEndereco').val();
        const telefone = $('#inputTelefone').val();
        const email = $('#inputEmail').val();
        const descricao = $('#inputDescricao').val();

        const res = await axios({
                url: "../../../backend/backend.php",
                method: "POST",
                data: {
                    function: "updateEmpresa",
                    RAZAO_FANTASIA: nome,
                    LOC_EMPRESA: endereco,
                    TEL_EMPRESA: telefone,
                    EMAIL_EMPRESA: email,
                    DSC_EMPRESA: descricao,
                },
            });  
    });

});
