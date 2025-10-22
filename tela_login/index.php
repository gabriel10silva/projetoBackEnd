<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projeto backend</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-wrapper">
  <div class="login-left"></div>
  <div class="login-right">
    <h2>Bem-vindo de volta</h2>
    <form action="processar_login.php" method="post">
      <input type="email" placeholder="Email" name="email" required>
      <input type="password" placeholder="Senha" name="senha" required>
      <button>Entrar</button>
    </form>
    <div class="options">
      <a href="#">Esqueceu a senha?</a>
      <a href="../tela_cadastro/index.php">Criar conta</a>
    </div>
  </div>
</div>


    <script src="script.js"></script>
</body>

</html>