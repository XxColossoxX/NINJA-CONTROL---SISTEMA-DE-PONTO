<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Funcionários</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- criar mascaras -->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>
    
    <!-- Ícone -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/icons/ninja_lock_icon.ico">

    <script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <style>
        
        /* Animações */
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

        /* Fundo com gradiente animado */
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bg-animated-gradient {
            background: linear-gradient(45deg, rgb(114, 114, 114), rgb(121, 121, 122), rgb(109, 109, 109), rgb(153, 152, 153), rgb(130, 129, 129), #000000, #000000);
            background-size: 400% 400%;
            animation: gradientAnimation 20s ease infinite;
            height: 100vh;
            width: 100%;
        }

        .ninja-image-animate {
            animation: scaleIn 0.5s ease forwards, scaleOut 0.5s ease 1.5s forwards;
        }

        .animacaoCena {
            font-family: 'Noto Sans', sans-serif;
            font-size: 3rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Animação para o menu */
        .menu-slide {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .menu-hidden {
            transform: translateX(100%);
            opacity: 0;
        }

        .menu-visible {
            transform: translateX(0);
            opacity: 1;
        }

        /* Remover scroll horizontal */
        body {
            overflow-x: hidden;
        }

        /* Ajustar o espaço do conteúdo abaixo da navbar */
        .content {
            padding-top: 64px; /* Altura da navbar */
        }

        /* Responsividade para o Dashboard */
        @media (max-width: 768px) {
            table thead th:nth-child(1),
            table thead th:nth-child(3),
            table tbody td:nth-child(1),
            table tbody td:nth-child(3) {
                display: none;
            }
        }

        /* Responsividade para a Navbar */
        @media (max-width: 768px) {
            .logo-text {
                display: none; /* Esconde o texto "NINJA CONTROL" */
            }
            .logo-emoji {
                display: block; /* Mostra apenas o emoji */
            }
        }

        @media (min-width: 769px) {
            .logo-emoji {
                display: none; /* Esconde o emoji em telas maiores */
            }
        }

        
                /* Animação de entrada (fade-in + slide-down) */
                @keyframes fadeInSlideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animação de saída (fade-out + slide-up) */
        @keyframes fadeOutSlideUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* Classes para animação */
        .alert-show {
            animation: fadeInSlideDown 0.5s ease forwards;
        }

        .alert-hide {
            animation: fadeOutSlideUp 0.5s ease forwards;
        }
        
        /* Ajustar o vídeo dentro do círculo */
        #register-camera {
            border-radius: 50%; /* Faz o vídeo ficar circular */
            object-fit: cover; /* Garante que o vídeo preencha o círculo */
            width: 100%; /* Preenche a largura do contêiner */
            height: 100%; /* Preenche a altura do contêiner */
        }
        
    </style>
</head>

<body class="bg-animated-gradient">

    <div id="bemVindo">
        <!-- carrego pelo js -->
    </div>       

<div id="controlador" class="hidden">

        <!-- Navbar -->
        <nav class="bg-gray-800 text-white shadow-md fixed top-0 left-0 w-full z-10">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                <!-- Logo -->
                <div class="text-lg font-bold">
                    <span class="logo-text">🐱‍👤 NINJA CONTROL</span>
                    <span class="logo-emoji">🐱‍👤</span>
                </div>

                <!-- Nome Centralizado -->
                <div class="text-xl font-semibold absolute left-1/2 transform -translate-x-1/2">
                    FUNCIONÁRIOS
                </div>

                <!-- Botão de Menu -->
                <button id="menu-toggle" class="block hover:opacity-80">
                    <div class="space-y-1">
                        <span style="display: block; width: 1.5rem; height: 0.125rem; background-color: #f0f0f0 !important;"></span>
                        <span style="display: block; width: 1.5rem; height: 0.125rem; background-color: #f0f0f0 !important;"></span>
                        <span style="display: block; width: 1.5rem; height: 0.125rem; background-color: #f0f0f0 !important;"></span>
                    </div>
                </button>
            </div>

            <!-- Menu Responsivo -->
            <div id="menu" class="absolute top-0 right-0 bg-gray-300 text-white w-48 h-screen menu-slide menu-hidden shadow-lg">
                <!-- Cabeçalho do Menu -->
                <div class="bg-gray-400 text-center py-4 font-bold text-lg relative">
                    NINJA CONTROL
                    <!-- Botão para fechar o menu -->
                    <button id="menu-close" class="absolute top-2 right-2 text-white text-2xl font-bold hover:text-gray-300 focus:outline-none">
                        X
                    </button>
                </div>

                <!-- Opções do Menu -->
                <ul class="flex flex-col space-y-4 mt-8 px-4">
                    <li><a href="#" class="hover:text-gray-300">◾ PONTO 🎥</a></li>
                    <li><a href="#" class="hover:text-gray-300">◾ FUNCIONÁRIO 👥</a></li>
                    <li><a href="../../index.php" class="hover:text-gray-300">◾ LOGOUT 🕳</a></li>
                </ul>
            </div>
        </nav>