<?php
require_once 'models/Evento.php';
require_once 'helpers/auth.php';

class EventoController
{
    private $modeloEvento;
    private $statusPermitidos = ['Pendente', 'Em andamento', 'Concluído', 'IMPORTANTE'];

    public function __construct()
    {
        $this->modeloEvento = new Evento();
    }

    public function listar()
    {
        $usuario = obterUsuarioAutenticado();
        if ($usuario) {
            $eventosProximos = $this->modeloEvento->listarDestaques($usuario['id']);
            $eventos = $this->modeloEvento->listarTodos($usuario['id']);
        }else{
            $eventos = [];
            $eventosProximos = [];
        }
        $mensagem = isset($_GET['mensagem']) ? $_GET['mensagem'] : '';
        $tipoMensagem = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';

        require 'views/eventos/lista.php';
    }

    public function criar()
    {
        exigirAutenticacao();
        $evento = [
            'id' => '',
            'nome' => '',
            'local_compromisso' => '',
            'data_compromisso' => '',
            'horario' => '',
            'status_evento' => '',
            'observacoes' => '',
            'imagem' => ''
        ];
        $acaoFormulario = 'salvar';
        $tituloPagina = 'Cadastrar compromisso';

        require 'views/eventos/formulario.php';
    }

    public function salvar()
    {
        exigirAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            exigirTokenCsrf($_POST['csrf_token'] ?? '');
            $dados = $this->normalizarDadosEvento($_POST);

            $usuario = obterUsuarioAutenticado();
            $dados['usuario_id'] = $usuario['id'];
            $erros = $this->validarDadosEvento($dados);
            if (!empty($erros)) {
                header('Location: index.php?acao=criar&mensagem=' . urlencode($erros[0]) . '&tipo=warning');
                exit;
            }
            $dados['imagem'] = $this->uploadImagem($_FILES['imagem']);
            $sucesso = $this->modeloEvento->cadastrar($dados);

            if ($sucesso) {
                header('Location: index.php?mensagem=Compromisso cadastrado com sucesso.&tipo=success');
            } else {
                header('Location: index.php?mensagem=Erro ao cadastrar o compromisso.&tipo=danger');
            }
            exit;
        }
    }

    public function uploadImagem(){
        $arquivo = $_FILES['imagem'];
        $temp = $arquivo['tmp_name'];

        if (empty($_FILES['imagem']['tmp_name'])) {
            return '';
        }
        $mime = mime_content_type($_FILES['imagem']['tmp_name']);
        if ($mime !== 'image/jpeg' && $mime !== 'image/png') die ("Inválido");
        if($arquivo['size'] > 2000000) die("Muito grande");
        $ext = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $novoUnico = uniqid() . '.' . $ext;
        $caminho = 'uploads/' . $novoUnico;

        if (move_uploaded_file($temp, $caminho)) {
            return $caminho;
        }else{
            return '';
        }
    }

    public function editar()
    {
        exigirAutenticacao();
        if (!isset($_GET['id'])) {
            header('Location: index.php?mensagem=ID do compromisso não informado.&tipo=warning');
            exit;
        }
        $id = (int) $_GET['id'];
        $usuario = obterUsuarioAutenticado();
        $evento = $this->modeloEvento->buscarPorId($id, $usuario['id']);
        if (!$evento) {
            header('Location: index.php?mensagem=Compromisso não encontrado.&tipo=warning');
            exit;
        }
        $acaoFormulario = 'atualizar';
        $tituloPagina = 'Editar compromisso';

        require 'views/eventos/formulario.php';
    }

    public function atualizar()
    {
        exigirAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            exigirTokenCsrf($_POST['csrf_token'] ?? '');
            $dados = $this->normalizarDadosEvento($_POST);
            $dados['id'] = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $usuario = obterUsuarioAutenticado();
            $dados['usuario_id'] = $usuario['id'];
            $erros = $this->validarDadosEvento($dados, true);
            if (!empty($erros)) {
                $idRedirecionamento = isset($_POST['id']) ? (int) $_POST['id'] : 0;
                header('Location: index.php?acao=editar&id=' . $idRedirecionamento . '&mensagem=' . urlencode($erros[0]) . '&tipo=warning');
                exit;
            }
            $sucesso = $this->modeloEvento->atualizar($dados);
            if ($sucesso) {
                header('Location: index.php?mensagem=Compromisso atualizado com sucesso.&tipo=success');
            } else {
                header('Location: index.php?mensagem=Erro ao atualizar o compromisso.&tipo=danger');
            }
            exit;
        }
    }

    public function excluir()
    {
        exigirAutenticacao();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?mensagem=A exclusão deve ser enviada por formulário seguro.&tipo=warning');
            exit;
        }
        exigirTokenCsrf($_POST['csrf_token'] ?? '');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php?mensagem=ID do compromisso não informado ou inválido.&tipo=warning');
            exit;
        }
        $usuario = obterUsuarioAutenticado();
        $sucesso = $this->modeloEvento->excluir($id, $usuario['id']);
        if ($sucesso) {
            header('Location: index.php?mensagem=Compromisso removido com sucesso.&tipo=success');
        } else {
            header('Location: index.php?mensagem=Erro ao remover o compromisso.&tipo=danger');
        }
        exit;
    }

    private function normalizarDadosEvento($dados)
    {
        return [
            'nome' => isset($dados['nome']) ? trim($dados['nome']) : '',
            'local_compromisso' => isset($dados['local_compromisso']) ? trim($dados['local_compromisso']) : '',
            'data_compromisso' => isset($dados['data_compromisso']) ? trim($dados['data_compromisso']) : '',
            'horario' => isset($dados['horario']) ? trim($dados['horario']) : '',
            'status_evento' => isset($dados['status_evento']) ? trim($dados['status_evento']) : '',
            'observacoes' => isset($dados['observacoes']) ? trim($dados['observacoes']) : '',
            'imagem' => isset($dados['imagem']) ? trim($dados['imagem']) : ''
        ];
    }

    private function validarDadosEvento($dados, $exigirId = false)
    {
        $erros = [];
        if ($exigirId && empty($dados['id'])) {
            $erros[] = 'ID do compromisso inválido.';
        }
        if ($dados['nome'] === '' || mb_strlen($dados['nome']) > 150) {
            $erros[] = 'Informe o compromisso com até 150 caracteres. (Ex.: Prova de Quimíca; Ir no mercado.)';
        }
        if ($dados['local_compromisso'] === '' || mb_strlen($dados['local_compromisso']) > 100) {
            $erros[] = 'Informe um local com até 100 caracteres.';
        }
        if (!$this->dataEhValida($dados['data_compromisso'])) {
            $erros[] = 'Informe uma data válida para o compromisso.';
        }
        if (empty($dados['horario'])) {
            $erros[] = 'Informe um horário válida.';
        }
        if (!in_array($dados['status_evento'], $this->statusPermitidos, true)) {
            $erros[] = 'Selecione um status válido.';
        }
        if (mb_strlen($dados['observacoes']) > 1000) {
            $erros[] = 'As anotações devem ter no máximo 1000 caracteres.';
        }
        return $erros;
    }

    private function dataEhValida($data)
    {
        $partes = explode('-', $data);
        if (count($partes) !== 3) {
            return false;
        }
        return checkdate((int) $partes[1], (int) $partes[2], (int) $partes[0]);
    }
}