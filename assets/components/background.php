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

<<<<<<< HEAD
    <!-- criar mascaras -->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>
=======
    <!-- inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9
    
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
<<<<<<< HEAD
            background: linear-gradient(45deg, #000000, #14213d, #708d81, #e5e5e5, #ffffff);
            background-size: 400% 400%;
            animation: gradientAnimation 20s ease infinite;
            height: 100vh;
            width: 100%; 
=======
            background: linear-gradient(45deg, rgb(114, 114, 114), rgb(121, 121, 122), rgb(109, 109, 109), rgb(153, 152, 153), rgb(130, 129, 129), #000000, #000000);
            background-size: 400% 400%;
            animation: gradientAnimation 20s ease infinite;
            height: 100vh;
            width: 100%;
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9
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

<<<<<<< HEAD
<body class="bg-animated-gradient flex items-center justify-center">

    <div id="alert-box" class="hidden fixed top-12 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-md text-white">
        <span id="alert-message"></span>
    </div>
=======
<body class="bg-animated-gradient flex items-center justify-center">
>>>>>>> d384aeecb3bc838be5bb8e1e56820b07e71af5f9
