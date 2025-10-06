<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projeto backend</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="register-wrapper">
  <div class="register-left"></div>
  <div class="register-right">
    <h2>Seja Bem-Vindo</h2>
    <form action="processar_cadastro.php" method="POST">
      <input type="text" placeholder="Nome" name="nome_usuario" required>
      <input type="email" placeholder="Email" name="email" required>
      <input type="password" placeholder="Senha" name="senha" required>
      <button class="btn-cadastrar">Cadastrar</button>
    </form>
    <div class="options">
      <a href="#">Termos De Privacidades</a>
      <a href="../tela_login/index.php">Fazer Login</a>
    </div>
  </div>
</div>


    <script src="script.js"></script>
</body>

</html>