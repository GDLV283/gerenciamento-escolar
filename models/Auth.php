<?php
require_once 'config/database.php';
class Auth
{
    private $conexao;
    public function __construct()
    {
        $bancoDeDados = new Database();
        $this->conexao = $bancoDeDados->connect();
    }
    public function buscarPorEmail($email)
    {
        $sql = 'SELECT * FROM usuarios WHERE email = :email';
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':email', $email, PDO::PARAM_STR);
        $comando->execute();
        return $comando->fetch(PDO::FETCH_ASSOC);
    }
}