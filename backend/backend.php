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

function apply($db, $data){
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
        $senhaFuncionario = $data['SENHA_FUNCIONARIO'];
        $dataNascimento = $data['DATA_NASCIMENTO'];
        $faceId = $data['FACEID'];

        $check = $db->prepare("SELECT ID_FUNCIONARIO FROM FUNCIONARIOS WHERE CPF = ? AND FK_EMPRESA = ?");
        $check->bindValue(1, $cpfFuncionario);
        $check->bindValue(2, $empresaId);
        $resultCheck = $check->execute();
        $row = $resultCheck->fetchArray(SQLITE3_ASSOC);

        if ($row && isset($row['ID_FUNCIONARIO'])) {
            $idFuncionario = $row['ID_FUNCIONARIO'];
            $stmt = $db->prepare("UPDATE FUNCIONARIOS SET NOME_FUNCIONARIO = ?, RG = ?, DATA_NASCIMENTO = ?, FACEID = ?, SENHA_FUNCIONARIO = ? WHERE ID_FUNCIONARIO = ?");
            $stmt->bindValue(1, $nomeFuncionario);
            $stmt->bindValue(2, $rgFuncionario);
            $stmt->bindValue(3, $dataNascimento);
            $stmt->bindValue(4, $faceId);
            $stmt->bindValue(5, $senhaFuncionario);
            $result = $stmt->execute();
            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => "Funcionário atualizado com sucesso!"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao atualizar funcionário."
                ]);
            }
        } else {
            // Não existe, faz INSERT
            $stmt = $db->prepare("INSERT INTO FUNCIONARIOS (NOME_FUNCIONARIO, CPF, RG, SENHA_FUNCIONARIO, DATA_NASCIMENTO, FACEID, FK_EMPRESA, TIPO) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $nomeFuncionario);
            $stmt->bindValue(2, $cpfFuncionario);
            $stmt->bindValue(3, $rgFuncionario);
            $stmt->bindValue(4, $senhaFuncionario);
            $stmt->bindValue(5, $dataNascimento);
            $stmt->bindValue(6, $faceId);
            $stmt->bindValue(7, $empresaId); // FK_EMPRESA
            $stmt->bindValue(8, 'F'); // TIPO

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
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Dados não fornecidos."
        ]);
    }
}

function carregaEmpresa($db, $data){
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

function applyEmpresa($db, $data){
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

function loadFuncionario($db, $data){
 if ($data) {
        $cpfFuncionario = $data['CPF'];
        $senhaFuncionario = $data['SENHA_FUNCIONARIO'];

     
        $stmt = $db->prepare("SELECT ID_FUNCIONARIO, NOME_FUNCIONARIO, CPF, RG, DATA_NASCIMENTO, FACEID FROM FUNCIONARIOS WHERE CPF = ? AND SENHA_FUNCIONARIO = ?");

        $stmt->bindValue(1, $cpfFuncionario);
        $stmt->bindValue(2, $senhaFuncionario);

        $result = $stmt->execute();

        if ($result) {
            $idFuncionario = $result->fetchArray(SQLITE3_ASSOC);
            if ($idFuncionario) {
                
                $_SESSION['funcionario_id'] = $idFuncionario['ID_FUNCIONARIO'];

                echo json_encode([
                    "success" => true,
                    "message" => "Login bem-sucedido!",
                    "data" => $idFuncionario
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

function carregaFuncionario($db, $data){
 if ($data) {
        $usuarioFuncionario = $data['CPF_FUNCIONARIO'];
        $senhaFuncionario = $data['SENHA_FUNCIONARIO'];

     
        $stmt = $db->prepare("SELECT ID_FUNCIONARIO, NOME_FUNCIONARIO, CPF_FUNCIONARIO, RG_FUNCIONARIO, DATA_NASCIMENTO, FACEID FROM FUNCIONARIOS WHERE CPF_FUNCIONARIO = ?");

        $stmt->bindValue(1, $cpfFuncionario);
        $stmt->bindValue(2, $senhaFuncionario);

        $result = $stmt->execute();

        if ($result) {
            $empresa = $result->fetchArray(SQLITE3_ASSOC);
            if ($empresa) {
                
                $_SESSION['funcionario_id'] = $empresa[''];

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

function load($db){
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

function update($db, $data){
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

function deletaFuncionario($db, $data){
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

function getNomeEmpresa($db, $data){
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

function getNomeFuncionario($db, $data){
    session_start(); 

    if (!isset($_SESSION['funcionario_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sessão expirada. Faça login novamente."
        ]);
        exit;
    }

    $idFuncionario = $_SESSION['funcionario_id'];

    $stmt = $db->prepare("SELECT NOME_FUNCIONARIO FROM FUNCIONARIOS WHERE ID_FUNCIONARIO = ?");
    $resultado = [];
    $stmt->bindValue(1, $idFuncionario);

    $result = $stmt->execute();


    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $resultado[] = $row;
    }

    echo json_encode($resultado);
}

?>