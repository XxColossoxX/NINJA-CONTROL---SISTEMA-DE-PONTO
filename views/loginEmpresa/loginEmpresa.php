<?php
<<<<<<< HEAD
    require_once('../../assets/components/background.php')
?>

<!-- Formulário de Registro -->
<div id="login-system" class="w-[90%] sm:w-full max-w-md mx-auto bg-white bg-opacity-90 shadow-xl rounded-2xl p-4 sm:p-8">
    <div class="text-center">
        <img class="mx-auto w-16 sm:w-20" src="../../assets/img/ninjaLogo.png" alt="Ninja Control">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2 mb-2">LOGIN EMPRESA</h2>
        <h1 class="text-base sm:text-xl font-bold text-gray-700 mb-2">Solicite seu acesso ao suporte da sua empresa!</h1> 
    </div>

    <!-- Campo Usuário -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold">CNPJ:</label>
        <input id="inputCnpjLogin" type="text" placeholder="Digite o CNPJ da empresa:"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm sm:text-base focus:ring-2 focus:ring-gray-500 focus:border-gray-500" /> 
    </div>
    
    <!-- Campo Senha -->
    <div class="mb-6">
        <label class="block text-gray-700 font-bold">Senha:</label>
        <div class="relative">
            <input id="inputSenhaLogin" type="password" placeholder="Digite sua senha" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 text-sm sm:text-base focus:ring-2 focus:ring-gray-500 focus:border-gray-500" />
        </div>
    </div>
    
    <!-- Botões -->
    <div class="flex flex-col space-y-3">
        <button id="btnEntrar" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-105 text-white py-2 rounded-md text-center text-sm sm:text-base">
            <strong>Entrar</strong> <i class="fa fa-check ml-2"></i>
        </button>
        <a href="../registroEmpresa/registroEmpresa.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-105 text-white py-2 rounded-md text-center text-sm sm:text-base">
            <strong>Registrar</strong> <i class="fas fa-arrow-right ml-2"></i>
        </a>
        <a href="../../../index.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-105 text-white py-2 rounded-md text-center text-sm sm:text-base">
            <strong>Voltar</strong> <i class="fas fa-arrow-left ml-2"></i>
        </a>
    </div>
</div>

=======
require_once('../../assets/components/background.php')
?>

   <!-- Formulário de Registro -->
   <div id="login-system" class="w-96 bg-white bg-opacity-90 shadow-xl rounded-2xl p-8">
        <div class="text-center">
            <img class="mx-auto w-20" src="../../assets/img/ninjaLogo.png" alt="Ninja Control">
            <h2 class="text-3xl font-bold text-gray-800 mt-2 mb-2"><i>LOGIN EMPRESA</i></h2><h1 class="text-3x1 font-bold text-gray-700 mb-2">Solicite seu acesso ao suporte da sua empresa!</h1> 
        </div>

        <!-- Campo Usuário -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold">CNPJ:</label>
            <input id="inputCnpjLogin" type="text" placeholder="Digite o CNPJ da empresa:" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-gray-500 focus:border-gray-500" /> 
        </div>
        
        <!-- Campo Senha com ícone -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold">Senha:</label>
            <div class="relative">
                <input id="inputSenhaLogin" type="password" placeholder="Digite sua senha" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:ring-2 focus:ring-gray-500 focus:border-gray-500" />
            </div>
        </div>
        
        <!-- Botões -->
        <div class="flex flex-col space-y-3">
            <button id="btnEntrar" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
                <strong> Entrar</strong> <i class="fa fa-check ml-2"></i>
            </button>
            <a href="../registroEmpresa/registroEmpresa.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
                <strong> Registrar </strong><i class="fas fa-arrow-right ml-2"></i>
            </a>
            <a href="../../../index.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
                <STRONG> Voltar</STRONG> <i class="fas fa-arrow-left ml-2"></i>
            </a>
        </div>
    </div>

    <div id="alert-box" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-md text-white">
        <span id="alert-message"></span>
    </div>
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9

    <script src="/views/loginEmpresa/js/loginEmpresa.js"></script>

</body>
</html>
