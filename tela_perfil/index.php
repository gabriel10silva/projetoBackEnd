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
    <div class="container">

      <!-- Perfil - Visualização -->
      <div class="profile-section">
        <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Foto do Usuário">
        <h1><?= htmlspecialchars($user['nome_usuario']) ?></h1>
        <p><?= htmlspecialchars($user['email_usuario']) ?></p>
        <p><?= htmlspecialchars($bio) ?></p>

        <div class="stats">
          <div class="stat">(Número) - Comunidades Ativas</div>
          <div class="stat">Não sei o que colocar</div>
        </div>
      </div>


      <!-- Perfil - Edição -->
      <div class="edit-section">
        <h2>Editar Perfil</h2>
        <form id="editForm" action="processar_edit.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Seu nome completo">
          </div>

          <div class="form-group">
            <label for="senha">Nova Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Digite nova senha">
          </div>

          <div class="form-group">
            <label for="foto">Foto de Perfil</label>
            <input type="file" name="foto" id="foto">
          </div>

          <div class="form-group">
            <label for="bio">Bio / Sobre Você</label>
            <textarea id="bio" name="bio" rows="4" placeholder="Conte um pouco sobre você..."></textarea>
          </div>

          <button type="submit">Salvar Alterações</button>
        </form>
        <button id="btn-sair" type="button" class="sair">Sair</button>
      </div>
    </div>
  </section>

  <!-- Popups de confirmação -->
  <div id="confirm1" class="popup-confirm">
    <div class="popup-content">
      <p>Tem certeza que deseja salvar as alterações?</p>
      <button id="confirm1-sim">Sim</button>
      <button id="confirm1-nao">Não</button>
    </div>
  </div>

  <div id="confirm2" class="popup-confirm">
    <div class="popup-content">
      <p>Confirme novamente para salvar?</p>
      <button id="confirm2-sim">Confirmar</button>
      <button id="confirm2-nao">Cancelar</button>
    </div>
  </div>

  <div id="confirmacao-final" class="popup-confirm">
    <div class="popup-content">
      <p>Alterações confirmadas com sucesso!</p>
      <button id="btn-fechar-final">Fechar</button>
    </div>
  </div>

  <!-- SAIR -->

  <div id="sair1" class="popup-confirm">
    <div class="popup-content">
      <p>Tem certeza que quer sair da conta?</p>
      <button id="sair-sim">Confirmar</button>
      <button id="sair-nao">Cancelar</button>
    </div>
  </div>



  </section>

  <script src="script.js"></script>