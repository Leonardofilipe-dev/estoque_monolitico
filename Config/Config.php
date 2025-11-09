<?php


$conexao = null;
try {
    $conexao = new PDO("mysql:host=localhost; dbname=estoque_db", "root", "");
    // echo "Conexão realizada com sucesso!";
} catch (PDOException $erro) {
    echo "Erro na conexão: " . $erro->getMessage();
}

?>



