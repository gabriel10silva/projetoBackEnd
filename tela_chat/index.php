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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projeto backend</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />


</head>

<body>
    <div class="sidebar">

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
                <a href="../config/logout.php"><i class="bx bx-log-out" id="log_out" title="Sair"></i></a>
            </li>
        </ul>
    </div>

    <section class="chat">
        <div class="chats">
            <div class="header">
                <div class="logo-details">
                    <img src="../uploads/profile.png" alt="">
                </div>
                <ul>
                    <li>
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </li>
                </ul>
            </div>
            <div class="search-chat">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search start new chat...">
            </div>

            <div class="container">
                <div class="chat-menssage">
                    <div class="card active">
                        <img src="../uploads/profile.png" alt="">
                        <div class="info">
                            <h3 class="nameChat">Nome Comunidade</h3>
                            <p class="timeChat">10:30</p>
                        </div>
                    </div>
                    
                </div>
                <div class="chat-menssage">
                    <div class="card">
                        <img src="../uploads/profile.png" alt="">
                        <div class="info">
                            <h3 class="nameChat">Nome Comunidade</h3>
                            <p class="timeChat">10:30</p>
                        </div>
                    </div>
                    
                </div>
            </div>

            
            
        </div>
        <section class="areaMenssage">
            <div class="headerMenssage">
                <div class="logo">
                    <img src="../uploads/profile.png" alt="">
                    <h3>Nome Comunidade</h3>
                </div>
            </div>

            <div class="menssage">

            </div>

            <div class="menssageInput">
                <input type="text" placeholder="Escreva sua Mensagem....">
                <i class='bx bx-send'></i> 
            </div>
        </section>

    </section>



    <script src="script.js"></script>
</body>

</html>