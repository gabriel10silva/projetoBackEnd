<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
}


?>




<!DOCTYPE html>
<html lang="pt-BR">

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
                <a href="#">
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
      
    </section>

    <script src="script.js"></script>
</body>

</html>