<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
  header("Location: ../tela_login/index.php");
  exit();
}

$id_usuario_logado = $_SESSION['id'];
$gravatarUrl = "../uploads/profile.png";
$foto_perfil = $gravatarUrl;


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
    <title>StackShare</title>
    <link rel="shortcut icon" href="../uploads/img_favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="fa-solid fa-layer-group icon"></i>
            <div class="logo_name">StackShare</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="../tela_home/index.php">
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
                <a href="../tela_comunidades/index.php">
                    <i class="fa-regular fa-comments"></i>
                    <span class="links_name">Comunidades</span>
                </a>
                <span class="tooltip">Comunidades</span>
            </li>
            <li>
                <a href="../tela_meus_posts/index.php">
                    <i class="fa-regular fa-folder"></i>
                    <span class="links_name">Minhas Dúvidas</span>
                </a>
                <span class="tooltip">Minhas Dúvidas</span>
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
                    <div class="name_job">
                        <div class="name">
                            <?= htmlspecialchars($user['nome_usuario']) ?>
                        </div>
                        <div class="job">
                            <?= htmlspecialchars($user['role']) ?>
                        </div>

                    </div>
                </div>
                <a href="../config/logout.php"><i class="bx bx-log-out" id="log_out" title="Sair"></i></a>
            </li>
        </ul>
    </div>

    <section class="header-section">

        <header>
            <div class="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Pesquisar...">
            </div>
            <ul>
                <li>
                    <button><i class="fa-solid fa-plus"></i> Nova Pergunta</button>
                </li>
                <li>
                    <img src="<?= $foto_perfil ?>" alt="Imagem do perfil" />
                </li>
            </ul>
        </header>
    </section>

    <section class="home-section">
        <main class="feed-container">
            <h1>Meus Posts</h1>
            <div class="tabs">
                <button class="tab active">Recentes</button>
                <button class="tab">Populares</button>
                <button class="tab">Sem Resposta</button>
            </div>

            <div class="post">
                <div class="post-header">
                    <div class="user-info">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Usuário">
                        <div>
                            <p class="username">Usuário <span>(Você)</span></p>
                            <span class="tag">Exatas</span>
                            <p class="time">há 15min</p>
                        </div>
                    </div>
                    <button class="menu-btn">⋯</button>
                </div>

                <div class="post-body">
                    <h3>Dúvida sobre derivadas parciais</h3>
                    <p>Alguém pode explicar melhor quando usar derivadas parciais em equações diferenciais? Estou com
                        dificuldade em entender a aplicação prática.</p>
                    <p class="hashtags">#cálculo #matemática #derivadas</p>
                </div>

                <div class="post-footer">
                    <div class="actions">
                        <button>👍 8</button>
                        <button>💬 5</button>
                    </div>
                    <button class="save-btn">🔖</button>
                </div>
            </div>

            <div class="post">
                <div class="post-header">
                    <div class="user-info">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Usuário">
                        <div>
                            <p class="username">Usuário <span>(Você)</span></p>
                            <span class="tag">Extas</span>
                            <p class="time">há 1h</p>
                        </div>
                    </div>
                    <button class="menu-btn">⋯</button>
                </div>

                <div class="post-body">
                    <h3>Resumo: Segunda Lei de Newton</h3>
                    <p>Fiz um resumo da Segunda Lei de Newton para a prova. A força resultante é igual ao produto da
                        massa pela aceleração (F = m·a). Lembrem-se que a direção e sentido da força resultante são os
                        mesmos da aceleração!</p>
                    <p class="hashtags">#física #mecânica #newton</p>
                    <img src="https://images.unsplash.com/photo-1581092334651-ddf26d9a09d3?auto=format&fit=crop&w=1000&q=80"
                        alt="Fórmulas de física">
                </div>

                <div class="post-footer">
                    <div class="actions">
                        <button>👍 12</button>
                        <button>💬 3</button>
                    </div>
                    <button class="save-btn">🔖</button>
                </div>
            </div>
        </main>

        <script src="script.js"></script>
</body>

</html>