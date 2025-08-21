<?php
session_start();
if (!isset($_SESSION['empresa_id'])) {
    header('Location: ../loginEmpresa/loginEmpresa.php');
    exit;
}
require_once('../../assets/components/headerEmpresa.php');
require_once('../../assets/components/background.php');

$empresaId = $_SESSION['empresa_id'];
?>

<!-- Boas-vindas (se necessário via animação) -->
<div id="welcome-message" class="mt-6 text-green-500 font-bold hidden">
    Bem-vindo, <span id="welcome-nome"></span>!
</div>

<!-- Container principal centralizado com padding horizontal -->
<div class="px-4 md:px-8 lg:px-16 xl:px-20 py-8 mt-8">
    <div class="controlador hidden">

        <!-- Dashboard Wrapper -->
        <div class="mb-6 flex justify-end">
            <button id="add-employee-btn"
                class="bg-green-400 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                ADICIONAR FUNCIONÁRIO
            </button>
        </div>

        <!-- Tabela Responsiva -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="overflow-y-auto max-h-[500px]">
                <table id="tblFuncionario" class="min-w-full table-auto">
                    <thead class="bg-gray-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2 border-r-4 border-gray-600 text-center rounded-tl-lg">ID</th>
                            <th class="px-4 py-2 border-r-4 border-gray-600 text-center">NOME</th>
                            <th class="px-4 py-2 border-r-4 border-gray-600 text-center hidden md:table-cell">CPF</th>
                            <th class="px-4 py-2 border-r-4 border-gray-600 text-center hidden md:table-cell">RG</th>
                            <th class="px-2 py-1 border-r-4 border-gray-600 text-center">IMAGEM</th>
                            <th class="px-2 py-1 border-r-4 border-gray-600 text-center">EDITAR</th>
                            <th class="px-2 py-1 text-center rounded-tr-lg">EXCLUIR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Conteúdo dinâmico -->
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-600 text-white px-4 py-2 text-center rounded-b-lg">
                <strong>Total de Funcionários:</strong> <span id="totalFunc">0</span>
            </div>
        </div>


        <!-- Modal - Formulário -->
        <div id="form-modal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <button id="close-form-modal"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                <h2 class="text-xl font-bold mb-4">Adicionar Funcionário</h2>
                <form id="employee-form">
                    <!-- Campos responsivos -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1" for="name">Nome</label>
                            <input id="inputNomeFuncionario" type="text" placeholder="Digite o nome"
                                class="w-full shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1" for="cpf">CPF</label>
                            <input id="inputCpfFuncionario" type="text" placeholder="Digite o CPF"
                                class="w-full shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1" for="rg">RG</label>
                            <input id="inputRgFuncionario" type="text" placeholder="Digite o RG"
                                class="w-full shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1" for="password">Senha Acesso</label>
                            <input id="inputSenhaFuncionario" type="password" placeholder="Digite a senha"
                                class="w-full shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1" for="nascimento">Data de Nascimento</label>
                            <input id="inputDataNascFuncionario" type="date"
                                class="w-full shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" id="btnProximo"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                            Próximo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal - Captura Facial -->
        <div id="camera-modal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden p-4">
            <div
                class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative flex flex-col lg:flex-row gap-6 overflow-y-auto max-h-[90vh]">
                <button id="close-camera-modal"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>

                <!-- Webcam Section -->
                <div class="flex flex-col items-center w-full lg:w-1/2">
                    <h2 class="text-xl font-bold mb-4">Cadastro Facial</h2>
                    <p id="camera-error" class="text-red-500 text-center mb-4 hidden">Erro ao acessar a câmera.</p>
                    <div class="w-64 h-64 rounded-full border-4 border-primary flex items-center justify-center mb-4 overflow-hidden">
                        <video id="register-camera" autoplay playsinline class="w-full h-full object-cover"></video>
                    </div>
                    <button id="btnCapturar"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition-transform duration-300 transform hover:scale-105">
                        Capturar
                    </button>
                </div>

                <!-- Dados do Formulário -->
                <div class="w-full lg:w-1/2 space-y-2">
                    <h3 class="text-lg font-bold mb-2">Dados do Funcionário</h3>
                    <p><strong>Nome:</strong> <span id="display-nome"></span></p>
                    <p><strong>CPF:</strong> <span id="display-cpf"></span></p>
                    <p><strong>RG:</strong> <span id="display-rg"></span></p>
                    <p><strong>Senha Acesso:</strong> <span id="display-senha"></span></p>
                    <p><strong>Data de Nascimento:</strong> <span id="display-data"></span></p>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="alert-box" class="hidden fixed top-12 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-md text-white"></div>

<script src="./js/painelPrincipal.js"></script>
<link rel="stylesheet" href="./css/painelPrincipal.css">
