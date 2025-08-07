const sqlite3 = require('sqlite3').verbose();
const path = require('path');
const dbPath = path.join(__dirname, 'bancoDados.db');

class Database {
    constructor() {
        this.db = new sqlite3.Database(dbPath, (err) => {
            if (err) {
                console.error("Erro ao conectar ao banco de dados:", err.message);
            } else {
                console.log("Banco de dados conectado com sucesso.");
            }
        });
    }



    // Método para adicionar um funcionário
    addFuncionario(cpf, nome, rg, dataNascimento, faceID, callback) {
        const query = `INSERT INTO funcionarios (CPF, NOME_FUNCIONARIO, RG, DATA_NASCIMENTO, faceID) VALUES (?, ?, ?, ?, ?)`;
        this.db.run(query, [cpf, nome, rg, dataNascimento, faceID], function(err) {
            callback(err, this ? this.lastID : null);
        });
    }




    // Método para registrar um ponto
    registrarPonto(funcionarioID, nome, dataHora, tipoPonto, faceIDFuncionario, callback) {
        const query = `INSERT INTO Ponto (FK_FUNCIONARIO, Nome_Funcionario, DataHora, Tipo_ponto, faceID_funcionario) VALUES (?, ?, ?, ?, ?)`;
        this.db.run(query, [funcionarioID, nome, dataHora, tipoPonto, faceIDFuncionario], function(err) {
            callback(err, this ? this.lastID : null);
        });
    }




    // Método para listar funcionários
    getFuncionarios(callback) {
        this.db.all("SELECT * FROM funcionarios", [], (err, rows) => {
            callback(err, rows);
        });
    }



    // Método para listar pontos de um funcionário específico
    getPontosByFuncionario(idFuncionario, callback) {
        const query = "SELECT * FROM Ponto WHERE FK_FUNCIONARIO = ?";
        this.db.all(query, [idFuncionario], (err, rows) => {
            callback(err, rows);
        });
    }

    

    // Fechar conexão
    close() {
        this.db.close((err) => {
            if (err) {
                console.error("Erro ao fechar o banco de dados:", err.message);
            } else {
                console.log("Conexão com o banco de dados fechada.");
            }
        });
    }
}

module.exports = new Database();
