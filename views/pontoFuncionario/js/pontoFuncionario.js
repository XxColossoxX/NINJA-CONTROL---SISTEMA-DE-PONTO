let foto64 = ""; 
let cameraStream = null;
const tabela = $("#tblFuncionario tbody");

$(document).ready( async function() {    
   setTimeout(() => {
    document.getElementById("welcome-message").classList.add("hidden");
    document.getElementById("controlador").classList.remove("hidden");
}, 4000);


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

})

//!FUNCOES

$(document).ready(function () {
    let cameraStream = null;

    // Abas
    $('.tab-button').on('click', function () {
        const tabId = $(this).data('tab');
        $('.tab-button').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').addClass('hidden');
        $('#' + tabId).removeClass('hidden');
    });

    // Abrir modal com câmera
    $('#btnBaterPonto').on('click', async function () {
        // Preenche os dados nas abas
        $('#tab-nome').text(nomeFuncionario);
        $('#tab-empresa').text(nomeEmpresa);
        $('#tab-rg').text(rgFuncionario);
        $('#tab-cpf').text(cpfFuncionario);
        $('#tab-nascimento').text(dataNascimentoFuncionario);
        $('#tab-localizacao').text(localizacaoEmpresa);

        $('#modal-bater-ponto').removeClass('hidden');
        $('.tab-button').first().click(); // Ativa primeira aba

        // Delay para garantir que o vídeo esteja no DOM e visível
        setTimeout(async () => {
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: false
                });

                const videoElement = $('#video-camera')[0];
                if (videoElement) {
                    if ("srcObject" in videoElement) {
                        videoElement.srcObject = cameraStream;
                    } else {
                        // Para navegadores antigos
                        videoElement.src = window.URL.createObjectURL(cameraStream);
                    }
                    videoElement.play();
                } else {
                    alert("Elemento de vídeo não encontrado!");
                }
            } catch (err) {
                alert('Erro ao acessar câmera: ' + err.message);
            }
        }, 100); // 100ms de delay
    });

    // Fechar modal e parar a câmera
    $('#btn-fechar-ponto').on('click', function () {
        $('#modal-bater-ponto').addClass('hidden');
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
    });

    // Capturar imagem e converter para base64
    $('#btn-efetuar-ponto').on('click', async function () {
        const video = $('#video-camera')[0];
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const base64Image = canvas.toDataURL('image/jpeg');

        console.log("Imagem capturada em Base64:", base64Image);
        showAlert('a foto foi tirada','info')

        const res = await axios({
            url:'http://127.0.0.1:5000/comparacao' ,    
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            data:{
                idFuncionario: sessionStorage.getItem('idFuncionario'),
                faceId: base64Image.replace(/^data:image\/(png|jpeg);base64,/, '')
            }
        });
        console.log(res)
        if(res.data.success){
            showAlert('Ponto registrado com sucesso!','success');
        }

        $('#btn-fechar-ponto').click(); // Fecha o modal
    });
});

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
                    <img src="${imagemFuncionario}" class="w-16 h-16 rounded-full border-4 border-gray-250">
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
}

async function recarregaTabela() {
    const tabela = $("#tblFuncionario tbody");
    tabela.empty();


    await loadEmpresa()
    return
}

async function loadEmpresa(){
    tabela.empty();
    const res = await axios({
        url: "../../../backend/backend.php",
        method: "POST",
        data: {
            function: "load",
            
        },
    });
        await preencheTabela(res);
        $("totalFunc").empty();
        $("#totalFunc").text(res.data.length);
        return
}

//!FRONT-END
//#region
// Botões de fechar os modais
const closeFormModalBtn     = document.getElementById('close-form-modal');
const closeCameraModalBtn   = document.getElementById('close-camera-modal');

// Fechar o modal do formulário
closeFormModalBtn.addEventListener('click', () => {
    formModal.classList.add('hidden');
});

// Fechar o modal de captura de rosto
closeCameraModalBtn.addEventListener('click', () => {
    cameraModal.classList.add('hidden');
});

document.getElementById("close-camera-modal").addEventListener("click", function () {
    const cameraModal = document.getElementById("camera-modal");
    const video = document.getElementById("register-camera");

    // Parar o stream da câmera
    if (video.srcObject) {
        video.srcObject.getTracks().forEach((track) => track.stop());
    }

    cameraModal.classList.add("hidden");
});

const menuToggle    = document.getElementById("menu-toggle");
const menuClose     = document.getElementById("menu-close");
const menu          = document.getElementById("menu");

menuToggle.addEventListener("click", () => {
    menu.classList.remove("menu-hidden");
    menu.classList.add("menu-visible");
});

menuClose.addEventListener("click", () => {
    menu.classList.remove("menu-visible");
    menu.classList.add("menu-hidden");
});

const addEmployeeBtn    = document.getElementById('add-employee-btn');
const formModal         = document.getElementById('form-modal');
const cameraModal       = document.getElementById('camera-modal');
const nextToCameraBtn   = document.getElementById('next-to-camera');
const video             = document.getElementById('video');
const captureBtn        = document.getElementById('capture-btn');

addEmployeeBtn.addEventListener('click', () => {
    formModal.classList.remove('hidden');
});
//#endregion

});
