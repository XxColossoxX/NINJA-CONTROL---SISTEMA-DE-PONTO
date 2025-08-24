<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel de Funcionários</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Inputmask -->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>

    <!-- Ícones -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/icons/ninja_lock_icon.ico" />
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/ninjaLogo.png" />
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/ninjaLogo.png" />
    <link rel="icon" type="image/x-icon" href="assets/img/icons/ninja_lock_icon.ico" />

    <script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <style>
        nav {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 64px;         
            background: white;
            color: black;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 30;
        }

        .page-content {
            margin-top: 64px;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            to { opacity: 0; visibility: hidden; }
        }

        .welcome-message {
            font-family: 'Noto Sans', sans-serif;
            font-size: 3rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: slideInRight 1s ease, fadeOut 1s ease 3s forwards;
            text-align: center;
        }

        body {
            overflow-x: hidden;
        }

        .menu-slide {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        .menu-hidden {
            transform: translateX(100%);
            opacity: 0;
            pointer-events: none;
        }
        .menu-visible {
            transform: translateX(0);
            opacity: 1;
            pointer-events: auto;
        }

        #config-overlay {
            background-color: rgba(0,0,0,0.5);
            position: fixed;
            inset: 0;
            display: none;
            z-index: 40;
        }

        #config-panel {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        #config-panel > div {
            background: white;
            border-radius: 0.5rem;
            max-width: 28rem;
            width: 100%;
            padding: 1.5rem;
            position: relative;
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        #close-config {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #888;
        }
        #close-config:hover {
            color: #e00;
        }

        @media (max-width: 768px) {
            table thead th:nth-child(1),
            table thead th:nth-child(3),
            table tbody td:nth-child(1),
            table tbody td:nth-child(3) {
                display: none;
            }
            .logo-text { display: none; }
            .logo-emoji { display: block; }
        }
        @media (min-width: 769px) {
            .logo-emoji { display: none; }
        }

        nav.header-funcionario {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 64px; /* altura fixa */
            background: white;
            z-index: 30;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

    </style>
</head>

<body class="bg-animated-gradient">

    <div id="bemVindo">
        <!-- carrego pelo js -->
    </div>

    <div id="controlador" class="hidden">

        <!-- Navbar -->
        <nav class="header-funcionario">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between relative">

                <!-- Logo -->
                <div class="flex items-center text-lg font-bold">
                    <img id="ninja-img" class="w-10 mr-2" src="../../assets/img/ninjaLogo.png" alt="Ninja Control" />
                    <span class="logo-text">NINJA CONTROL</span>
                </div>

                <!-- Nome Centralizado -->
                <div class="text-xl font-semibold absolute left-1/2 transform -translate-x-1/2">
                    PAINEL FUNCIONÁRIOS
                </div>

                <!-- Botão Menu -->
                <button id="menu-toggle" class="block hover:opacity-80">
                    <div class="space-y-1">
                        <span style="display: block; width: 1.5rem; height: 0.125rem; background-color: #000000ff;"></span>
                        <span style="display: block; width: 1.5rem; height: 0.125rem; background-color: #000000ff;"></span>
                        <span style="display: block; width: 1.5rem; height: 0.125rem; background-color: #000000ff;"></span>
                    </div>
                </button>

            </div>

            <!-- Menu lateral -->
            <div id="menu" class="absolute top-0 right-0 bg-white text-black w-48 h-screen menu-slide menu-hidden shadow-lg">
                <!-- Cabeçalho do Menu -->
                <div class="bg-gray-100 text-center py-4 font-bold text-lg relative">
                    NINJA CONTROL
                    <button id="menu-close" class="absolute top-2 right-2 text-red-500 font-bold hover:text-gray-800 focus:outline-none">
                        X
                    </button>
                </div>

                <!-- Itens do Menu -->
                <ul class="flex flex-col justify-between h-[85%] px-4 py-4">

                    <!-- Itens principais -->
                    <div class="space-y-4">
                        <li>
                            <a href="#" class="flex items-center gap-2 hover:text-gray-500">
                                <i class="fas fa-clock"></i> REGISTRAR PONTO 
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 hover:text-gray-500">
                                <i class="fas fa-history"></i> HISTÓRICO PONTOS
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 hover:text-gray-500">
                                <i class="fas fa-users"></i> PAINEL DE FUNCIONÁRIOS
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 hover:text-gray-500">
                                <i class="fas fa-building"></i> DADOS EMPRESA
                            </a>
                        </li>
                        <li>
                            <a href="../../index.php" class="flex items-center gap-2 hover:text-gray-500">
                                <i class="fas fa-sign-out-alt"></i> LOGOUT
                            </a>
                        </li>
                    </div>

                    <!-- Configurações -->
                    <div>
                        <li>
                            <a href="#" id="config-link" class="flex items-center gap-2 hover:text-gray-500">
                                <i class="fas fa-cog"></i> CONFIGURAÇÕES
                            </a>
                        </li>
                    </div>

                </ul>
            </div>
        </nav>
    </div>

    <!-- Modal Overlay -->
    <div id="config-overlay" style="display: none;"></div>

    <!-- Modal Alteração de Senha -->
    <div id="config-panel" style="display: none;">
        <div>
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Alteração de Senha</h2>
            <form id="config-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Senha Atual</label>
                    <input id="senhaAtual" type="password" name="senha_atual" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nova Senha</label>
                    <input id="novaSenha" type="password" name="nova_senha" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Confirmar Nova Senha</label>
                    <input id="confirmarNovaSenha" type="password" name="confirmar_nova_senha" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required />
                </div>
                <div class="text-right">
                    <button id="btnAlterarSenha" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Alterar Senha
                    </button>
                </div>
            </form>
            <button id="close-config">&times;</button>
        </div>
    </div>



    <script>
        $(document).ready(function () {
             $('#config-overlay, #config-panel').hide();
            // Abrir menu hamburguer
            $('#menu-toggle').click(function () {
                $('#menu').removeClass('menu-hidden').addClass('menu-visible');
            });

            // Fechar menu hamburguer
            $('#menu-close').click(function () {
                $('#menu').removeClass('menu-visible').addClass('menu-hidden');
            });

            // Abrir modal configurações
            $('#config-link').click(function (e) {
                e.preventDefault();
                $('#config-overlay, #config-panel').fadeIn(200);
                $('#menu').removeClass('menu-visible').addClass('menu-hidden');
            });

            // Fechar modal (botão X e clique no overlay)
            $('#close-config, #config-overlay').click(function () {
                $('#config-overlay, #config-panel').fadeOut(200);
            });

            // Submit form - só alert (pode ser substituído por AJAX)
            $('#config-form').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                console.log('Configurações enviadas:', data);
                alert('Configurações salvas!');
                $('#config-overlay, #config-panel').fadeOut(200);
            });
        });
    </script>
</body>
</html>
