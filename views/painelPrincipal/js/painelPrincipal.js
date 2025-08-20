let foto64 = ""; 
let id = '';
let dataMethod = ""; 
const tabela = $("#tblFuncionario tbody");


$(document).ready( async function() {
    carregarNomeEmpresa()

    Inputmask("999.999.999-99").mask("#inputCpfFuncionario");
    Inputmask("99.999.999-9").mask("#inputRgFuncionario");

    Inputmask("999.999.999-99").mask("#showCpf");
    Inputmask("99.999.999-9").mask("#showRg");

    await recarregaTabela();
    
//!BOTOES
$("#btnProximo").on('click', async function(){
    let inputNome   = $("#inputNomeFuncionario").val()
    let inputCpf    = $("#inputCpfFuncionario").val()
    let inputRg     = $("#inputRgFuncionario").val()
    let inputData   = $("#inputDataNascFuncionario").val()

    if(!inputNome || !inputCpf || !inputRg || !inputData) {
        showAlert("Preencha todos os campos!", "error");
        return;
    }
    $("#form-modal").addClass("hidden");
    $("#camera-modal").removeClass("hidden");
    await abrirCamera();

});

$('#add-employee-btn').on("click", async function(){
    dataMethod = "insert";
    id = '';

    $("#form-modal").removeClass("hidden");
    $("#inputNomeFuncionario").val('');
    $("#inputCpfFuncionario").val('');
    $("#inputRgFuncionario").val('');
    $("#inputSenhaFuncionario").val('');
    $("#inputDataNascFuncionario").val('');

    inputNome  = ('')  
    inputCpf   = ('')
    inputRg    = ('')
    inputData  = ('')
    inputSenha = ('')
});

$(document).on("click", ".delete-icon", async function () {
    const id = $(this).data("id");

    if (confirm("Tem certeza que deseja excluir este funcionário?")) {
        try {
            const res = await axios({
                url: "../../../backend/backend.php",
                method: "POST",
                data: {
                    function: "deletaFuncionario",
                    ID_FUNCIONARIO: id,
                },
            });

            if (res.data) {
                $(`i.delete-icon[data-id="${id}"]`).closest("tr").remove();
                $("#totalFunc").text(res.data.total_funcionarios_empresa);
                showAlert("Funcionário deletado!", "false");
            
            } else if (res.data.error) {
                showAlert("Erro: " + res.data.error, "true");
            }
        } catch (error) {
            console.error(error);
            showAlert("Erro na requisição!", "true");
        }
    }
});

$(document).on("click", ".edit-icon", async function () {
    id = $(this).data("id");
    dataMethod = "update";

    $("#inputNomeFuncionario").val('');
    $("#inputCpfFuncionario").val('');
    $("#inputRgFuncionario").val('');
    $("#inputSenhaFuncionario").val('');
    $("#inputDataNascFuncionario").val('')

    const res = await axios({
        url: "../../../backend/backend.php",
        method: "POST",
        data: {
            function: "loadDadosFuncionario",
            ID_FUNCIONARIO: id,
        },
    })
    console.log(res.data.data);
    $("#form-modal").removeClass("hidden");
    $("#inputNomeFuncionario").val(res.data.data.NOME_FUNCIONARIO);
    $("#inputCpfFuncionario").val(res.data.data.CPF);
    $("#inputRgFuncionario").val(res.data.data.RG);
    $("#inputSenhaFuncionario").val(res.data.data.SENHA_FUNCIONARIO);
    $("#inputDataNascFuncionario").val(res.data.data.DATA_NASCIMENTO);


});

//!FUNCOES
async function abrirCamera() {
    const video = document.getElementById("register-camera");
    const cameraError = document.getElementById("camera-error");
    const displayNome = document.getElementById("display-nome");
    const displayCpf = document.getElementById("display-cpf");
    const displayRg = document.getElementById("display-rg");
    const displayData = document.getElementById("display-data");
    const welcomeMessage = document.getElementById("welcome-message");
    const welcomeNome = document.getElementById("welcome-nome");
    let stream;

    // Preencher os dados do formulário na seção de dados
    const inputNome     = $("#inputNomeFuncionario").val();
    const inputCpf      = $("#inputCpfFuncionario").val();
    const inputRg       = $("#inputRgFuncionario").val();
    const inputData     = $("#inputDataNascFuncionario").val();
    const inputSenha    = $("#inputSenhaFuncionario").val()


    displayNome.textContent = inputNome;
    displayCpf.textContent = inputCpf;
    displayRg.textContent = inputRg;
    displayData.textContent = inputData;

    try {
        // Solicitar permissão para acessar a câmera
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.classList.remove("hidden");
        cameraError.classList.add("hidden");
    } catch (error) {
        console.error("Erro ao acessar a câmera:", error);
        cameraError.classList.remove("hidden");
        video.classList.add("hidden");
    }

    // Capturar a foto ao clicar no botão "Capturar"
    document.getElementById("btnCapturar").addEventListener("click", async function () {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Converter a imagem para Base64
        foto64 = canvas.toDataURL("image/png");
        console.log("Foto capturada:", foto64);


        // Exibir mensagem de boas-vindas
        welcomeNome.textContent = inputNome;
        welcomeMessage.classList.remove("hidden");

        if(dataMethod === "update") {
            const res = await axios({
                url: "../../../backend/backend.php",
                method: "POST",
                data: {
                    function: "updateFuncionario",
                    ID_FUNCIONARIO: id,
                    NOME_FUNCIONARIO: inputNome,
                    CPF: inputCpf,
                    DATA_NASCIMENTO: inputData,
                    SENHA_FUNCIONARIO: inputSenha,
                    RG: inputRg,
                    FACEID: foto64,
                },
            });  

            if (res.data.success) {
                showAlert(res.data.message, "success");
                $("#close-camera-modal").click();
                recarregaTabela();
                return
            } else {
                showAlert("Erro ao cadastrar funcionário.", "error");
                console.log(res.data);
            }      
        }

        if(dataMethod === "insert") {
            const res = await axios({
                url: "../../../backend/backend.php",
                method: "POST",
                data: {
                    function: "applyFuncionario",
                    NOME_FUNCIONARIO: inputNome,
                    CPF: inputCpf,
                    DATA_NASCIMENTO: inputData,
                    SENHA_FUNCIONARIO: inputSenha,
                    RG: inputRg,
                    FACEID: foto64,
                },
            });  

            if (res.data.success) {
                showAlert(res.data.message, "success");
                $("#close-camera-modal").click();
                recarregaTabela();
                return
            } else {
                showAlert("Erro ao cadastrar funcionário.", "error");
                console.log(res.data);
            }      
        }
    });

    return stream;
};

async function preencheTabela(res) {
    tabela.empty();
    if(res.data.length == 0) {
        const tabela    = $("#tblFuncionario tbody");
        const conteudo  = `
                    <tr class="border-b border-gray-200 hover:bg-gray-100 rounded-lg"> 
                        <td class="px-6 py-4 rounded-lg"></td>
                        <td class="px-6 py-4 rounded-lg"></td>
                        <td class="px-6 py-4 rounded-lg"></td>
                        <td class="px-6 py-4 rounded-lg"></td>
                        <td class="px-6 py-4 rounded-lg"></td>
                    </tr>
       
        `
        tabela.append(conteudo);
    }   


    for (let i = 0; i < res.data.length; i++) {
        let idFuncionario       = res.data[i].ID_FUNCIONARIO;
        let nomeFuncionario     = res.data[i].NOME_FUNCIONARIO;
        let cpfFuncionario      = res.data[i].CPF;
        let rgFuncionario       = res.data[i].RG;
        let imagemFuncionario   = res.data[i].FACEID;

        const tabela = $("#tblFuncionario tbody");
        const conteudo = `
            <tr class="border-b border-gray-200 hover:bg-gray-100 rounded-lg"> 
                <td class="px-4 py-2 text-center border-r-2 border-gray-100">${idFuncionario}</td>
                <td class="px-4 py-2 text-center border-r-2 border-gray-100 sm:rounded-tl-lg">${nomeFuncionario}</td>
                <td class="px-4 py-2 text-center border-r-2 border-gray-100 hidden md:table-cell">${cpfFuncionario}</td>
                <td class="px-4 py-2 text-center border-r-2 border-gray-100 hidden md:table-cell">${rgFuncionario}</td>
                <td class="px-4 py-2 flex justify-center items-center border-r-2 border-gray-100">
                    <div class="w-20 h-20 rounded-full border-4 border-gray-300 bg-center bg-cover" style="background-image: url('${imagemFuncionario}'); background-size: 200%;"></div>
                </td>
                <td class="px-2 py-1 text-center border-r-2 border-gray-100 ">
                    <i id="btnEdit" class="fas fa-edit text-blue-500 hover:text-blue-700 cursor-pointer edit-icon" data-id="${idFuncionario}" title="Editar"></i>
                
                </td>
                <td class="px-2 py-1 text-center">
                    <i class="fas fa-trash text-red-500 hover:text-red-700 cursor-pointer delete-icon" data-id="${idFuncionario}" id="btnDeletar" title="Excluir"></i>
                </td>
            </tr>
        `;
        tabela.append(conteudo);
    }
    if(res.data.length < 1){
        setTimeout(() => {
            showAlert("NÃO HÁ FUNCIONÁRIOS CADASTRADOS !", "error");
        }, 2000);        
    }
};

function loaderM(mensagem, mostrar) {
    // Se já existe, remove para evitar duplicidade
    $('#custom-loader-overlay').remove();

    if (mostrar) {
        // Cria overlay com spinner e mensagem
        const loaderHtml = `
        <div id="custom-loader-overlay" style="
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            gap: 1rem;
            font-family: Arial, sans-serif;
            color: white;
            font-size: 1.25rem;
        ">
            <div class="loader-spinner" style="
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
            "></div>
            <div>${mensagem}</div>
        </div>
        <style>
            @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
            }
        </style>
        `;

        $('body').append(loaderHtml);
    }
};

async function carregarNomeEmpresa() {
    const res = await axios({
            url: "../../../backend/backend.php",
            method: "POST",
            data: {
                function: "getNomeEmpresa",
            },
        });
    let nomeEmpresa = res.data[0].NOME_EMPRESA.toUpperCase();
    let divBemVindo = $("#bemVindo");
    let conteudo = `
    <div id="welcome-message" class="fixed inset-0 flex items-center justify-center z-50 text-center">
        <div>
            <h1 class="text-4xl text-white font-sans"><i><strong>BEM-VINDO(A) DE VOLTA</strong></i></h1>
            <h2 id="tituloEmpresa" class="text-2xl text-white font-sans underline text-center"><i><strong>${nomeEmpresa}</strong></i></h2>
        </div>
    </div>`;

    divBemVindo.append(conteudo);
    // Animação de entrada
    setTimeout(() => {
        $("#welcome-message").addClass("entrada");
    }, 100);

    // Animação de saída após 3s
    setTimeout(() => {
        const el = $("#welcome-message");
        el.removeClass("entrada");
        el.removeClass("saida");
        setTimeout(() => {
            el.remove();
            $(".controlador").removeClass("hidden");
            $("#controlador").removeClass("hidden");
        }, 500);
    }, 1500);
    return;
};

async function recarregaTabela() {
    const tabela = $("#tblFuncionario tbody");
    tabela.empty();

    await loadEmpresa()
    return
};

async function loadEmpresa(){
    tabela.empty();
    const res = await axios({
        url: "../../../backend/backend.php",
        method: "POST",
        data: {
            function: "loadPainel",
            
        },
    });
        await preencheTabela(res);
        $("totalFunc").empty();
        $("#totalFunc").text(res.data.length);
        return
};

function showAlert(message, type = "error") {
        const alertBox = document.getElementById("alert-box");
        const alertMessage = document.getElementById("alert-message");
    
        if (!alertBox || !alertMessage) {
            console.error("Elementos de alerta não encontrados no DOM.");
            return;
        }
    
        // Define a mensagem
        alertMessage.textContent = message;
    
        // Limpa classes antigas e aplica a cor conforme o tipo
        alertBox.classList.remove("hidden", "alert-hide", "bg-red-500", "bg-green-500");
    
        if (type === "success") {
            alertBox.classList.add("bg-green-500");
        } else {
            alertBox.classList.add("bg-red-500");
        }
    
        // Adiciona a animação de entrada
        alertBox.classList.add("alert-show");
    
        // Remove a animação de entrada após 3 segundos e adiciona a de saída
        setTimeout(() => {
            alertBox.classList.remove("alert-show");
            alertBox.classList.add("alert-hide");
    
            // Oculta o alerta após a animação de saída
            setTimeout(() => {
                alertBox.classList.add("hidden");
            }, 500); // Aguarda a animação de saída terminar
        }, 3000);
};     

// FRONT-END
$(document).ready(function () {
    //#region

    // Botões de fechar modal
    $('#close-form-modal').on('click', function () {
        $('#form-modal').addClass('hidden');
    });

    $('#close-camera-modal').on('click', function () {
        const video = $('#register-camera')[0];

        if (video.srcObject) {
            video.srcObject.getTracks().forEach(track => track.stop());
        }

        $('#camera-modal').addClass('hidden');
    });

    // Menu hambúrguer
    $('#menu-toggle').on('click', function () {
        $('#menu').removeClass('menu-hidden').addClass('menu-visible');
    });

    $('#menu-close').on('click', function () {
        $('#menu').removeClass('menu-visible').addClass('menu-hidden');
    });

    // Abrir modal de formulário de funcionário
    $('#add-employee-btn').on('click', function () {
        $('#form-modal').removeClass('hidden');
    });

    //#endregion
});

//#endregion
});
