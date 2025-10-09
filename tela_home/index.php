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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projeto backend</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-pen icon"></i>
            <div class="logo_name">projeto back</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <i class="bx bx-search"></i>
                <input type="text" placeholder="Pesquisar..." id="buscar" name="busca" aria-label="Pesquisar" />
                <span class="tooltip">Pesquisa</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bx-home"></i>
                    <span class="links_name">Início</span>
                </a>
                <span class="tooltip">Início</span>
            </li>
            <li>
                <a href="../tela_chat/index.php">
                    <i class='bx bx-message'></i>
                    <span class="links_name">Chat</span>
                </a>
                <span class="tooltip">Chat</span>
            </li>
            <li>
                <a href="../tela_myquests/">
                <i class="fa-regular fa-folder"></i>
                    <span class="links_name">Minhas Dúvidas</span>
                </a>
                <span class="tooltip">Minhas Dúvidas</span>
            </li>
            <li>
                <a href="../tela_perfil/index.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Perfil</span>
                </a>
                <span class="tooltip">Perfil</span>
            </li>

            <li>
                <a href="../tela_config/index.php">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Configuração</span>
                </a>
                <span class="tooltip">Configuração</span>
            </li>

            <li class="profile">
                <div class="profile-details">
                    <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Imagem do perfil" />
                    <div class="name_job">
                        <div class="name"><?= htmlspecialchars($user['nome_usuario']) ?></div>
                        <div class="job"><?= htmlspecialchars($user['role']) ?></div>

                    </div>
                </div>
                <a href="../config/logout.php"><i class="bx bx-log-out" id="log_out" title="Sair"></i></a>
            </li>
        </ul>
    </div>

    <section class="home-section">

        <section class="chat">
            <main class="container">

                <div class="addQuest">
                    <p class="topic-title-page">Possui alguma duvida?</p>
                    <div class="inputQuest">
                        <button onclick="addDuvida()">Adicionar uma duvida</button>
                    </div>
                </div>

                <h2 class="topic-title-page">Como começar com HTML e CSS?</h2>
                <div class="post-container">
                    <div class="post">
                        <div class="post-author">
                            <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="foto de perfil" class="author-avatar">
                            <div class="author-info">
                                <span class="author-name">Usuário</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <p>Olá, pessoal! Sou novo na área e gostaria de saber quais os primeiros passos para
                                aprender
                                HTML e CSS. Alguma dica de tutorial ou projeto para iniciantes?</p>
                        </div>
                        <div class="post-meta">
                            <span class="post-date">01/10/2025</span>
                            <div class="post-actions">
                                <a href="#">Curtir</a>
                                <a href="#" onclick="toggleReplyForm('replyForm1')">Responder</a>
                                <a href="#" onclick="viewReplies()">Ver Respostas</a>
                            </div>
                        </div>
                        <div class="reply-form hidden" id="replyForm1">
                            <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="foto de perfil" class="author-avatar">
                            <textarea placeholder="Escreva uma resposta..."></textarea>
                            <button class="btnSend">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="replies hidden" id="replyForm2">
                            <div class="post reply-post">
                                <div class="post-author">
                                    <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="foto de perfil"
                                        class="author-avatar">
                                    <div class="author-info">
                                        <span class="author-name">Maria Oliveira</span>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <p>Eu recomendo o MDN Web Docs. A documentação deles é muito completa e fácil de
                                        entender. Tente criar um site simples como um currículo online!</p>
                                </div>
                                <div class="post-meta">
                                    <span class="post-date">01/10/2025</span>
                                    <div class="post-actions">
                                        <a href="#">Curtir</a>
                                        <a href="#" onclick="toggleReplyForm('replyForm2')">Responder</a>
                                    </div>
                                </div>
                                <div class="reply-form hidden" id="replyForm2">
                                    <img src="../uploads/profile.png" alt="Seu Avatar" class="author-avatar">
                                    <textarea placeholder="Escreva uma resposta..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </section>

        <section class="groups">
            <div class="container">
                <h2 class="topic-title-page">Comunidades Recomendadas</h2>
                <div class="cards">

                    <div class="card">
                        <div class="card-header">
                            <img src="../uploads/profile.png" alt="Foto do grupo">
                            <h2>Nome do Grupo</h2>
                        </div>
                        <div class="card-body">
                            <p>Essa é uma breve descrição sobre o grupo, seu objetivo ou tema.</p>
                            <a href="#" class="btn-entrar">Entrar</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <img src="../uploads/profile.png" alt="Foto do grupo">
                            <h2>Nome do Grupo</h2>
                        </div>
                        <div class="card-body">
                            <p>Essa é uma breve descrição sobre o grupo, seu objetivo ou tema.</p>
                            <a href="#" class="btn-entrar">Entrar</a>
                        </div>
                    </div>


                </div>
        </section>
    </section>



</body>

</html>


<script src="script.js"></script>
</body>

</html>