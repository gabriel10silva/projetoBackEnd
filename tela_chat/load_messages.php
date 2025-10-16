<?php
session_start();
require_once '../config/conexao.php';
if(!isset($_SESSION['id'])) exit();

$communityId = isset($_GET['community']) ? intval($_GET['community']) : 0;
if($communityId <= 0) exit();

$sql = "SELECT m.*, u.nome_usuario, u.foto_perfil
        FROM mensagens_comunidade m
        JOIN usuarios u ON m.id_usuario = u.id
        WHERE m.id_comunidade = $communityId
        ORDER BY m.data_envio ASC";

$result = mysqli_query($conexao, $sql);
if($result){
    while($msg = mysqli_fetch_assoc($result)){
        $tipo = ($msg['id_usuario'] == $_SESSION['id']) ? 'sent' : 'received';
        $foto = !empty($msg['foto_perfil']) ? '../uploads/'.$msg['foto_perfil'] : '../uploads/profile.png';
        echo '<div class="message '.$tipo.'">';
        if($tipo === 'received') echo '<img src="'.$foto.'" class="message-avatar">';
        echo '<div class="bubble-content">';
        echo '<p>'.htmlspecialchars($msg['mensagem']).'</p>';
        echo '<span class="time">'.date('H:i', strtotime($msg['data_envio'])).'</span>';
        echo '</div></div>';
    }
}
?>
