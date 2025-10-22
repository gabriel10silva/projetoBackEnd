<?php 

session_start();

require_once '../config/conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome_usuario, senha FROM usuarios WHERE email_usuario = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);

        if(password_verify($senha, $usuario['senha'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome_usuario'] = $usuario['nome_usuario'];

            header('Location: ../tela_home/index.php');
    }else {
        header('Location: index.php?erro=senha');
        exit();
    }
}else {
    header('Location: index.php?erro=usuario');
    exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}

?>