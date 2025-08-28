<?php
session_start();

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: ../loginFuncionario/loginFuncionario.php');
    exit;
}
require_once('../../assets/components/background.php');
require_once('../../assets/components/headerFuncionario.php');

$idFuncionario = $_SESSION['funcionario_id'];
$nomeFuncionario = isset($_SESSION['funcionario_nome']) ? $_SESSION['funcionario_nome'] : '';
$faceIdFuncionario = isset($_SESSION['funcionario_faceid']) ? $_SESSION['funcionario_faceid'] : '';
$fotoFuncionario = isset($_SESSION['funcionario_faceid']) ? $_SESSION['funcionario_faceid'] : ''; // Exemplo: usar faceId como url da foto
$rgFuncionario = isset($_SESSION['funcionario_rg']) ? $_SESSION['funcionario_rg'] : '';
$cpfFuncionario = isset($_SESSION['funcionario_cpf']) ? $_SESSION['funcionario_cpf'] : '';
$nomeEmpresa = isset($_SESSION['funcionario_nome_empresa']) ? $_SESSION['funcionario_nome_empresa'] : 'Nome da Empresa'; // Trocar para valor real depois
$dataNascimentoFuncionario = isset($_SESSION['funcionario_data_nascimento']) ? $_SESSION['funcionario_data_nascimento'] : 'Data de Nascimento'; // Trocar para valor real depois
$localizacaoEmpresa = 'R. Pasteur, 463 - Batel, Curitiba - PR'; // Trocar para valor real depois

?>

<div class="min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-2xl p-0 md:mt-8 mt-2 flex flex-col md:flex-row">

        <!-- Header do modal -->
        <div class="w-full md:w-1/2 flex flex-col justify-start md:p-4 p-2 border-b md:border-b-0 md:border-r border-gray-200">
            <!-- Header mobile: imagem à esquerda, texto à direita -->
            <div class="md:hidden flex items-center gap-2 mb-2">
                <img src="<?php echo $fotoFuncionario; ?>" alt="Foto do Funcionário" style="width:48px;height:48px;border-radius:9999px;object-fit:cover;border:2px solid #14b8a6;">
                <span class="font-bold text-base text-center text-gray-800 flex-1">SEJA MUITO BEM VINDO!<br><?php echo htmlspecialchars($nomeFuncionario); ?></span>
            </div>
            <!-- Header desktop -->
            <h2 class="hidden md:block text-xl font-bold text-gray-800 text-center md:mt-5 md:mb-14 mt-2 mb-2">SEJA MUITO BEM VINDO!<br><?php echo htmlspecialchars($nomeFuncionario); ?></h2>
            <div class="flex flex-col items-center">
                <img src="<?php echo $fotoFuncionario; ?>" alt="Foto do Funcionário" class="w-24 h-24 rounded-full border-4 border-primary object-cover mb-0 md:block hidden">
                <div class="hidden md:block bg-gray-100 rounded-3xl md:p-12 p-2 w-full max-w-6xl flex flex-col md:mb-6 mb-2 md:mt-5 mt-2" id="card-dados-funcionario">
                    <div class="flex flex-col md:gap-6 gap-2">
                        <div class="grid grid-cols-2 items-center mb-4 gap-x-8 gap-y-2">
                            <div class="flex items-center min-w-[180px]">
                                <i class="fas fa-user mr-3 text-gray-500 text-2xl"></i>
                                <span class="text-lg text-gray-500 font-semibold">Nome:</span>
                            </div>
                            <span class="text-2xl font-bold text-gray-700 text-left break-words whitespace-nowrap overflow-hidden text-ellipsis min-w-[220px]"><?php echo htmlspecialchars($nomeFuncionario); ?></span>
                        </div>
                        <div class="grid grid-cols-2 items-center mb-4 gap-x-8 gap-y-2">
                            <div class="flex items-center min-w-[180px]">
                                <i class="fas fa-building mr-3 text-gray-500 text-2xl"></i>
                                <span class="text-lg text-gray-500 font-semibold">Empresa:</span>
                            </div>
                            <span class="text-xl text-gray-700 text-left break-words whitespace-nowrap overflow-hidden text-ellipsis min-w-[220px]"><?php echo htmlspecialchars($nomeEmpresa); ?></span>
                        </div>
                        <div class="grid grid-cols-2 items-center mb-4 gap-x-8 gap-y-2">
                            <div class="flex items-center min-w-[180px]">
                                <i class="fas fa-id-card mr-3 text-gray-500 text-2xl"></i>
                                <span class="text-lg text-gray-500 font-semibold">RG:</span>
                            </div>
                            <span class="text-xl text-gray-700 text-left break-words whitespace-nowrap overflow-hidden text-ellipsis min-w-[220px]"><?php echo htmlspecialchars($rgFuncionario); ?></span>
                        </div>
                        <div class="grid grid-cols-2 items-center mb-4 gap-x-8 gap-y-2">
                            <div class="flex items-center min-w-[180px]">
                                <i class="fas fa-address-card mr-3 text-gray-500 text-2xl"></i>
                                <span class="text-lg text-gray-500 font-semibold">CPF:</span>
                            </div>
                            <span class="text-xl text-gray-700 text-left break-words whitespace-nowrap overflow-hidden text-ellipsis min-w-[220px]"><?php echo htmlspecialchars($cpfFuncionario); ?></span>
                        </div>
                        <div class="grid grid-cols-2 items-center mb-4 gap-x-8 gap-y-2">
                            <div class="flex items-center min-w-[180px]">
                                <i class="fas fa-calendar-alt mr-3 text-gray-500 text-2xl"></i>
                                <span class="text-lg text-gray-500 font-semibold">Nascimento:</span>
                            </div>
                            <span class="text-xl text-gray-700 text-left break-words whitespace-nowrap overflow-hidden text-ellipsis min-w-[220px]"><?php echo htmlspecialchars($dataNascimentoFuncionario); ?></span>
                        </div>
                    </div>
                </div>
                <button class="md:hidden bg-gray-200 text-teal-700 font-semibold px-2 py-1 rounded-lg mt-2" id="btn-mais-info">
                    <i class="fas fa-info-circle mr-2"></i> Mais informações do funcionário
                </button>
            </div>
        </div>

        <!-- Conteúdo do modal -->
        <div class="w-full md:w-1/2 flex flex-col justify-center md:p-4 p-2">
            <div class="mb-8">
                <h2 class="hidden md:block text-2xl font-extrabold text-teal-700 text-center md:mb-6 mb-2 tracking-wide uppercase">PAINEL REGISTRO PONTO</h2>
            </div>
            <div class="md:mb-4 mb-2">
                <h3 class="text-lg font-bold md:mb-2 mb-1">Últimos registros</h3>
                <div class="grid grid-cols-2 md:gap-2 gap-1">
                    <div class="bg-gray-100 rounded-lg p-2 flex flex-col items-center">
                        <i class="fas fa-sign-in-alt text-green-600 text-xl mb-1"></i>
                        <span class="font-bold text-green-600">08:00</span>
                        <span class="text-xs">Entrada</span>
                        <span class="text-xs text-green-500">Concluído</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-2 flex flex-col items-center">
                        <i class="fas fa-sign-out-alt text-red-600 text-xl mb-1"></i>
                        <span class="font-bold text-red-600">12:00</span>
                        <span class="text-xs">Saída</span>
                        <span class="text-xs text-red-500">Concluído</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-2 flex flex-col items-center">
                        <i class="fas fa-sign-in-alt text-green-600 text-xl mb-1"></i>
                        <span class="font-bold text-green-600">13:30</span>
                        <span class="text-xs">Entrada</span>
                        <span class="text-xs text-yellow-500">Pendente</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-2 flex flex-col items-center">
                        <i class="fas fa-sign-out-alt text-red-600 text-xl mb-1"></i>
                        <span class="font-bold text-red-600">18:00</span>
                        <span class="text-xs">Saída</span>
                        <span class="text-xs text-yellow-500">Pendente</span>
                    </div>
                </div>
            </div>
            <div class="md:mb-4 mb-2">
                <label class="block text-gray-700 text-sm font-bold md:mb-2 mb-1" for="localizacao">Localização</label>
                <div class="flex items-center bg-gray-100 rounded-lg md:p-2 p-1">
                    <i class="fas fa-map-marker-alt text-teal-600 text-xl mr-2"></i>
                    <input id="inputLocalizacao" type="text" value="<?php echo htmlspecialchars($localizacaoEmpresa); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100" readonly>
                </div>
            </div>
            <div class="flex justify-center md:mt-8 mt-2 md:mb-2 mb-1">
                <button id="btnBaterPonto" class="bg-teal-600 hover:bg-teal-700 text-white font-bold md:py-3 py-2 md:px-6 px-3 rounded-lg text-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-fingerprint mr-2"></i> BATER PONTO
                </button>
            </div>
            <div class="text-xs text-gray-400 text-center md:mt-2 mt-1">
                Ninja Control - Direitos Reservados
            </div>
            <div id="welcome-message" class="mt-6 text-green-500 font-bold hidden">
                Bem-vindo, <span id="welcome-nome"></span>!
            </div>
            <div id="alert-box" class="hidden fixed top-12 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-md text-white">
                <span id="alert-message"></span>
            </div>
        </div>
    </div>
</div>

<!-- Modal mobile -->
<div id="modal-dados-funcionario" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg p-6 w-[98vw] max-w-2xl min-w-[340px] relative" style="width:98vw;max-width:600px;min-width:340px;">
        <h3 class="text-lg font-bold text-center mb-4">Dados do Funcionário</h3>
        <div class="flex flex-col gap-2">
            <div class="grid grid-cols-2 items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-user mr-2 text-gray-500"></i>
                    <span class="text-base text-gray-500 font-semibold">Nome:</span>
                </div>
                <span class="text-base font-bold text-gray-700 text-left break-words"><?php echo htmlspecialchars($nomeFuncionario); ?></span>
            </div>
            <div class="grid grid-cols-2 items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-building mr-2 text-gray-500"></i>
                    <span class="text-base text-gray-500 font-semibold">Empresa:</span>
                </div>
                <span class="text-base font-bold text-gray-700 text-left break-words"><?php echo htmlspecialchars($nomeEmpresa); ?></span>
            </div>
            <div class="grid grid-cols-2 items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-id-card mr-2 text-gray-500"></i>
                    <span class="text-base text-gray-500 font-semibold">RG:</span>
                </div>
                <span class="text-base font-bold text-gray-700 text-left break-words"><?php echo htmlspecialchars($rgFuncionario); ?></span>
            </div>
            <div class="grid grid-cols-2 items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-address-card mr-2 text-gray-500"></i>
                    <span class="text-base text-gray-500 font-semibold">CPF:</span>
                </div>
                <span class="text-base font-bold text-gray-700 text-left break-words"><?php echo htmlspecialchars($cpfFuncionario); ?></span>
            </div>
            <div class="grid grid-cols-2 items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                    <span class="text-base text-gray-500 font-semibold">Nascimento:</span>
                </div>
                <span class="text-base font-bold text-gray-700 text-left break-words"><?php echo htmlspecialchars($dataNascimentoFuncionario); ?></span>
            </div>
        </div>
        <button id="btn-fechar-modal-mobile" class="mt-6 w-full bg-gray-200 text-gray-700 font-semibold py-2 rounded-lg text-lg hover:bg-gray-300 transition">Fechar</button>
    </div>
</div>

<!-- Modal de Bater Ponto -->
<div id="modal-bater-ponto" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-[95vw] max-w-3xl relative p-4">
        <h2 class="text-xl font-bold text-center mb-4"><i class="fas fa-fingerprint mr-2 text-teal-600"></i>Registro de Ponto</h2>

        <!-- Abas -->
        <div class="flex border-b border-gray-200 mb-4">
            <button class="tab-button text-gray-600 font-semibold px-4 py-2 border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600" data-tab="info-tab">
                <i class="fas fa-user mr-2"></i>Informações
            </button>
            <button class="tab-button text-gray-600 font-semibold px-4 py-2 border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600" data-tab="local-tab">
                <i class="fas fa-map-marker-alt mr-2"></i>Localização
            </button>
        </div>

        <!-- Conteúdo das Abas -->
        <div id="info-tab" class="tab-content">
            <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                <div><strong><i class="fas fa-id-badge mr-2"></i>Nome:</strong> <span id="tab-nome"></span></div>
                <div><strong><i class="fas fa-building mr-2"></i>Empresa:</strong> <span id="tab-empresa"></span></div>
                <div><strong><i class="fas fa-id-card mr-2"></i>RG:</strong> <span id="tab-rg"></span></div>
                <div><strong><i class="fas fa-address-card mr-2"></i>CPF:</strong> <span id="tab-cpf"></span></div>
                <div><strong><i class="fas fa-calendar-alt mr-2"></i>Nascimento:</strong> <span id="tab-nascimento"></span></div>
            </div>
        </div>

        <div id="local-tab" class="tab-content hidden">
            <div class="text-gray-700 text-sm mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i><strong>Localização da Empresa:</strong>
                <div class="bg-gray-100 p-3 rounded mt-1" id="tab-localizacao"></div>
            </div>
        </div>

        <div class="camera-container">
            <div id="camera-container">
                <video id="video-camera" autoplay muted playsinline class="video-feed"></video>
            </div>            
            <div class="overlay">
                <div class="circle-ring"></div>
            </div>
        </div>


        <!-- Botões -->
        <div class="flex justify-between items-center mt-4">
            <button id="btn-fechar-ponto" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Fechar
            </button>
            <button id="btn-efetuar-ponto" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 transition font-bold">
                <i class="fas fa-check-circle mr-2"></i>Efetuar Ponto
            </button>
        </div>
    </div>
</div>

<script src="./js/pontoFuncionario.js"></script>
<link rel="stylesheet" href="./css/pontoFuncionario.css">
<script>
    

    const faceIdFuncionario         = "<?php echo isset($_SESSION['funcionario_faceid']) ? $_SESSION['funcionario_faceid'] : ''; ?>";
    const nomeFuncionario           = "<?php echo isset($_SESSION['funcionario_nome']) ? $_SESSION['funcionario_nome'] : ''; ?>";
    const cpfFuncionario            = "<?php echo isset($_SESSION['funcionario_cpf']) ? $_SESSION['funcionario_cpf'] : ''; ?>";
    const rgFuncionario             = "<?php echo isset($_SESSION['funcionario_rg']) ? $_SESSION['funcionario_rg'] : ''; ?>";
    const nomeEmpresa               = "<?php echo isset($_SESSION['funcionario_nome_empresa']) ? $_SESSION['funcionario_nome_empresa'] : ''; ?>";
    const dataNascimentoFuncionario = "<?php echo isset($_SESSION['funcionario_data_nascimento']) ? $_SESSION['funcionario_data_nascimento'] : ''; ?>";
    const localizacaoEmpresa = "<?php echo $localizacaoEmpresa; ?>";

    const idFuncionario = "<?php echo isset($_SESSION['funcionario_id']) ? $_SESSION['funcionario_id'] : ''; ?>"
    sessionStorage.setItem("idFuncionario",idFuncionario)
    
    let divBemVindo = $("#bemVindo");
    let conteudo = `
    <div id="welcome-message" class="fixed inset-0 flex items-center justify-center z-50 text-center">
        <div>
            <h1 class="text-2xl text-white font-sans"><i><strong>BEM-VINDO(A) DE VOLTA</strong></i></h1>
            <h2 id="tituloEmpresa" class="text-lg text-white font-sans underline text-center"><i><strong>${nomeFuncionario}</strong></i></h2>
        </div>
    </div>`;

    divBemVindo.append(conteudo);

    setTimeout(() => {
        document.getElementById("welcome-message").classList.add("entrada");
    }, 100);
    setTimeout(() => {
        const el = document.getElementById("welcome-message");
        el.classList.remove("entrada");
        el.classList.add("saida");
        setTimeout(() => {
            el.remove();
            document.getElementById("controlador")?.classList.remove("hidden");
        }, 500);
    }, 1500);

    $(document).ready(function() {
        $('#btn-mais-info').on('click', function() {
            $('#modal-dados-funcionario').removeClass('hidden');
        });
        $('#btn-fechar-modal, #btn-fechar-modal-mobile').on('click', function() {
            $('#modal-dados-funcionario').addClass('hidden');
        });
        $('#btn-menu-mobile').on('click', function(e) {
            e.stopPropagation();
            $('#menu-mobile').toggleClass('hidden');
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#menu-mobile, #btn-menu-mobile').length) {
                $('#menu-mobile').addClass('hidden');
            }
        });
    });
</script>


</body>
</html>
