<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updates = [];

    // nome
    if(!empty($_POST['nome'])) {
        $name = mysqli_real_escape_string($conexao, $_POST['nome']);
        $updates[] = "nome_usuario = '$name'";
    }

    // senha
    if(!empty($_POST['senha'])) {
        $password_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $updates[] = "senha = '$password_hash'";
    }

    // bio
    if(!empty($_POST['bio'])) {
        $bio = mysqli_real_escape_string($conexao, $_POST['bio']);
        $updates[] = "bio = '$bio'";
    }

    if(isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['foto_perfil']['nome_usuario'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'png', 'jpeg', 'gif'];

        if (in_array($ext, $permitidos)) {
            // Cria nome único para a imagem
            $novoNome = 'perfil_' . $id . '_' . uniqid() . '.' . $ext;
            $caminho = '../uploads/' . $novoNome;

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho)) {
                $updates[] = "foto_perfil = '$caminho'";
            } else {
                header("Location: index.php?Erro ao salvar a imagem.");
            }
        } else {
            header("Location: index.php?Tipo de arquivo não permitido. Use JPG, PNG ou GIF.");
        }
    }

     // Atualiza o banco apenas se houver algo preenchido
     if (!empty($updates)) {
        $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = $id";
        if (mysqli_query($conexao, $sql)) {
            header("Location: index.php?Alterações Salvas Com Sucesso");
            // Atualiza os dados exibidos na página
            $sql = "SELECT nome_usuario, bio, foto_perfil FROM usuarios WHERE id = $id";
            $user = mysqli_fetch_assoc(mysqli_query($conexao, $sql));
        } else {
            header("Location: index.php?Erro ao atualizar os dados.");
        }
    } else {
        header("Location: index.php?Nenhum campo preenchido para atualizar.");
        }
}

?>