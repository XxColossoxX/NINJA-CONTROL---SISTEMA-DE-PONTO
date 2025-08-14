$(document).ready(async function() {
    Inputmask("99.999.999/9999-99").mask("#inputCnpjEmpresa");


   // Exibir login após a mensagem inicial sumir
   setTimeout(() => {
    document.getElementById("welcome-message").classList.add("hidden");
    document.getElementById("login-system").classList.remove("hidden");
}, 4000);


    

//!FUNCOES:

//cadastrarFuncionario
//#region
async function cadastrarEmpresa() {

    var usuario         = $("#inputUsuarioEmpresa").val();
    var nomeEmpresa     = $("#inputNomeEmpresa").val();
    var senha           = $("#inputSenhaEmpresa").val();
    var confirmaSenha   = $("#inputConfirmaSenha").val();
    var cnpjEmpresa     = $("#inputCnpjEmpresa").val();

    if(usuario == "" || senha == "" || nomeEmpresa == "" || usuario == null || senha == null || nomeEmpresa == null) {
        showAlert("Preencha todos os campos!", "error");
        return;
    }
     if(senha.length < 6) {
        showAlert("A senha deve ter pelo menos 6 caracteres!", "error");
        return;
    } if(senha != confirmaSenha) {
        showAlert("As senhas não coincidem!", "error");
        return;
    }

        const res = await axios({
            url: '../../../backend/backend.php',
            method: 'POST',
            data:{
                function: "applyEmpresa",
                NOME_EMPRESA: nomeEmpresa,
                USUARIO_EMPRESA: usuario,
                SENHA_EMPRESA: senha,
                CNPJ_EMPRESA: cnpjEmpresa,
                TIPO: "E",
            },
        });
    
        window.location.href = "../loginEmpresa/loginEmpresa.php";
    }
//#endregion

//alertBox
//#region
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
    }
    //#endregion

//função olho senha
//#region
$('#toggleSenhaEmpresa').click(function () {
    const input = $('#inputSenhaEmpresa');
    const icon = $('#iconSenhaEmpresa');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});

$('#toggleConfirmaSenha').click(function () {
    const input = $('#inputConfirmaSenha');
    const icon = $('#iconConfirmaSenha');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});

$("#btnRegistrar").on('click',function() {
    cadastrarEmpresa();

});
//#endregion














});