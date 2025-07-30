<?php
require_once('assets/components/background.php')
?>

    <!-- Mensagem de Boas-Vindas -->
    <div id="welcome-message" class="welcome-message text-center">
        <p class="text-3xl md:text-2x1 text-white mb-1">SEJA BEM VINDO(A)<br>AO</p>
        <h1 class=" text-5xl text-white font-sans"><strong>NINJA CONTROL</strong></h1>
    </div>

    <!-- Imagem com animação -->
    <div id="animacaoCena" class="animacaoCena hidden">
        <img id="ninja-img" class="mx-auto w-60" src="../assets/img/ninjaLogo.png" alt="Ninja Control">
    </div>

    <div id="login-system2" class="hidden">
        <img id="ninja-img" class="mx-auto w-20" src="../assets/img/ninjaLogo.png" alt="Ninja Control">
        <h1 class="text-center text-white font-bold text-3xl mb-2">NINJA CONTROL</h1>
        <div id="login-system" class="w-96 bg-white bg-opacity-90 shadow-xl rounded-2xl p-8 hidden">
            <!-- Botões -->
            <div class="flex flex-col space-y-3">
                <a href="views/loginFuncionario/loginFuncionario.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
                <STRONG>FUNCIONÁRIO</STRONG> <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="views/loginEmpresa/loginEmpresa.php" class="bgBtn w-full bg-gray-700 transform transition-transform duration-300 hover:scale-110 text-white py-2 rounded-md text-center transition">
                <STRONG>EMPRESA</STRONG> <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById("welcome-message").classList.add("hidden");

            document.getElementById("animacaoCena").classList.remove("hidden");
            document.getElementById("ninja-img").classList.add("ninja-image-animate");
        }, 2000);

        setTimeout(() => {
            document.getElementById("animacaoCena").classList.add("hidden");
            document.getElementById("login-system").classList.remove("hidden");
            document.getElementById("login-system2").classList.remove("hidden");
        }, 4000);    
    </script>

</body>
</html>
