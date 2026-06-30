<?php
require_once 'config/database.php';
class Evento
{
    private $conexao;
    public function __construct()
    {
        $bancoDeDados = new Database();
        $this->conexao = $bancoDeDados->connect();
    }
    public function listarDestaques($usuarioId)
    {
        $sql = "SELECT * FROM agenda WHERE usuario_id = :usuario_id
        ORDER BY 
            CASE 
                WHEN status_evento = 'IMPORTANTE' THEN 1
                WHEN status_evento IN ('Em andamento', 'Pendente') THEN 2
                WHEN status_evento = 'Concluído' THEN 3
                ELSE 4
            END,
            data_compromisso ASC,
            horario ASC
            LIMIT 4";
            $comando = $this->conexao->prepare($sql);
            $comando->execute([':usuario_id' => $usuarioId]);
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarTodos($usuarioId)
    {
        $sql = "SELECT * FROM agenda WHERE usuario_id = :usuario_id
        ORDER BY 
            data_compromisso ASC,
            horario ASC";
            $comando = $this->conexao->prepare($sql);
            $comando->execute([':usuario_id' => $usuarioId]);
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorId($id, $usuarioId)
    {
        $sql = "SELECT * FROM agenda WHERE id = :id AND usuario_id = :usuario_id";
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':id', $id, PDO::PARAM_INT);
        $comando->execute([':id' => $id, ':usuario_id' => $usuarioId]);
        return $comando->fetch(PDO::FETCH_ASSOC);
    }
    public function cadastrar($dados)
    {
        $sql = 'INSERT INTO agenda (usuario_id, nome, local_compromisso, data_compromisso, horario, status_evento, observacoes, imagem)
                VALUES (:usuario_id, :nome, :local_compromisso, :data_compromisso, :horario, :status_evento, :observacoes, :imagem)';
        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':usuario_id' => $dados['usuario_id'],
            ':nome' => $dados['nome'],
            ':local_compromisso' => $dados['local_compromisso'],
            ':data_compromisso' => $dados['data_compromisso'],
            ':horario' => $dados['horario'],
            ':status_evento' => $dados['status_evento'],
            ':observacoes' => $dados['observacoes'],
            ':imagem' => $dados['imagem']
        ]);
    }
    public function atualizar($dados)
    {
        $sql = "UPDATE agenda
                SET nome = :nome,
                    local_compromisso = :local_compromisso,
                    data_compromisso = :data_compromisso,
                    horario = :horario,
                    status_evento = :status_evento,
                    observacoes = :observacoes,
                    imagem = :imagem
                WHERE id = :id AND usuario_id = :usuario_id";
        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':id' => $dados['id'],
            ':usuario_id' => $dados['usuario_id'],
            ':nome' => $dados['nome'],
            ':local_compromisso' => $dados['local_compromisso'],
            ':data_compromisso' => $dados['data_compromisso'],
            ':horario' => $dados['horario'],
            ':status_evento' => $dados['status_evento'],
            ':observacoes' => $dados['observacoes'],
            ':imagem' => $dados['imagem']
        ]);
    }
    public function excluir($id, $usuarioId)
    {
        $sql = "DELETE FROM agenda WHERE id = :id AND usuario_id = :usuario_id";
        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':id' => $id,
            ':usuario_id' => $usuarioId
        ]);
    }
}