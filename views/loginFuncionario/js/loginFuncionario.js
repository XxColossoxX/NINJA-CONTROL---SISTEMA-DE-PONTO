$(document).ready(async function() {
<<<<<<< HEAD
    let input = $("#inputCpfFuncionario")
    Inputmask("999.999.999-99").mask(input)

    // $("#inputCpfFuncionario").Inputmask("999.999.999-99")
=======

    //animacao inicio
   setTimeout(() => {
    document.getElementById("welcome-message").classList.add("hidden");
    document.getElementById("login-system").classList.remove("hidden");
}, 4000);

>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9

    //!BOTOES
    //Botao de Login Empresa
    //#region
   $("#btnEntrar").on('click', function(){
<<<<<<< HEAD
        loginFuncionario();
=======
        loginEmpresa();
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9
   })
   //#endregion
   
   // Botao Alternar visibilidade da senha
   //#region
$('#toggleSenha').on('click', function () {
    const input = $('#inputSenhaLogin');
    const icon = $('#iconSenha');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
   //#endregion


   //!FUNCOES:
   //funcaoOlhoSenha
   //#region 
    // Função para alternar a visibilidade da senha
    function togglePassword(inputId, iconId) {
       const input = document.getElementById(inputId);
       const icon = document.getElementById(iconId);
   
       if (input.type === "password") {
           input.type = "text";
           icon.classList.remove("fa-eye");
           icon.classList.add("fa-eye-slash");
       } else {
           input.type = "password";
           icon.classList.remove("fa-eye-slash");
           icon.classList.add("fa-eye");
       }
   }
   
   // Adiciona eventos de clique nos botões
   document.getElementById("toggleSenhaEmpresa").addEventListener("click", function () {
       togglePassword("inputSenhaEmpresa", "iconSenhaEmpresa");
   });
   
   document.getElementById("toggleConfirmaSenha").addEventListener("click", function () {
       togglePassword("inputConfirmaSenha", "iconConfirmaSenha");
   });
   //#endregion
   
   //cadastrarEmpresa
   //#region 
<<<<<<< HEAD
   async function loginFuncionario() {
    const usuarioFuncionario  = $("#inputCpfFuncionario").val(); ;
    const senhaFuncionario    = $("#inputSenhaFuncionario").val(); ;

    if (!usuarioFuncionario || !senhaFuncionario) {
=======
   async function loginEmpresa() {
    const usuarioEmpresa    = $("#inputUsuarioLogin").val(); ;
    const senhaEmpresa      = $("#inputSenhaLogin").val(); ;

    if (!usuarioEmpresa || !senhaEmpresa) {
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9
        showAlert("Por favor, preencha todos os campos.", "error");
        return;
    }

    try {
        const res = await axios({
            url: "../../../backend/backend.php",
            method: "POST",
            data:{
<<<<<<< HEAD
                function: "loadFuncionario",
                CPF: usuarioFuncionario,
                SENHA_FUNCIONARIO: senhaFuncionario,
=======
                function: "loadEmpresa",
                USUARIO_EMPRESA: usuarioEmpresa,
                SENHA_EMPRESA: senhaEmpresa,
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9

            }
        });

        if (res.data.success) {
            // Login bem-sucedido, redireciona para o dashboard
            console.log(res.data.message, "success");
<<<<<<< HEAD
            window.location.href = `../../../views/pontoFuncionario/pontoFuncionario.php?id:${res.data.data.ID_FUNCIONARIO}`;
=======
            window.location.href = "../../../views/painelPrincipal/painelPrincipal.php";
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9
        } else {
            // Exibe mensagem de erro
            showAlert(res.data.error);
        }
    } catch (error) {
        console.error("Erro ao fazer login:", error);
        alert("Erro ao conectar ao servidor.");
    }
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
       });