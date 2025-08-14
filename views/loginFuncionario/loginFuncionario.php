<?php
require_once('../../assets/components/background.php')
?>

  <!-- Formulário de Registro -->
  <div id="login-system" class="w-[90%] sm:w-full max-w-md mx-auto bg-white bg-opacity-90 shadow-xl rounded-2xl p-4 sm:p-8">
        <div class="text-center">
            <img class="mx-auto w-20" src="../../assets/img/ninjaLogo.png" alt="Ninja Control">
            <h2 class="text-3xl font-bold text-gray-800 mt-2 mb-2">LOGIN FUNCIONÁRIO</h2><h1 class="text-3x1 font-bold text-gray-700 mb-2">Solicite seu acesso ao suporte da sua empresa!</h1> 
        </div>

        
        <!-- Campo Usuário -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">Digite o CPF:</label>
            <input id="inputCpfFuncionario" type="text" placeholder="Digite seu usuário" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-gray-500 focus:border-gray-500" /> 
        </div>
        
        <!-- Campo Senha com ícone -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold">Senha:</label>
            <div class="relative">
                <input id="inputSenhaFuncionario" type="password" placeholder="Digite sua senha" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:ring-2 focus:ring-gray-500 focus:border-gray-500" />
                <button type="button" id="toggleSenha" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none">
                    <i class="fas fa-eye" id="iconSenha"></i>
                </button>
            </div>
        </div>
        
        <!-- Botões -->
        <div class="flex flex-col space-y-3">
            <button id="btnEntrar" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
                <strong> Entrar </strong><i class="fas fa-arrow-right ml-2"></i>
            </button>
            <a href="../../../index.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
            <STRONG> Voltar</STRONG> <i class="fas fa-arrow-left ml-2"></i>
            </a>
        </div>
    </div>

    <div id="alert-box" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-md text-white">
        <span id="alert-message"></span>
    </div>

    <script src="/views/loginFuncionario/js/loginFuncionario.js"></script>

</body>
</html>
