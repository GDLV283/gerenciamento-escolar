<?php
class Database
{
    private $host = 'localhost';
    private $nomeBanco = 'agenda_compromissos';
    private $usuario = 'root';
    private $senha = '';

    public function connect()
    {
        try {
            $conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->nomeBanco};charset=utf8",
                $this->usuario,
                $this->senha
            );
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        } catch (PDOException $erro) {
            die('Erro na conexão com o banco de dados: ' . $erro->getMessage());
        }
    }
}