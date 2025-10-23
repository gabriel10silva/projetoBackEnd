<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
  header("Location: ../tela_login/index.php");
  exit();
}

$id = $_SESSION['id'];

$hash = md5(strtolower(trim($id)));
$gravatarUrl = "../uploads/profile.png";

$bio = 'Não Definida';
$foto_perfil = $gravatarUrl;

$sql = "SELECT nome_usuario, email_usuario, foto_perfil, bio, role FROM usuarios WHERE id = $id";
$result = mysqli_query($conexao, $sql);
$user = mysqli_fetch_assoc($result);


if ($user) {
  $bio = $user['bio'] ?? $bio;
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>projeto backend</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <!-- Adicionando fonte Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
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
        <a href="#">
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
  <div class="profile-container">
        <header class="profile-header">
            <h1 class="title">Meu Perfil</h1>
            <p class="subtitle">Gerencie suas informações pessoais</p>
        </header>

        <div class="profile-card">
            <nav class="profile-tabs">
                <button class="tab-button active" data-tab="view">
                    <span><i class="fa-regular fa-user"></i></span>
                    Visualizar Perfil
                </button>
                <button class="tab-button" data-tab="edit">
                    <span><i class="fa-solid fa-gear"></i></span>
                    Editar Perfil
                </button>
            </nav>

            <div class="profile-content">
                <div class="avatar-section">
                    <div class="avatar-wrapper">
                        <img src="<?= $foto_perfil ?>" alt="Ana Silva" class="profile-avatar" id="profile-avatar">
                        
                        <div class="avatar-overlay">
                            <span class="material-icons"><i class="fa-solid fa-download"></i></span>
                        </div>
                    </div>
                    
                    <p class="avatar-prompt" style="display: none;">Clique para alterar a foto</p>
                    
                    <div class="user-details-static">
                        <span class="name"><?= htmlspecialchars($user['nome_usuario']) ?><span class="material-icons verified-icon"><i class="fa-regular fa-circle-check"></i></span></span>
                        <span class="status-badge">Membro Ativo</span>
                    </div>
                </div>

                <div id="view-mode" class="content-section active">
                    <div class="info-block">
                        <span class="envelope"><i class='bx bx-envelope'></i> </span>
                        <div class="info-text">
                            <label>Email</label>
                            <p><?= htmlspecialchars($user['email_usuario']) ?></p>
                        </div>
                    </div>

                    <div class="info-block">
                        <span class="menssage"><i class='bx bx-message-dots'></i></span>
                        <div class="info-text">
                            <label>Biografia</label>
                            <p><?= htmlspecialchars($user['bio']) ?></p>
                        </div>
                    </div>
                </div>

                <div id="edit-mode" class="content-section">
                    <form class="edit-form">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" value="<?= htmlspecialchars($user['nome_usuario']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="<?= htmlspecialchars($user['email_usuario']) ?>" disabled>
                            <small class="help-text">O email não pode ser alterado</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="biografia">Biografia</label>
                            <input type="text" id="biografia" value="Desenvolvedora apaixonada por tecnologia e inovação. Amo criar experiências digitais incríveis.">
                            <small class="char-count">95 caracteres</small>
                        </div>
                        
                        <h3 class="section-title">Alterar Senha</h3>
                        <p class="help-text">Deixe os campos em branco para manter a senha atual</p>

                        <div class="form-group password-group">
                            <label for="nova-senha">Nova Senha</label>
                            <div class="input-with-icon">
                                <input type="password" id="nova-senha" placeholder="Mínimo 6 caracteres">
                                <span class="material-icons-outlined visibility-icon">visibility_off</span>
                            </div>
                        </div>

                        <button type="submit" class="save-button">
                            <span class="material-icons-outlined"><i class='bx bx-save'></i> </span>
                            Salvar Alterações
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>

  <script src="script.js"></script>