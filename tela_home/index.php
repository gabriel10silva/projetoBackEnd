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
        <div class="container">
    <!-- Post principal -->
    <div class="post-card">
      <div class="user-info">
        <div class="avatar">M</div>
        <div>
          <div class="user-name">Maria Silva</div>
          <div class="post-time">há 2 horas</div>
        </div>
      </div>

      <div class="post-content">
        Acabei de terminar um projeto incrível usando <strong>React</strong> e <strong>Tailwind</strong>! 
        A experiência de desenvolvimento foi fantástica. Alguém mais aqui usa essa stack?
      </div>

      <div class="post-image">
        <img src="https://cdn.pixabay.com/photo/2017/08/30/01/05/code-2697088_1280.jpg" alt="Código React">
      </div>

      <div class="post-actions">
        <span>❤️ 124</span>
        <span>💬 18</span>
        <span>🔗 Compartilhar</span>
      </div>
    </div>

    <!-- Barra lateral -->
    <aside class="sidebar-community">
      <h3>Comunidades Recomendadas</h3>

      <div class="community">
        <div class="community-icon">⚛️</div>
        <div class="community-info">
          <h4>Desenvolvedores React</h4>
          <p>Comunidade para discutir React, Next.js e ecossistema</p>
        </div>
        <button>Entrar</button>
      </div>

      <div class="community">
        <div class="community-icon">🎨</div>
        <div class="community-info">
          <h4>Design UI/UX</h4>
          <p>Compartilhe designs, dicas e tendências</p>
        </div>
        <button>Entrar</button>
      </div>

      <div class="community">
        <div class="community-icon">💻</div>
        <div class="community-info">
          <h4>Programação Web</h4>
          <p>Tudo sobre desenvolvimento web moderno</p>
        </div>
        <button>Entrar</button>
      </div>
    </aside>
  </div>
    </section>

    <script src="script.js"></script>
</body>

</html>