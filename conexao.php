<?php

class conexao {

    private $host;
    private $user;
    private $password;
    private $database;
    private $conexao;

    public function __construct() {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->database = "tetris_bd";

        try {
            $this->conexao = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage() . "<br/>";
        }
    }

    public function getConexao() {
        return $this->conexao;
    }

}