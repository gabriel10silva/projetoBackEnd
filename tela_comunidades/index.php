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
                        <div class="name"><?= htmlspecialchars($user['nome_usuario']) ?></div>
                        <div class="job"><?= htmlspecialchars($user['role']) ?></div>

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
          <a href="../tela_perfil/index.php"><img src="<?= $foto_perfil ?>" alt="Imagem do perfil" /></a>
        </li>
      </ul>
    </header>
  </section>

    <section class="home-section">
        <main class="container">
            <h1>Descubra Comunidades</h1>
            <p class="subtitle">Encontre e participe de grupos com interesses em comum</p>
        
            <div class="search-bar">
              <input type="text" id="searchInput" placeholder="Buscar comunidades..." />
            </div>
        
            <div class="filters">
              <button class="filter active">Todos</button>
              <button class="filter">Tecnologia</button>
              <button class="filter">Humanas</button>
              <button class="filter">Exatas</button>
            </div>
        
            <p class="results">2 comunidades encontradas</p>
        
            <div class="cards">
              <div class="card">
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80" alt="Empreendedores Digitais" />
                <div class="card-content">
                  <h3>Empreendedores Digitais</h3>
                  <span class="tag">Tecnologia</span>
                  <p>Networking e troca de experiências para empreendedores e startups.</p>
                  <p class="members">👥 15.680 membros</p>
                  <button class="join-btn">Participar</button>
                </div>
              </div>
        
              <div class="card">
                <div class="hot-tag">🔥 Em Alta</div>
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80" alt="Marketing Digital" />
                <div class="card-content">
                  <h3>Marketing Digital</h3>
                  <span class="tag">Exatas</span>
                  <p>Estratégias, ferramentas e cases de sucesso em marketing digital.</p>
                  <p class="members">👥 13.450 membros</p>
                  <button class="join-btn">Participar</button>
                </div>
              </div>
              
              <div class="card">
                <div class="hot-tag">🔥 Em Alta</div>
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80" alt="Marketing Digital" />
                <div class="card-content">
                  <h3>Marketing Digital</h3>
                  <span class="tag">Exatas</span>
                  <p>Estratégias, ferramentas e cases de sucesso em marketing digital.</p>
                  <p class="members">👥 13.450 membros</p>
                  <button class="join-btn">Participar</button>
                </div>
              </div>
            </div>
          </main>
    </section>

    <script src="script.js"></script>
</body>
</html>