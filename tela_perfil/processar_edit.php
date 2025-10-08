<?php
require_once '../config/conexao.php';
session_start();

// Verifica sessão
if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
}

$id = $_SESSION['id'];

// Buscar dados atuais do usuário
$sql = "SELECT nome_usuario, senha, bio, foto_perfil FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

if (!$usuario) {
    die("Usuário não encontrado.");
}

// Receber dados do formulário
$novoNome  = trim($_POST['nome'] ?? '');
$novaSenha = $_POST['senha'] ?? '';
$novaBio   = trim($_POST['bio'] ?? '');

// Se o campo vier vazio, mantém o antigo
$nomeAtualizado = $novoNome !== '' ? $novoNome : $usuario['nome_usuario'];
$bioAtualizada  = $novaBio !== '' ? $novaBio : $usuario['bio'];

// Senha — só atualiza se for informada nova
if ($novaSenha !== '') {
    $senhaAtualizada = password_hash($novaSenha, PASSWORD_DEFAULT);
} else {
    $senhaAtualizada = $usuario['senha'];
}

// Foto de perfil
$fotoAtualizada = $usuario['foto_perfil'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $arquivoTmp = $_FILES['foto']['tmp_name'];
    $nomeArquivo = basename($_FILES['foto']['name']);
    $ext = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $permitidas)) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $novoNomeArquivo = uniqid('perfil_') . '.' . $ext;
        $destino = $uploadDir . $novoNomeArquivo;

        if (move_uploaded_file($arquivoTmp, $destino)) {
            $fotoAtualizada = $novoNomeArquivo;
        } else {
            error_log("Erro ao mover arquivo de $arquivoTmp para $destino");
        }
    }
}

// Atualiza os dados
$sql = "UPDATE usuarios 
        SET nome_usuario = ?, senha = ?, bio = ?, foto_perfil = ? 
        WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $nomeAtualizado, $senhaAtualizada, $bioAtualizada, $fotoAtualizada, $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php?msg=Perfil atualizado com sucesso");
    exit();
} else {
    echo "Erro ao atualizar: " . mysqli_error($conexao);
}
?>
