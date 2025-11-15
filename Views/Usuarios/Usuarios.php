<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>

    <a href="../../index.php">Voltar a página de cadastro</a>

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

<body>

    <h1>Lista de Usuários</h1>

    <div class="container">

        <?php
        require_once __DIR__ . "/../../Config/Config.php";

        // Função para deletar usuário
        function deletarUsuario($conexao, $id)
        {
            try {
                $sql = $conexao->prepare("DELETE FROM usuario WHERE id = ?");
                $sql->bindParam(1, $id);
                return $sql->execute();
            } catch (PDOException $e) {
                return false;
            }
        }

        class Usuario
        {
            public $id;
            public $nome_usuario;
            public $email;
            public $senha;

            public function __construct($id, $nome_usuario, $email, $senha)
            {
                $this->id = $id;
                $this->nome_usuario = $nome_usuario;
                $this->email = $email;
                $this->senha = $senha;
            }

            public static function mostrarTodosUsuarios($conexao)
            {
                try {
                    $sql = "SELECT * FROM usuario";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($usuarios)) {
                        echo "<p style='text-align:center; color:#777;'>Nenhum usuário encontrado.</p>";
                        return;
                    }

                    foreach ($usuarios as $usuario) {
                        echo "
                <div class='card'>
                    <div class='info'><strong>ID:</strong> " . htmlspecialchars($usuario['id']) . "</div>
                    <div class='info'><strong>Nome:</strong> " . htmlspecialchars($usuario['nome_usuario']) . "</div>
                    <div class='info'><strong>E-mail:</strong> " . htmlspecialchars($usuario['email']) . "</div>
                    <div class='info'><strong>Senha:</strong> " . htmlspecialchars($usuario['senha']) . "</div>
                    <div class='acoes'>
                        <a href='editar.php?id=" . htmlspecialchars($usuario['id']) . "' class='btn btn-editar'>Editar</a>
                        <a href='?delete=" . htmlspecialchars($usuario['id']) . "' class='btn btn-deletar' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>Excluir</a>
                    </div>
                </div>
                ";
                    }
                } catch (PDOException $e) {
                    echo "<p style='color:red; text-align:center;'>Erro ao listar usuários: " . $e->getMessage() . "</p>";
                }
            }
        }

        // Processar exclusão
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            if (deletarUsuario($conexao, $id)) {
                echo "<p class='mensagem mensagem-sucesso'>Usuário excluído com sucesso!</p>";
            } else {
                echo "<p class='mensagem mensagem-erro'>Erro ao excluir usuário.</p>";
            }
        }

        Usuario::mostrarTodosUsuarios($conexao);
        ?>

    </div>

</body>

</html>
