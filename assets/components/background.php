<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ninja Control</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- criar mascaras -->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Ícone -->
    <link rel="icon" type="image/x-icon" href="../assets/img/icons/ninja_lock_icon.ico">

    <style>
        /* Fundo com gradiente animado */
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bg-animated-gradient {
            background: linear-gradient(45deg, #000000, #14213d, #708d81, #e5e5e5, #ffffff);
            background-size: 400% 400%;
            animation: gradientAnimation 20s ease infinite;
            height: 100vh;
            width: 100%; 
        }

        /* Animações de entrada/saída */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInLeft {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(-100%); opacity: 0; }
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes scaleOut {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(0);
                opacity: 0;
            }
        }

        #loader-container {
            z-index: 9999 !important;
        }


        .loader {
            border-radius: 50%;
        }

        .welcome-message {
            font-family: 'Noto Sans', sans-serif;
            font-size: 3rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: slideInRight 1s ease, slideInLeft 1s ease 3s forwards;
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

          .bgBtn {
            background: linear-gradient(45deg,rgb(0, 0, 0),rgb(115, 114, 115),rgb(0, 0, 0));
            background-size: 400% 400%;
            animation: gradientAnim 8s ease infinite;
        }
        @keyframes gradientAnim {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    </style>
</head>

<body class="bg-animated-gradient flex items-center justify-center">

    <!-- Loader Spinner -->
    <div id="loader-container" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex flex-col items-center justify-center">
        <div class="flex items-center space-x-4 bg-white px-6 py-4 rounded-lg shadow-lg">
            <div class="loader border-4 border-teal-600 border-t-transparent rounded-full w-8 h-8 animate-spin"></div>
            <span id="loader-message" class="text-gray-700 font-semibold">Carregando...</span>
        </div>
    </div>

    <!-- ShowAlert -->
    <div id="alert-box" class="hidden fixed top-6 right-6 left-6 md:left-auto md:right-6 px-4 py-3 rounded-lg shadow-lg text-white bg-teal-600 flex items-center gap-3 animate__animated animate__fadeInDown z-990 max-w-sm w-auto" style="min-width:220px; z-index: 999 !important;">
        <i id="alert-icon" class="fas fa-info-circle text-xl md:text-2xl"></i>
        <span id="alert-message" class="font-semibold text-sm md:text-base flex-1"></span>
        <button id="alert-close" class="ml-2 text-white text-lg hover:text-gray-200 focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
    
    <script>
        function showAlert(message, type = 'info') {
            const $alertBox = $('#alert-box');
            const $alertIcon = $('#alert-icon');
            const $alertMessage = $('#alert-message');
            const $alertClose = $('#alert-close');

            // Mensagem
            $alertMessage.text(message);

            // Resetar animações
            $alertBox.removeClass('hidden animate__fadeOutUp')
                    .addClass('animate__fadeInDown');

            // Mapear tipos
            const types = {
                success: { bg: 'bg-green-600', icon: 'fas fa-check-circle' },
                error: { bg: 'bg-red-600', icon: 'fas fa-exclamation-circle' },
                warning: { bg: 'bg-yellow-500', icon: 'fas fa-exclamation-triangle' },
                info: { bg: 'bg-teal-600', icon: 'fas fa-info-circle' }
            };

            // Resetar cores
            $alertBox.removeClass('bg-green-600 bg-red-600 bg-yellow-500 bg-teal-600')
                    .addClass(types[type]?.bg || types.info.bg);

            // Ícone
            $alertIcon.attr('class', `${types[type]?.icon || types.info.icon} text-xl md:text-2xl`);

            // Auto fechar em 3s
            const timeout = setTimeout(closeAlert, 3000);

            // Botão fechar manual
            $alertClose.off('click').on('click', function() {
                clearTimeout(timeout);
                closeAlert();
            });

            function closeAlert() {
                $alertBox.removeClass('animate__fadeInDown')
                        .addClass('animate__fadeOutUp');

                setTimeout(() => {
                    $alertBox.addClass('hidden')
                            .removeClass('animate__fadeInDown animate__fadeOutUp');
                }, 600);
            }
        }

        // Loader também em jQuery
        function loaderM(mensagem, estado) {
            const $loaderContainer = $('#loader-container');
            const $loaderMessage = $('#loader-message');

            if (estado) {
                $loaderMessage.text(mensagem || 'Carregando...');
                $loaderContainer.removeClass('hidden');
            } else {
                $loaderContainer.addClass('hidden');
            }
        }
    </script>
</body>
</html>