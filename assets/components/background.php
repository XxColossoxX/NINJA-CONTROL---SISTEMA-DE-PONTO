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

    <div id="alert-box" class="hidden fixed top-6 right-6 px-6 py-4 rounded-lg shadow-lg text-white bg-teal-600 flex items-center gap-3 animate__animated animate__fadeInDown z-50" style="min-width:220px;">
        <i id="alert-icon" class="fas fa-info-circle text-2xl"></i>
        <span id="alert-message" class="font-semibold"></span>
        <button id="alert-close" class="ml-auto text-white text-xl hover:text-gray-300"><i class="fas fa-times"></i></button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
    <script>
    function showAlert(message, type = 'info') {
        const alertBox = document.getElementById('alert-box');
        const alertIcon = document.getElementById('alert-icon');
        const alertMessage = document.getElementById('alert-message');
        
        alertMessage.textContent = message;
        alertBox.classList.remove('hidden');
        alertBox.classList.add('animate__fadeInDown');
        // Icon by type
        
        if(type === 'success') {
            alertBox.classList.remove('bg-teal-600','bg-red-600','bg-yellow-500');
            alertBox.classList.add('bg-green-600');
            alertIcon.className = 'fas fa-check-circle text-2xl';
        } else if(type === 'error') {
            alertBox.classList.remove('bg-teal-600','bg-green-600','bg-yellow-500');
            alertBox.classList.add('bg-red-600');
            alertIcon.className = 'fas fa-exclamation-circle text-2xl';
        } else if(type === 'warning') {
            alertBox.classList.remove('bg-teal-600','bg-green-600','bg-red-600');
            alertBox.classList.add('bg-yellow-500');
            alertIcon.className = 'fas fa-exclamation-triangle text-2xl';
        } else {
            alertBox.classList.remove('bg-green-600','bg-red-600','bg-yellow-500');
            alertBox.classList.add('bg-teal-600');
            alertIcon.className = 'fas fa-info-circle text-2xl';
        }
        setTimeout(() => {
            alertBox.classList.add('animate__fadeOutUp');
            setTimeout(() => {
                alertBox.classList.add('hidden');
                alertBox.classList.remove('animate__fadeInDown','animate__fadeOutUp');
            }, 600);
        }, 3000);
    }
    document.getElementById('alert-close').onclick = function() {
        const alertBox = document.getElementById('alert-box');
        alertBox.classList.add('animate__fadeOutUp');
        setTimeout(() => {
            alertBox.classList.add('hidden');
            alertBox.classList.remove('animate__fadeInDown','animate__fadeOutUp');
        }, 600);
    };
    </script>
</body>
</html>