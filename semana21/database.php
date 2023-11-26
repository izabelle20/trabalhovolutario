<?php

class Database {
    private $conn; // Variável para armazenar a conexão com o banco de dados

    // Construtor da classe Database
    public function __construct($host, $user, $pass, $database) {
        // Cria uma nova instância da classe mysqli para a conexão com o banco de dados
        $this->conn = new mysqli($host, $user, $pass, $database);

        // Verifica se houve erro na conexão com o banco de dados
        if ($this->conn->connect_error) {
            // Encerra o script e exibe uma mensagem de erro em caso de falha na conexão
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    // Método para obter a conexão com o banco de dados
    public function getConnection() {
        return $this->conn;
    }
}
?>
