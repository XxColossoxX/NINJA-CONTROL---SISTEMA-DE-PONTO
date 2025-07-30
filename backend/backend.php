<?php
$db = new SQLite3(__DIR__ . '/../dataBase/bancoDados.db');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['function'])) {
    $function = $data['function'];

    switch ($function) {
        case 'apply': // Inserir funcionário
            apply($db, $data);
            break;

        case 'loadFuncionario': // Load funcionário
            loadFuncionario($db, $data);
            break;

        case 'getNomeEmpresa': // get nome empresa
            getNomeEmpresa($db, $data);
            break;

        case 'applyEmpresa': // Inserir empresa
            applyEmpresa($db, $data);
            break;

        case 'loadEmpresa': // Inserir empresa
            loadEmpresa($db, $data);
            break;

        case 'load': // Carregar funcionários
            load($db);
            break;

        case 'update': // Atualizar funcionário
            update($db, $data);
            break;

        case 'deletaFuncionario': // Deletar funcionário
            deletaFuncionario($db, $data);
            break;

        default:
            echo json_encode(["error" => "Função inválida"]);
            break;
    }
} else {
    echo json_encode(["error" => "Nenhuma função especificada"]);
}

function apply($db, $data)
{
    session_start();

    if (!isset($_SESSION['empresa_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sessão expirada. Faça login novamente."
        ]);
        exit;
    }

    $empresaId = $_SESSION['empresa_id']; 

    if ($data) {
        $nomeFuncionario = $data['NOME_FUNCIONARIO'];
        $cpfFuncionario = $data['CPF'];
        $rgFuncionario = $data['RG'];
        $dataNascimento = $data['DATA_NASCIMENTO'];
        $faceId = $data['FACEID'];

        $stmt = $db->prepare("INSERT INTO FUNCIONARIOS (NOME_FUNCIONARIO, CPF, RG, DATA_NASCIMENTO, FACEID, FK_EMPRESA, TIPO) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $nomeFuncionario);
        $stmt->bindValue(2, $cpfFuncionario);
        $stmt->bindValue(3, $rgFuncionario);
        $stmt->bindValue(4, $dataNascimento);
        $stmt->bindValue(5, $faceId);
        $stmt->bindValue(6, $empresaId); // FK_EMPRESA
        $stmt->bindValue(7, 'F'); // FK_EMPRESA

        $result = $stmt->execute();

        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Funcionário cadastrado com sucesso!"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao cadastrar funcionário."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Dados não fornecidos."
        ]);
    }
}

function loadEmpresa($db, $data)
{
    session_start(); 

    if ($data) {
        $usuarioEmpresa = $data['CNPJ_EMPRESA'];
        $senhaEmpresa = $data['SENHA_EMPRESA'];

     
        $stmt = $db->prepare("SELECT ID_EMPRESA, CNPJ_EMPRESA, SENHA_EMPRESA FROM EMPRESA WHERE CNPJ_EMPRESA = ? AND SENHA_EMPRESA = ?");
        $stmt->bindValue(1, $usuarioEmpresa);
        $stmt->bindValue(2, $senhaEmpresa);

        $result = $stmt->execute();

        if ($result) {
            $empresa = $result->fetchArray(SQLITE3_ASSOC);
            if ($empresa) {
                
                $_SESSION['empresa_id'] = $empresa['ID_EMPRESA'];

                echo json_encode([
                    "success" => true,
                    "message" => "Login bem-sucedido!",
                    "data" => $empresa
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "error" => "Usuário ou senha inválidos."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao executar a consulta."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "error" => "Dados não fornecidos."
        ]);
    }
}


function applyEmpresa($db, $data)
{
    if ($data) {

        $nomeEmpresa = $data['NOME_EMPRESA'];
        $senhaEmpresa = $data['SENHA_EMPRESA'];
        $usuarioEmpresa = $data['USUARIO_EMPRESA'];
        $cnpjEmpresa = $data['CNPJ_EMPRESA'];
        $empresaTipo = $data['TIPO'];

        $stmt = $db->prepare("INSERT INTO EMPRESA (NOME_EMPRESA, SENHA_EMPRESA, USUARIO_EMPRESA, CNPJ_EMPRESA, TIPO) VALUES (?, ?, ?, ?,?)");
        $stmt->bindValue(1, $nomeEmpresa);
        $stmt->bindValue(2, $senhaEmpresa);
        $stmt->bindValue(3, $usuarioEmpresa);
        $stmt->bindValue(4, $cnpjEmpresa);
        $stmt->bindValue(5, $empresaTipo);



        if ($stmt->execute()) {
            echo json_encode(["message" => "Funcionário cadastrado com sucesso!"]);
        } else {
            echo json_encode(["error" => "Erro ao cadastrar funcionário."]);
        }
    }
}

function loadFuncionario($db, $data)
{
    session_start();

    if (!isset($_SESSION['empresa_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sessão expirada. Faça login novamente."
        ]);
        exit;
    }
    $id = $data['ID_FUNCIONARIO'];

    $result = $db->query("SELECT * FROM funcionarios WHERE FK_EMPRESA =" . $_SESSION['empresa_id'] . " AND ID_FUNCIONARIO =" . $id);
    $funcionarios = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $funcionarios[] = $row;
    }

    echo json_encode($funcionarios);
}

function load($db)
{
    session_start(); 

    if (!isset($_SESSION['empresa_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sessão expirada. Faça login novamente."
        ]);
        exit;
    }


    $result = $db->query("SELECT * FROM funcionarios WHERE FK_EMPRESA =" . $_SESSION['empresa_id']);
    $funcionarios = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $funcionarios[] = $row;
    }

    echo json_encode($funcionarios);
}


function update($db, $data)
{
    if ($data) {
        $id = $data['ID_FUNCIONARIO'];
        $cpf = $data['CPF'];
        $nome = $data['NOME_FUNCIONARIO'];
        $rg = $data['RG'];
        $dataNascimento = $data['DATA_NASCIMENTO'];
        $faceID = $data['faceID'];

        $stmt = $db->prepare("UPDATE funcionarios SET CPF = ?, NOME_FUNCIONARIO = ?, RG = ?, DATA_NASCIMENTO = ?, faceID = ? WHERE ID_FUNCIONARIO = ?");
        $stmt->bindValue(1, $cpf);
        $stmt->bindValue(2, $nome);
        $stmt->bindValue(3, $rg);
        $stmt->bindValue(4, $dataNascimento);
        $stmt->bindValue(5, $faceID);
        $stmt->bindValue(6, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Funcionário atualizado com sucesso!"]);
        } else {
            echo json_encode(["error" => "Erro ao atualizar funcionário."]);
        }
    }
}


function deletaFuncionario($db, $data)
{
    if ($data) {
        $id = $data['ID_FUNCIONARIO'];

        $stmt = $db->prepare("DELETE FROM FUNCIONARIOS WHERE ID_FUNCIONARIO = ?");
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Funcionário deletado com sucesso!"]);
        } else {
            echo json_encode(["error" => "Erro ao deletar funcionário."]);
        }
    }
}

function getNomeEmpresa($db, $data)
{
    session_start(); 

    if (!isset($_SESSION['empresa_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sessão expirada. Faça login novamente."
        ]);
        exit;
    }

    $empresaId = $_SESSION['empresa_id'];

    $stmt = $db->prepare("SELECT NOME_EMPRESA FROM EMPRESA WHERE ID_EMPRESA = ?");
    $resultado = [];
    $stmt->bindValue(1, $empresaId);

    $result = $stmt->execute();


    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $resultado[] = $row;
    }

    echo json_encode($resultado);
}

?>