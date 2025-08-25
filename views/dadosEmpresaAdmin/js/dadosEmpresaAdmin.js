let foto64 = ""; 
let cameraStream = null;


$(document).ready( async function() {    
    $('#controlador').removeClass('hidden');

    getDadosEmpresa()

    Inputmask("99.999.999/9999-99").mask("#inputCnpj");
    Inputmask("(99)99999-9999").mask("#inputTelefone");

    $('#btn-editar-empresa').on('click', function () {
        $('#modal-editar-empresa').removeClass('hidden');
    });

    $('#fechar-modal-edicao').on('click', function () {
        $('#modal-editar-empresa').addClass('hidden');
    });
    
    $("#btnSalvar").on('click', async function() {
        const nome = $('#inputNomeFantasia').val();
        const endereco = $('#inputEndereco').val();
        const telefone = $('#inputTelefone').val();
        const email = $('#inputEmail').val();
        const descricao = $('#inputDescricao').val();
        const cnpj = $('#inputCnpj').val();

        const res = await axios({
            url: "../../backend/backend.php",
            method: "POST",
            data: {
                function: "updateEmpresa",
                RAZAO_FANTASIA: nome,
                LOC_EMPRESA: endereco,
                TEL_EMPRESA: telefone,
                EMAIL_EMPRESA: email,
                DSC_EMPRESA: descricao,
                CNPJ_EMPRESA: cnpj,
                ID_EMPRESA: sessionStorage.getItem('empresa_id')
            },
        });  
        if(res.data.success){
            showAlert('Dados atualizados com sucesso!',"success");
            $("#modal-editar-empresa").addClass("hidden");
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showAlert('Erro ao atualizar dados. Tente novamente.',"error");
        }
    });

    $('#inputEndereco').on('focus', function () {
        locEmpresa();
    });

    //FUNCOES:
    async function locEmpresa(){
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            getEndereco(lat, lng);
            },
            (error) => {
            console.error("Erro ao obter localização:", error.message);
            }
        );
        }
    };

    function getEndereco(latitude, longitude) {
    const apiKey = 'AIzaSyBqt1LWE7_-MKKThz0YpgSJLWnRM5sQAWE';

    const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
        if (data.status === "OK") {
            const enderecoCompleto = data.results[0].formatted_address;
            console.log("Endereço:", enderecoCompleto);
        } else {
            console.error("Erro na geocodificação:", data.status);
        }
        })
        .catch(error => console.error("Erro na requisição:", error));
    };

    async function getDadosEmpresa(){
        const res = await axios({
            url: "../../../backend/backend.php",
            method: "POST",
            data: {
                function: "getDadosEmpresa",
            },
        })
        console.log(res.data);
        if(res.data.length > 0){
            const empresa = res.data[0];
            $('#inputNomeFantasia').val(empresa.RAZAO_FANTASIA);
            $('#inputCnpj').val(empresa.CNPJ_EMPRESA);
            $('#inputEndereco').val(empresa.LOC_EMPRESA);
            $('#inputTelefone').val(empresa.TEL_EMPRESA);
            $('#inputEmail').val(empresa.EMAIL_EMPRESA);
            $('#inputDescricao').val(empresa.DSC_EMPRESA);

            $('#spanNome').text(empresa.RAZAO_FANTASIA);
            $('#spanCnpj').text(empresa.CNPJ_EMPRESA);
            $('#spanEndereco').text(empresa.LOC_EMPRESA);
            $('#spanTelefone').text(empresa.TEL_EMPRESA);
            $('#spanEmail').text(empresa.EMAIL_EMPRESA);
            $('#spanDescricao').text(empresa.DSC_EMPRESA);
        }
    };
});
