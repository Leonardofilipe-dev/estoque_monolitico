<?php
require_once __DIR__ . "/../../../Config/Config.php";
require_once __DIR__ . "/../../Controllers/userController/UsuarioController.php";

// Inicializa variáveis usadas no template
$mensagem = '';
$id = '';
$nome_usuario = '';
$email = '';
$senha = '';


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
        <strong><a href="/app/Views/user/TemplateListarUsuarios.php">Verificar todos os usuários cadastrados</a></strong>
    </body>
</html>

