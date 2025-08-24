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
$fotoFuncionario = isset($_SESSION['funcionario_faceid']) ? $_SESSION['funcionario_faceid'] : '';
$rgFuncionario = isset($_SESSION['funcionario_rg']) ? $_SESSION['funcionario_rg'] : '';
$cpfFuncionario = isset($_SESSION['funcionario_cpf']) ? $_SESSION['funcionario_cpf'] : '';
$dataNascimentoFuncionario = isset($_SESSION['funcionario_data_nascimento']) ? $_SESSION['funcionario_data_nascimento'] : 'Data de Nascimento'; 

$socialEmpresa = isset($_SESSION['empresa_razao_social']) ? $_SESSION['empresa_razao_social'] : 'Razão Social da Empresa'; 
$fantasiaEmpresa = isset($_SESSION['empresa_razao_fantasia']) ? $_SESSION['empresa_razao_fantasia'] : 'Razão Fantasia da Empresa'; 
$cnpjEmpresa = isset($_SESSION['empresa_cnpj']) ? $_SESSION['empresa_cnpj'] : 'CNPJ da Empresa'; 
$locEmpresa = isset($_SESSION['empresa_loc']) ? $_SESSION['empresa_loc'] : 'Localização da Empresa'; 
$dscEmpresa = isset($_SESSION['empresa_dsc']) ? $_SESSION['empresa_dsc'] : 'Descrição da Empresa'; 
$telEmpresa = isset($_SESSION['empresa_tel']) ? $_SESSION['empresa_tel'] : 'Telefone da Empresa'; 
$emailEmpresa = isset($_SESSION['empresa_email']) ? $_SESSION['empresa_email'] : 'Email da Empresa'; 

?>

<div class="min-h-screen flex flex-col items-center justify-center">
<!-- Modal Empresa (como tela principal) -->
<div class="min-h-screen flex flex-col items-center justify-center">
    <div class="modalDadosEmpresa w-full max-w-6xl bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-10 md:p-14 flex flex-col md:flex-row gap-10">
        
        <!-- Coluna Esquerda -->
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-teal-700 mb-6 flex items-center gap-3">
                <i class="fas fa-building text-teal-600 text-xl"></i>
                Informações da Empresa
            </h2>

            <ul class="space-y-4 text-gray-800 text-sm md:text-base">
                <li class="flex items-center gap-3">
                    <i class="fas fa-id-badge text-teal-500"></i>
                    <span><strong>Nome:</strong> <?php echo $fantasiaEmpresa; ?></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fas fa-id-card text-teal-500"></i>
                    <span><strong>CNPJ:</strong> <?php echo $cnpjEmpresa; ?></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fas fa-map-marker-alt text-teal-500"></i>
                    <span><strong>Endereço:</strong> <?php echo $locEmpresa; ?></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fas fa-phone-alt text-teal-500"></i>
                    <span><strong>Telefone:</strong> <?php echo $telEmpresa; ?></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fas fa-envelope text-teal-500"></i>
                    <span><strong>Email:</strong> <?php echo $emailEmpresa; ?></span>
                </li>
            </ul>
        </div>

        <!-- Coluna Direita -->
        <div class="flex-1 flex flex-col items-center justify-between">
            <div class="bg-teal-600 text-white p-6 md:p-8 rounded-xl shadow-md w-full">
                <h3 class="text-lg md:text-xl font-semibold mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Sobre a Empresa
                </h3>
                <p class="text-sm md:text-base leading-relaxed">
                    <?php echo $dscEmpresa; ?>
                </p>
            </div>

            <!-- Botão Editar (DENTRO da coluna direita do modal) -->
            <div class="w-full flex justify-center mt-6">
                <button id="btn-editar-empresa" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded shadow transition flex items-center gap-2">
                    <i class="fas fa-edit"></i> Editar Informações
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Modal de Edição da Empresa -->
<div id="modal-editar-empresa" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-8 relative">
        <button id="fechar-modal-edicao" class="absolute top-3 right-4 text-gray-600 hover:text-red-500 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-6 text-teal-700">Editar Informações da Empresa</h2>
        <form id="form-editar-empresa" method="POST" action="salvarEmpresa.php">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nome Fantasia</label>
                    <input id="inputNomeFantasia" type="text" name="fantasia" value="<?php echo $fantasiaEmpresa; ?>" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">CNPJ</label>
                    <input id="inputCnpj" type="text" name="cnpj" value="<?php echo $cnpjEmpresa; ?>" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Endereço</label>
                    <input id="inputEndereco" type="text" name="endereco" value="<?php echo $locEmpresa; ?>" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Telefone</label>
                    <input id="inputTelefone" type="text" name="telefone" value="<?php echo $telEmpresa; ?>" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input id="inputEmail" type="email" name="email" value="<?php echo $emailEmpresa; ?>" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Descrição</label>
                    <textarea id="inputDescricao" name="descricao" rows="4" class="w-full border border-gray-300 rounded px-3 py-2"><?php echo $dscEmpresa; ?></textarea>
                </div>
            </div>
            <div class="mt-6 text-right">
                <button id="btnSalvarEdicao" type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script src="./js/dadosEmpresa.js"></script>
<link rel="stylesheet" href="./css/dadosEmpresa.css">
</body>
</html>