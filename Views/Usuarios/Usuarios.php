<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>

    <a href="../../index.php">Voltar a pagina de cadastro</a>

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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: 0.3s;
            
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }

        .info {
            margin: 8px 0;
            font-size: 16px;
            color: #444;
            display: inline-block;
        }

        .info strong {
            color: #222;
        }
    </style>
</head>

<body>

<h1>Lista de Usuários</h1>

<div class="container">

<?php
require_once __DIR__ . "/../../Config/Config.php";

class Usuario {
    public $id;
    public $nome_usuario;
    public $email;
    public $senha;

    public function __construct($id, $nome_usuario, $email, $senha) {
        $this->id = $id;
        $this->nome_usuario = $nome_usuario;
        $this->email = $email;
        $this->senha = $senha;
    }

    public static function mostrarTodosUsuarios($conexao) {
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
                    <div class='info'><strong>ID:</strong> {$usuario['id']}</div>
                    <div class='info'><strong>Nome:</strong> {$usuario['nome_usuario']}</div>
                    <div class='info'><strong>E-mail:</strong> {$usuario['email']}</div>
                    <div class='info'><strong>Senha:</strong> {$usuario['senha']}</div>
                </div>
                ";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red; text-align:center;'>Erro ao listar usuários: " . $e->getMessage() . "</p>";
        }
    }
}

Usuario::mostrarTodosUsuarios($conexao);
?>

</div>

</body>
</html>
