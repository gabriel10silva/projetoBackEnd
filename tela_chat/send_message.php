<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    exit("Usuário não logado");
}

$userId = $_SESSION['id'];
$communityId = isset($_POST['communityId']) ? intval($_POST['communityId']) : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($communityId <= 0 || empty($message)) {
    exit("Dados inválidos");
}

// Escapa caracteres para evitar SQL Injection
$message = mysqli_real_escape_string($conexao, $message);

// Insere a mensagem no banco
$sql = "INSERT INTO mensagens_comunidade (id_comunidade, id_usuario, mensagem) VALUES ($communityId, $userId, '$message')";
if (mysqli_query($conexao, $sql)) {
    echo "ok";
} else {
    echo "Erro ao enviar mensagem: " . mysqli_error($conexao);
}
?>
