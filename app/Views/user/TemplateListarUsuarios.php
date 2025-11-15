<?php 
require_once __DIR__ . '/../../../Config/Config.php';
require_once __DIR__ . '/../../Controllers/userController/UsuarioController.php';
require_once __DIR__ . '/../../Controllers/userController/UsuarioController.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>

    <a href="/index.php">Voltar a página de cadastro</a>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 32px;
            color: #333;
        }

        .acoes {
            margin-top: 10px;
            justify-content: left;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 6px;
            color: #fff;
            margin-right: 8px;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-editar {
            background: #007bff;
        }

        .btn-editar:hover {
            background: #0056b3;
        }

        .btn-deletar {
            background: #dc3545;
        }

        .btn-deletar:hover {
            background: #c82333;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        }

        .info {
            margin: 8px 0;
            font-size: 16px;
            color: #444;
        }

        .info strong {
            color: #222;
            display: inline-block;
            width: 80px;
        }

        .mensagem {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .mensagem-sucesso {
            color: green;
            background-color: #d4edda;
        }

        .mensagem-erro {
            color: red;
            background-color: #f8d7da;
        }
    </style>
</head>

<h1>Lista de Usuários</h1>

    <div class="container">

        <?php
        // Exibe mensagem se houver
        if (!empty($mensagem)) {
            echo $mensagem;
        }

        // Verifica se há usuários e exibe
        if (empty($usuarios)) {
            echo "<p style='text-align:center; color:#777;'>Nenhum usuário encontrado.</p>";
        } else {
            foreach ($usuarios as $usuarioData) {
                echo "
                <div class='card'>
                    <div class='info'><strong>ID:</strong> " . htmlspecialchars($usuarioData['id']) . "</div>
                    <div class='info'><strong>Nome:</strong> " . htmlspecialchars($usuarioData['nome_usuario']) . "</div>
                    <div class='info'><strong>E-mail:</strong> " . htmlspecialchars($usuarioData['email']) . "</div>
                    <div class='acoes'>
                        <a href='editar.php?id=" . htmlspecialchars($usuarioData['id']) . "' class='btn btn-editar'>Editar</a>
                        <a href='?delete=" . htmlspecialchars($usuarioData['id']) . "' class='btn btn-deletar' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>Excluir</a>
                    </div>
                </div>
                ";
            }
        }
        ?>

    </div>

</body>

</html>