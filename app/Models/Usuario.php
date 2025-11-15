<?php

require_once __DIR__ . '/../../Config/Config.php';

/**
 * Classe Usuario - Gerencia operações CRUD de usuários
 */
class Usuario
{
    private $conexao;
    public $id;
    public $nome_usuario;
    public $email;
    public $senha;
    private $mensagem = '';
    private $tipo_mensagem = ''; // 'sucesso' ou 'erro'

    /**
     * Construtor - Inicializa o objeto Usuario
     */
    public function __construct($conexao = null, $id = null, $nome_usuario = null, $email = null, $senha = null)
    {
        global $conexao;
        $this->conexao = $conexao ?? $GLOBALS['conexao'] ?? null;
        $this->id = $id;
        $this->nome_usuario = $nome_usuario;
        $this->email = $email;
        $this->senha = $senha;
    }

    /**
     * Valida os dados do usuário
     */
    public function validar()
    {
        if (empty(trim($this->nome_usuario))) {
            $this->setMensagem('Nome é obrigatório.', 'erro');
            return false;
        }
        if (empty(trim($this->email)) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->setMensagem('E-mail inválido.', 'erro');
            return false;
        }
        if (empty($this->senha)) {
            $this->setMensagem('Senha é obrigatória.', 'erro');
            return false;
        }
        return true;
    }

    /**
     * Salva um novo usuário no banco
     */
    public function salvar()
    {
        try {
            if (!$this->validar()) {
                return false;
            }

            $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuario (nome_usuario, email, senha) VALUES (?, ?, ?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(1, $this->nome_usuario);
            $stmt->bindParam(2, $this->email);
            $stmt->bindParam(3, $senhaHash);

            if ($stmt->execute()) {
                $this->setMensagem('Usuário cadastrado com sucesso!', 'sucesso');
                $this->id = $this->conexao->lastInsertId();
                return true;
            }
            $this->setMensagem('Erro ao cadastrar usuário.', 'erro');
            return false;
        } catch (PDOException $e) {
            $this->setMensagem('Erro no banco: ' . $e->getMessage(), 'erro');
            return false;
        }
    }

    /**
     * Deleta um usuário pelo ID
     */
    public function deletar()
    {
        try {
            if (empty($this->id)) {
                $this->setMensagem('ID do usuário não definido.', 'erro');
                return false;
            }

            $sql = "DELETE FROM usuario WHERE id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(1, $this->id);

            if ($stmt->execute()) {
                $this->setMensagem('Usuário excluído com sucesso!', 'sucesso');
                return true;
            }
            $this->setMensagem('Erro ao excluir usuário.', 'erro');
            return false;
        } catch (PDOException $e) {
            $this->setMensagem('Erro no banco: ' . $e->getMessage(), 'erro');
            return false;
        }
    }

    /**
     * Busca todos os usuários
     */
    public static function buscarTodos($conexao)
    {
        try {
            $sql = "SELECT * FROM usuario";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Busca um usuário pelo ID
     */
    public static function buscarPorId($conexao, $id)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Define a mensagem
     */
    private function setMensagem($msg, $tipo)
    {
        $this->mensagem = $msg;
        $this->tipo_mensagem = $tipo;
    }

    /**
     * Retorna a mensagem formatada em HTML
     */
    public function getMensagem()
    {
        if (empty($this->mensagem)) {
            return '';
        }

        $classe = $this->tipo_mensagem === 'sucesso' ? 'mensagem-sucesso' : 'mensagem-erro';
        $cor = $this->tipo_mensagem === 'sucesso' ? 'green' : 'red';

        return "<p style='color: $cor; text-align: center; padding: 10px; border-radius: 5px; background-color: " 
               . ($this->tipo_mensagem === 'sucesso' ? '#d4edda' : '#f8d7da') . ";'>" 
               . htmlspecialchars($this->mensagem) . "</p>";
    }

    /**
     * Retorna os dados do usuário como array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'nome_usuario' => $this->nome_usuario,
            'email' => $this->email,
            'senha' => $this->senha
        ];
    }
}

?>
