<?php
require_once __DIR__ . "/Config/Config.php";

// Inicializar variáveis
$id = $nome_usuario = $email = $senha = "";
$mensagem = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['act']) && $_GET['act'] == 'save') {
    $nome_usuario = isset($_POST['nome_usuario']) ? trim($_POST['nome_usuario']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($nome_usuario) || empty($email) || empty($senha)) {
        $mensagem = "<p style='color: red;'>Por favor, preencha todos os campos!</p>";
    } else {
        try {
            $stmt = $conexao->prepare("INSERT INTO usuario (nome_usuario, email, senha) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $nome_usuario);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $senha);

            if ($stmt->execute()) {
               header("Location: Views/Usuarios/Usuarios.php");
                exit;

                // Limpar os campos após cadastro bem-sucedido
                // $id = $nome_usuario = $email = $senha = "";
            } else {
                $mensagem = "<p style='color: red;'>Erro ao cadastrar usuário.</p>";
            }
        } catch (PDOException $e) {
            $mensagem = "<p style='color: red;'>Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Usuários</title>

        
        <style>
            body {
                font-family: Arial, sans-serif;
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
            }
            form {
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            input[type="text"], input[type="email"], input[type="password"] {
                width: 100%;
                padding: 8px;
                margin: 5px 0 15px 0;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input[type="submit"], input[type="reset"] {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-right: 10px;
            }
            input[type="reset"] {
                background-color: #f44336;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                color: #2196F3;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <?php if (!empty($mensagem)) echo $mensagem; ?>
        
        <form method="POST" action="?act=save">
            <h1>Cadastrar Usuário</h1>
            <hr>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
            
            <label for="nome_usuario">Nome:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" value="<?php echo htmlspecialchars($nome_usuario); ?>" required />
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required />
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" value="" required />
            <br><br>
            <input type="submit" value="Cadastrar Usuário" />
            <input type="reset" value="Limpar" />
            <hr>
        </form>
        
        <!-- Link para listar usuários -->
        <strong><a href="Views/Usuarios/Usuarios.php">Verificar todos os usuários cadastrados</a></strong>
    </body>
</html>

