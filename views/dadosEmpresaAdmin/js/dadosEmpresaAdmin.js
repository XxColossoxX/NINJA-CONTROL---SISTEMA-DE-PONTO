let foto64 = ""; 
let cameraStream = null;

const endereco = {
    numero: 0 ,
    rua: '',
    bairro: '',
    estado: '',
    cep: ''
};


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

    $("#btnLoc").on('click', function(){
        locEmpresa();
    })

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

    $("#btnSalvarEndereco").on('click', function(){
        updateDadosLoc();
    })

    $("#fechar-modal-edicao").on('click', function(){
        setTimeout(() => {
            location.reload();
        }, 10);
    })

    $("#inputCep").on('input',function(){
        let cep = $(this).val();

        if(cep.length === 8){
            buscarEnderecoPorCepGoogle(cep);
        }
    });

    $("#abrir-modal-endereco").on('click',function(){
        verificaLoc();
    })

    const abrirModalEndereco = $("#abrir-modal-endereco");
    const modalEndereco = $("#modal-endereco");
    const fecharModalEndereco = $("#fechar-modal-endereco");

    abrirModalEndereco.on("click", function(){
        modalEndereco.removeClass("hidden");
    });

    fecharModalEndereco.on("click", function(){
        modalEndereco.addClass("hidden");
    })

    //FUNCOES:
    async function locEmpresa() {
        loaderM('Carregando informações da Localização',true)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    console.log(`Latitude: ${lat}, Longitude: ${lng}`);
                    getEndereco(lat, lng);
                },
                (error) => {
                    console.error("Erro ao obter localização:", error.message);
                },
                {
                    enableHighAccuracy: true, // Força o uso do GPS com mais precisão
                    timeout: 5000, // Tempo máximo para tentar pegar a localização
                    maximumAge: 0 // Não usar dados de localização cacheados
                }
            );
        }
    };

    function getEndereco(latitude, longitude) {
       const apiKey = 'AIzaSyDwpxfS7AptP74paz0S889G-uy4hE9bJV4';

        const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;
        console.log(latitude,longitude)

        fetch(url)
            .then(response => response.json())
            .then(data => {
            if (data.status === "OK") {
                endereco.numero = data.results[0].address_components[0]['long_name'];
                endereco.rua = data.results[0].address_components[1]['short_name'];
                endereco.bairro = data.results[0].address_components[2]['long_name'];
                endereco.cidade = data.results[0].address_components[3]['long_name'];
                endereco.estado = data.results[0].address_components[4]['long_name'];
                endereco.cep = data.results[0].address_components[6]['long_name'];

                $("#inputRua").val(endereco.rua);
                $("#inputNro").val(endereco.numero);
                $("#inputBairro").val(endereco.bairro);
                $("#inputCidade").val(endereco.cidade);
                $("#inputEstado").val(endereco.estado);
                $("#inputCep").val(endereco.cep);

                showAlert("Verifique se os dados estão corretos!","info")

                setTimeout(() => {
                    loaderM("", false); 
                }, 2000)
            } else {
                console.error("Erro na geocodificação:", data.status);
                setTimeout(() => {
                    loaderM("", false); 
                }, 2000)            }
        }).catch(error => console.error("Erro na requisição:", error));
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

    async function buscarEnderecoPorCepGoogle(cep) {
        const url = `https://viacep.com.br/ws/${cep}/json/`;

        try {
            const response = await axios.get(url);
            const data = response.data;

            if (!data.erro) {
                endereco.rua = data.logradouro;
                endereco.bairro = data.bairro;
                endereco.cidade = data.localidade;
                endereco.estado = data.estado;
                endereco.cep = data.cep;

                $("#inputRua").val(endereco.rua);
                $("#inputBairro").val(endereco.bairro);
                $("#inputCidade").val(endereco.cidade);
                $("#inputEstado").val(endereco.estado);
                $("#inputCep").val(endereco.cep);
                $("#inputNro").val('');

            } else {
                showAlert("CEP não encontrado", "warning");
            }
        } catch (e) {
            showAlert("Erro ao conectar com o ViaCEP", "error");
        }
    };

    async function updateDadosLoc(){
        endereco.cep = $("#inputCep").val();
        endereco.rua = $("#inputRua").val();
        endereco.numero = $("#inputNro").val();
        endereco.bairro = $("#inputBairro").val();
        endereco.cidade = $("#inputCidade").val();
        endereco.estado = $("#inputEstado").val();

        const enderecoString = [
            endereco.rua,
            endereco.numero,
            endereco.bairro,
            endereco.cep,
            endereco.cidade,
            endereco.estado
          ].join(", ");          

        const res = await axios({
            url: "../../backend/backend.php",
            method: "POST",
            data: {
                function: "updateLocEmpresa",
                ID_EMPRESA: sessionStorage.getItem('empresa_id'),
                LOC_EMPRESA: enderecoString
            },
        });  
        if(res.data.success){
            showAlert("Localização Inserida","success")
            $("#modal-endereco").hide()
        }
    };

    async function verificaLoc(){
        const res = await axios({
            url: "../../../backend/backend.php",
            method: "POST",
            data: {
                function: "getLocEmpresa",
            },
        });
        if(res.data){
           loc = res.data[0]['LOC_EMPRESA'];
            locSeparada = loc.split(', ');
            $("#inputRua").val(locSeparada[0])
            $("#inputNro").val(locSeparada[1]);
            
            $("#inputBairro").val(locSeparada[2]);
            $("#inputCep").val(locSeparada[3]);
            $("#inputCidade").val(locSeparada[4]);
            $("#inputEstado").val(locSeparada[5]);
        }
    }
});
