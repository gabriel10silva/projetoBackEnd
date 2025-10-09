<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
}

$id_usuario = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $conteudo = mysqli_real_escape_string($conexao, $_POST['conteudo']);

    $sql = "INSERT INTO duvidas (id_usuario, titulo, conteudo, data_criacao) VALUES ($id_usuario, '$titulo', '$conteudo', NOW())";
    mysqli_query($conexao, $sql);

    header("Location: ../tela_home/index.php");
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