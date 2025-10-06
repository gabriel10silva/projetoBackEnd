<?php
session_start();

// Destrói todas as variáveis da sessão
$_SESSION = array();

// Se for preciso destruir a sessão completamente,
// apaga também o cookie de sessão.
// Nota: Isso irá destruir a sessão, e não apenas os dados da sessão!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy();

// Redireciona para a página de login
header("Location: ../tela_login/index.php");
exit();
?>
