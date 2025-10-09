<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
}

$id = $_SESSION['id'];
$gravatarUrl = "../uploads/profile.png";
$foto_perfil = $gravatarUrl;

// Busca os dados do usuário com MySQLi
$sql = "SELECT nome_usuario, foto_perfil, role FROM usuarios WHERE id = $id";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    echo "Usuário não encontrado.";
    exit;
}

$user = mysqli_fetch_assoc($resultado);

// Define imagem padrão caso não tenha foto
if ($user) {
    if (!empty($user['foto_perfil'])) {
        $foto_path = '../uploads/' . $user['foto_perfil'];
        if (file_exists($foto_path)) {
            $foto_perfil = $foto_path;
        }
    }
}

$mensagem = "";

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = mysqli_real_escape_string($conexao, trim($_POST['titulo']));
    $conteudo = mysqli_real_escape_string($conexao, trim($_POST['conteudo']));

    if (!empty($titulo) && !empty($conteudo)) {
        $sql = "INSERT INTO posts (user_id, title, content, created_at) VALUES ($id_usuario, '$titulo', '$conteudo', NOW())";
        if (mysqli_query($conexao, $sql)) {
            header("Location: ../tela_home/index.php?post_sucesso=1");
            exit();
        } else {
            $mensagem = "Erro ao publicar sua dúvida: " . mysqli_error($conexao);
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos!";
    }
}

?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="criar_post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
</head>

<body>


    <section class="home-section">
        <div class="container">

            <div class="content">
                <h1>Criar Nova Dúvida</h1>

                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
                <?php endif; ?>

                <form action="" method="POST" class="form-post">
                    <label for="titulo">Título da Dúvida:</label>
                    <input type="text" name="titulo" id="titulo" placeholder="Ex: Como centralizar um elemento no CSS?" required>

                    <label for="conteudo">Descrição da Dúvida:</label>
                    <textarea name="conteudo" id="conteudo" rows="6" placeholder="Descreva sua dúvida com detalhes..." required></textarea>

                    <button type="submit" class="btn-publicar">
                        <i class="fa-solid fa-paper-plane"></i> Publicar
                    </button>
                </form>

                <a href="../tela_home/index.php" class="btn-voltar">
                    <i class="fa-solid fa-arrow-left"></i> Voltar à Home
                </a>
            </div>
        </div>




    </section>


    <script src="script.js"></script>
</body>

</html>