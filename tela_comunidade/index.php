<?php
session_start();
require_once '../config/conexao.php';

// Verifica se usuário está logado
if(!isset($_SESSION['id'])){
    header("Location: ../tela_login/index.php");
    exit();
}

$userId = $_SESSION['id'];
$error = '';
$success = '';

// Processar formulário
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);

    // Upload de imagem
    $foto = 'profile.png'; // padrão
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0){
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = 'comu_'.time().'.'.$ext;
        $destino = '../uploads/'.$novo_nome;
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)){
            $foto = $novo_nome;
        }
    }

    // Validação simples
    if(empty($nome)){
        $error = "O nome da comunidade é obrigatório.";
    } else {
        // Inserir comunidade
        $sql = "INSERT INTO comunidades (nome, descricao, foto_comunidade) 
                VALUES ('".mysqli_real_escape_string($conexao, $nome)."', '".mysqli_real_escape_string($conexao, $descricao)."', '".mysqli_real_escape_string($conexao, $foto)."')";
        if(mysqli_query($conexao, $sql)){
            $comuId = mysqli_insert_id($conexao);
            // Adicionar o usuário como membro
            mysqli_query($conexao, "INSERT INTO membros_comunidades (id_usuario, id_comunidade) VALUES ($userId, $comuId)");
            $success = "Comunidade criada com sucesso!";
        } else {
            $error = "Erro ao criar comunidade.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Criar Comunidade</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Criar Nova Comunidade</h2>

    <?php if($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if($success): ?>
        <p style="color:green"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label>Nome da Comunidade:</label><br>
            <input type="text" name="nome" required>
        </div>
        <div>
            <label>Descrição:</label><br>
            <textarea name="descricao"></textarea>
        </div>
        <div>
            <label>Foto da Comunidade:</label><br>
            <input type="file" name="foto" accept="image/*">
        </div>
        <br>
        <button type="submit">Criar Comunidade</button>
    </form>
    <br>
    <a href="index.php">Voltar ao Chat</a>
</div>
</body>
</html>
