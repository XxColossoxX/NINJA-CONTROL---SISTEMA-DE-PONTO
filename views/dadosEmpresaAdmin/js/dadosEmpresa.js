let foto64 = ""; 
let cameraStream = null;


$(document).ready( async function() {    
    $('#controlador').removeClass('hidden');

    Inputmask("99.999.999/9999-99").mask("#inputCnpj");
    Inputmask("(99)99999-9999").mask("#inputTelefone");

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
});
