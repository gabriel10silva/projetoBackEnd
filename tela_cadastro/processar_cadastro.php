<?php
session_start();
require_once '../config/conexao.php';


// verfica se o form foi enviado pelo método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recebe dados do form
    $nome_usuario = $_POST['nome_usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

// linha de código para proteção

// proteção de injeção de SQL
$nome_usuario = mysqli_real_escape_string($conexao, $nome_usuario);
$email = mysqli_real_escape_string($conexao, $email);

// criptografia da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere os dados no banco e dados
$sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha) VALUES (?, ?, ?)";

// prepara uma consulta SQL
$stmt = mysqli_prepare($conexao, $sql);

// liga (ou vincula) as variáveis do PHP aos marcadores de interrogação 
mysqli_stmt_bind_param($stmt, "sss", $nome_usuario, $email, $senha_hash);


// verfica a execução
if (mysqli_stmt_execute($stmt)) {
    // obter o id do usuário inserido
    $ultimo_id = mysqli_insert_id($conexao);

    // define as variaveis para a sessão
    $_SESSION['id'] = $ultimo_id;
    $_SESSION['nome_usuario'] = $nome_usuario;

    // redireciona a pagina
    header('Location: index.php');
    exit;
}else {
    echo '<script>
    alert("Erro");
</script>';

}

// liberar recursos do servidor após a conclusão das operações com o banco de dados
mysqli_stmt_close($stmt);
mysqli_close($conexao);

}else {
    header('Location: cadastro.php');
}


?>