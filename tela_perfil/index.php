<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
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
                <a href="#">
                    <i class='bx bx-user'  ></i> 
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
                    <img src="../uploads/profile.png" alt="Imagem do perfil" />
                    <div class="name_job">
                        <div class="name">Nome Usuário</div>
                        <div class="job">Tipo de Usuário</div>

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
        <img src="../uploads/profile.png" alt="Foto do Usuário">
        <h1>Nome Usuário</h1>
        <p>email Usuário</p>
        <p>Bio usuário</p>

        <div class="stats">
              <div class="stat">(Número) - Comunidades Ativas</div>
              <div class="stat">Não sei o que colocar</div>
            </div>
      </div>


      <!-- Perfil - Edição -->
      <div class="edit-section">
        <h2>Editar Perfil</h2>
        <form id="editForm" onsubmit="return confirmarEdicao();" action="../config/edit_perfil.php" method="post" enctype="multipart/form-data">
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