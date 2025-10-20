<?php
session_start();

// O require_once deve vir antes de qualquer uso da variável $conexao
require_once '../config/conexao.php';

// Verifica se o formulário foi enviado pelo método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_usuario'], $_POST['email'], $_POST['senha'])) {
    // Recebe os dados do formulário
    $nome_usuario = $_POST['nome_usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Criptografia da senha com hash
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Usa prepared statement para inserir os dados no banco
    $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha) VALUES (?, ?, ?)";

    // Prepara a consulta SQL
    $stmt = mysqli_prepare($conexao, $sql);

    // Verifica se a preparação da consulta falhou
    if ($stmt === false) {
        // Retorna um erro para o JavaScript tratar
        echo "Erro na preparação da consulta: " . mysqli_error($conexao);
        exit;
    }

    // Liga as variáveis aos marcadores de interrogação
    mysqli_stmt_bind_param($stmt, "sss", $nome_usuario, $email, $senha_hash);

    // Executa a declaração
    if (mysqli_stmt_execute($stmt)) {
        // Obtém o ID do usuário inserido
        $ultimo_id = mysqli_insert_id($conexao);

        // Define as variáveis da sessão
        $_SESSION['id_usuario'] = $ultimo_id;
        $_SESSION['nome_usuario'] = $nome_usuario;

        // *** MUDANÇA AQUI: Redireciona para o formulário de perfil ***
        header('Location: ../pesquisa/index.php');
        exit; // Sempre usar exit após header('Location')
    } else {
        // Retorna uma mensagem de erro para o JavaScript
        header("Location: index.php?Erro ao cadastrar: " . mysqli_stmt_error($stmt));
    }

    // Libera os recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);

} else {
    // Redireciona se a requisição não for POST
    header('Location: index.php');
    exit;
}
?>