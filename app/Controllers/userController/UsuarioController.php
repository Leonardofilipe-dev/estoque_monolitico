<?php 

require_once __DIR__ . '/../../Models/Usuario.php';

/** Controller para salvar Usuario **/
/** Controller serve para salvar usuários **/

// Processa envio do formulário (salvar usuário)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['act']) && $_GET['act'] === 'save') {
    $usuario = new Usuario($GLOBALS['conexao'] ?? null);
    $usuario->nome_usuario = trim($_POST['nome_usuario'] ?? '');
    $usuario->email = trim($_POST['email'] ?? '');
    $usuario->senha = $_POST['senha'] ?? '';

    if ($usuario->salvar()) {
        $mensagem = $usuario->getMensagem();
        // Limpar campos após sucesso
        $nome_usuario = '';
        $email = '';
        $senha = '';
    } else {
        $mensagem = $usuario->getMensagem();
        $nome_usuario = $_POST['nome_usuario'] ?? '';
        $email = $_POST['email'] ?? '';
    }
}


//**Controller serve para listar todos os Usuarios **/

// Busca todos os usuários
$usuarios = Usuario::buscarTodos($GLOBALS['conexao'] ?? null);

/** Controller para deletar Usuario **/
/**Esse controller gerencia a exclusão de usuários **/

// Processa exclusão de usuário
$mensagem = '';
if (isset($_GET['delete'])) {
    $usuario = new Usuario($GLOBALS['conexao'] ?? null);
    $usuario->id = $_GET['delete'];
    
    if ($usuario->deletar()) {
        $mensagem = $usuario->getMensagem();
    } else {
        $mensagem = $usuario->getMensagem();
    }
}