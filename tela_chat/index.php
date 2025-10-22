<?php
session_start();
require_once '../config/conexao.php';

if(!isset($_SESSION['id'])){
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
if($resUser && mysqli_num_rows($resUser) > 0){
    $userData = mysqli_fetch_assoc($resUser);
    if(!empty($userData['foto_perfil']) && file_exists('../uploads/'.$userData['foto_perfil'])){
        $foto_perfil_logado = '../uploads/'.$userData['foto_perfil'];
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"/>
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
<section class="chat">
    <!-- Lista de comunidades -->
    <div class="chats">
        <div class="header">
            <div class="logo-details">
                <img src="<?= htmlspecialchars($foto_perfil_logado) ?>" alt="">
            </div>
        </div>

        <div class="search-chat">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Buscar comunidade...">
        </div>

        <div class="chat-menssage">
            <?php if($result && mysqli_num_rows($result) > 0):
                while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card" data-comunidade="<?= $row['id'] ?>">
                        <img src="../uploads/<?= $row['foto_comunidade'] ?>" alt="">
                        <div class="info">
                            <h3 class="nameChat"><?= htmlspecialchars($row['nome']) ?></h3>
                            <p class="timeChat"><?= $row['ultima_mensagem'] ?? '' ?></p>
                        </div>
                    </div>
            <?php endwhile; else: ?>
                <p>Você não participa de nenhuma comunidade.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Área de mensagens -->
    <section class="areaMenssage">
        <div class="headerMenssage">
            <div class="logo">
                <img src="../uploads/profile.png" alt="">
                <h3 id="chat-title">Selecione uma comunidade</h3>
            </div>
        </div>

        <div class="menssage" id="chat-messages">
            <p>Mensagens aparecerão aqui...</p>
        </div>

        <div class="menssageInput">
            <input type="text" id="messageInput" placeholder="Escreva sua mensagem...">
            <i class='bx bx-send' id="sendBtn"></i>
        </div>
    </section>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const communityContainer = document.querySelector('.chat-menssage');
    const chatTitle = document.getElementById('chat-title');
    const chatMessages = document.getElementById('chat-messages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    let selectedCommunityId = null;

    function loadMessages(communityId){
        fetch(`load_messages.php?community=${communityId}`)
            .then(res => res.text())
            .then(html => {
                chatMessages.innerHTML = html;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    communityContainer.addEventListener('click', e => {
        const card = e.target.closest('.card');
        if(!card) return;

        communityContainer.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        selectedCommunityId = card.getAttribute('data-comunidade');
        chatTitle.innerText = card.querySelector('.nameChat').innerText;
        loadMessages(selectedCommunityId);
    });

    sendBtn.addEventListener('click', () => {
        if(!selectedCommunityId) return alert("Selecione uma comunidade primeiro!");
        const message = messageInput.value.trim();
        if(message === '') return;

        fetch('send_message.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `communityId=${selectedCommunityId}&message=${encodeURIComponent(message)}`
        })
        .then(res => res.text())
        .then(res => {
            if(res === 'ok'){
                const div = document.createElement('div');
                div.classList.add('message','sent');
                div.innerHTML = `<div class="bubble-content"><p>${message}</p><span class="time">${new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</span></div>`;
                chatMessages.appendChild(div);
                messageInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                alert(res);
            }
        });
    });
});
</script>
</body>
</html>
