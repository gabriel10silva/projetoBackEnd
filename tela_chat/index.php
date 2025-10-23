<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../tela_login/index.php");
    exit();
}

$userId = $_SESSION['id'];
$userName = $_SESSION['nome_usuario'] ?? 'Usuário';
$gravatarUrl = "../uploads/profile.png";

// Pega foto de perfil do usuário
$foto_perfil_logado = $gravatarUrl;
$sqlUser = "SELECT foto_perfil FROM usuarios WHERE id = $userId";
$resUser = mysqli_query($conexao, $sqlUser);
if ($resUser && mysqli_num_rows($resUser) > 0) {
    $userData = mysqli_fetch_assoc($resUser);
    if (!empty($userData['foto_perfil']) && file_exists('../uploads/' . $userData['foto_perfil'])) {
        $foto_perfil_logado = '../uploads/' . $userData['foto_perfil'];
    }
}

// Busca comunidades do usuário com última mensagem
$sql = "
SELECT c.id, c.nome, c.foto_comunidade,
       (SELECT MAX(m.data_envio)
        FROM mensagens_comunidade m
        WHERE m.id_comunidade = c.id) AS ultima_mensagem
FROM comunidades c
JOIN membros_comunidades mc ON mc.id_comunidade = c.id
WHERE mc.id_usuario = $userId
ORDER BY ultima_mensagem DESC
";
$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Comunidades</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
</head>

<body>
    <div class="sidebar">

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

    <!-- Chat -->
    <section class="home-section">
       <!-- testes -->
    </section>
</body>

</html>