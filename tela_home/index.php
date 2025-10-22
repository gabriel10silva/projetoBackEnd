<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
}

$id_usuario_logado = $_SESSION['id'];
$gravatarUrl = "../uploads/profile.png"; // Fallback URL padrão

// 1. PREPARED STATEMENT para buscar dados do usuário logado (SEGURANÇA)
$stmt = $conexao->prepare("SELECT nome_usuario, foto_perfil, role FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id_usuario_logado);
$stmt->execute();
$resultado = $stmt->get_result();

if (!$resultado || $resultado->num_rows === 0) {
    echo "Usuário não encontrado.";
    exit;
}

$user = $resultado->fetch_assoc();
$stmt->close();

// Define a imagem de perfil do usuário logado
$foto_perfil_logado = $gravatarUrl;
if ($user && !empty($user['foto_perfil'])) {
    $foto_path = '../uploads/' . $user['foto_perfil'];
    if (file_exists($foto_path)) {
        $foto_perfil_logado = $foto_path;
    }
}

// 2. Consulta de Dúvidas (mantida fora do loop, OK)
$sqlDuvidas = "SELECT d.*, u.nome_usuario, u.foto_perfil, u.id as id_autor_duvida 
               FROM duvidas d 
               JOIN usuarios u ON d.id_usuario = u.id
               ORDER BY d.data_criacao DESC";
$resultDuvidas = mysqli_query($conexao, $sqlDuvidas);

// 3. OTIMIZAÇÃO: Consulta todas as Respostas de uma vez e as agrupa (PERFORMANCE)
$respostas_agrupadas = [];
$sqlTodasRespostas = "SELECT r.*, u.nome_usuario, u.foto_perfil 
                      FROM respostas r
                      JOIN usuarios u ON r.id_usuario = u.id
                      ORDER BY r.data_criacao ASC";
$resultTodasRespostas = mysqli_query($conexao, $sqlTodasRespostas);

if ($resultTodasRespostas) {
    while ($resposta = mysqli_fetch_assoc($resultTodasRespostas)) {
        $id_duvida = $resposta['id_duvida'];
        if (!isset($respostas_agrupadas[$id_duvida])) {
            $respostas_agrupadas[$id_duvida] = [];
        }
        $respostas_agrupadas[$id_duvida][] = $resposta;
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
                <a href="../tela_comunidades/index.html">
                    <i class="fa-regular fa-comments"></i>
                    <span class="links_name">Comunidades</span>
                </a>
                <span class="tooltip">Comunidades</span>
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
                    <p class="topic-title-page">Possui alguma dúvida?</p>
                    <div class="inputQuest">
                        <a href="criar_post.php"><button>Adicionar uma dúvida</button></a>
                    </div>
                </div>

                <div class="post-container">
                    <?php while ($duvida = mysqli_fetch_assoc($resultDuvidas)):
                        $postId = $duvida['id'];
                        ?>
                        <div class="post" id="post<?= $postId ?>">
                            <!-- Autor do post -->
                            <div class="post-author">
                                <img src="<?= !empty($duvida['foto_perfil']) ? '../uploads/' . $duvida['foto_perfil'] : '../uploads/profile.png' ?>"
                                    class="author-avatar">
                                <div class="author-info">
                                    <span class="author-name"><?= htmlspecialchars($duvida['nome_usuario']) ?></span>
                                </div>
                            </div>

                            <!-- Conteúdo do post -->
                            <div class="post-content">
                                <h3><?= htmlspecialchars($duvida['titulo']) ?></h3>
                                <p><?= htmlspecialchars($duvida['conteudo']) ?></p>
                            </div>

                            <!-- Meta do post -->
                            <div class="post-meta">
                                <span class="post-date"><?= date('d/m/Y', strtotime($duvida['data_criacao'])) ?></span>
                                <div class="post-actions">
                                    <a href="#">Curtir (<?= $duvida['curtidas'] ?>)</a>
                                    <a href="#" onclick="toggleReplyForm('replyForm<?= $postId ?>')">Responder</a>
                                    <a href="#" onclick="viewReplies('replies<?= $postId ?>')">Ver Respostas</a>
                                </div>
                            </div>

                            <!-- Formulário do post -->
                            <div class="reply-form hidden" id="replyForm<?= $postId ?>">
                                <img src="<?= $foto_perfil ?>" class="author-avatar">
                                <textarea placeholder="Escreva uma resposta..."></textarea>
                                <button class="btnSend">Enviar</button>
                            </div>

                            <!-- Respostas -->
                            <div class="replies hidden" id="replies<?= $postId ?>">
                                <?php
                                $sqlRespostas = "SELECT r.*, u.nome_usuario, u.foto_perfil 
                                             FROM respostas r
                                             JOIN usuarios u ON r.id_usuario = u.id
                                             WHERE r.id_duvida = $postId
                                             ORDER BY r.data_resposta ASC";
                                $resultRespostas = mysqli_query($conexao, $sqlRespostas);
                                while ($resposta = mysqli_fetch_assoc($resultRespostas)):
                                    $replyId = $resposta['id'];
                                    ?>
                                    <div class="post reply-post" id="reply<?= $replyId ?>">
                                        <div class="post-author">
                                            <img src="<?= !empty($resposta['foto_perfil']) ? '../uploads/' . $resposta['foto_perfil'] : '../uploads/profile.png' ?>"
                                                class="author-avatar">
                                            <div class="author-info">
                                                <span
                                                    class="author-name"><?= htmlspecialchars($resposta['nome_usuario']) ?></span>
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <p><?= htmlspecialchars($resposta['conteudo']) ?></p>
                                        </div>
                                        <div class="post-meta">
                                            <span
                                                class="post-date"><?= date('d/m/Y', strtotime($resposta['data_resposta'])) ?></span>
                                            <div class="post-actions">
                                                <a href="#">Curtir</a>
                                                <a href="#" onclick="toggleReplyForm('replyForm<?= $replyId ?>')">Responder</a>
                                            </div>
                                        </div>

                                        <!-- Formulário dentro da resposta -->
                                        <div class="reply-form hidden" id="replyForm<?= $replyId ?>">
                                            <img src="<?= $foto_perfil ?>" class="author-avatar">
                                            <textarea placeholder="Escreva uma resposta..."></textarea>
                                            <button class="btnSend">Enviar</button>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </main>
        </section>

        <!-- Comunidades Recomendadas -->
        <section class="groups">
            <div class="container">
                <h2 class="topic-title-page">Comunidades Recomendadas</h2>
                <div class="cards">
                    <div class="card">
                        <div class="card-header">
                            <img src="../uploads/profile.png" alt="Foto do grupo">
                            <h2>Grupo de Matemática</h2>
                        </div>
                        <div class="card-body">
                            <p>Discussões e dúvidas sobre Matemática.</p>
                            <a href="#" class="btn-entrar">Entrar</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <img src="../uploads/profile.png" alt="Foto do grupo">
                            <h2>Grupo de Programação</h2>
                        </div>
                        <div class="card-body">
                            <p>Compartilhe códigos e tire dúvidas de programação.</p>
                            <a href="#" class="btn-entrar">Entrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <script src="script.js"></script>
</body>

</html>