<?php
session_start();

// O require_once deve vir antes de qualquer uso da variável $conexao
// Este arquivo deve conter a conexão $conexao = mysqli_connect(...)
require_once '../config/conexao.php'; 

// Verifica se a requisição é do tipo POST e se os dados cruciais existem
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['usuario_id'], $_POST['area_foco'], $_POST['data_nascimento'])) {
    // Redireciona em caso de acesso inválido
    header('Location: completar_perfil.php?erro=acesso_invalido');
    exit;
}

// ------------------------------------------------------------------------------
// 1. Recebimento e Higienização dos Dados
// ------------------------------------------------------------------------------

// ID do Usuário (passado pelo campo hidden)
$usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

// Dados Simples
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bio             = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$area_foco       = filter_input(INPUT_POST, 'area_foco', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

// Dados Múltiplos (Array de Checkboxes)
$interesses = isset($_POST['interesses']) && is_array($_POST['interesses']) ? $_POST['interesses'] : [];
// Filtra apenas valores que parecem ser inteiros (IDs dos grupos)
$interesses_limpos = array_filter($interesses, 'is_numeric');

// Validação Crucial
if (!$usuario_id) {
    error_log("Tentativa de atualização de perfil com ID inválido. Usuário não autenticado.");
    header('Location: ../login/index.php'); // Redireciona para o login
    exit;
}

// ------------------------------------------------------------------------------
// 2. EXECUÇÃO DA TRANSAÇÃO (UPDATE e INSERT)
// ------------------------------------------------------------------------------

// Desativa o autocommit para iniciar a transação (Atomicidade)
mysqli_autocommit($conexao, FALSE); 
$transacao_ok = TRUE;

// =======================================================
// PARTE A: UPDATE na tabela 'usuarios'
// Colunas: data_nascimento (DATE), bio (TEXT), area_foco (ENUM)
// =======================================================
$sql_perfil = "UPDATE usuarios 
               SET data_nascimento = ?, 
                   bio = ?, 
                   area_foco = ?
               WHERE id = ?";
               
$stmt_perfil = mysqli_prepare($conexao, $sql_perfil);

if ($stmt_perfil) {
    // Tipos: 's' (data), 's' (bio), 's' (foco), 'i' (id)
    mysqli_stmt_bind_param($stmt_perfil, "sssi", $data_nascimento, $bio, $area_foco, $usuario_id);
    if (!mysqli_stmt_execute($stmt_perfil)) {
        $transacao_ok = FALSE;
    }
    mysqli_stmt_close($stmt_perfil);
} else {
    $transacao_ok = FALSE;
    error_log("Erro na preparação do UPDATE de perfil: " . mysqli_error($conexao));
}

// =======================================================
// PARTE B: INSERT na tabela de relacionamento (INTERESSES)
// Esta parte será finalizada quando você enviar a estrutura das tabelas de interesses.
// POR ENQUANTO, DEIXAMOS SEM A PARTE B. SE VOCÊ NÃO TEM ESSAS TABELAS, REMOVA O CÓDIGO ABAIXO.
// =======================================================

/*
if ($transacao_ok && !empty($interesses_limpos)) {
    
    // 1. Limpa interesses antigos: DELETE FROM interesses_usuario WHERE usuario_id = ?
    // ... CÓDIGO DE DELETE AQUI ...

    // 2. Monta e Insere novos interesses: INSERT INTO interesses_usuario (usuario_id, interesse_id) VALUES (?, ?), (?, ?)...
    // ... CÓDIGO DE INSERT AQUI ...

    // Se algo falhar na Parte B, defina $transacao_ok = FALSE
}
*/
// ------------------------------------------------------------------------------
// 3. Finaliza a Transação
// ------------------------------------------------------------------------------

if ($transacao_ok) {
    mysqli_commit($conexao); // Confirma as mudanças
    mysqli_close($conexao);
    
    // Redirecionamento de Sucesso para a home do usuário
    header("Location: ../tela_home/index.php?status=perfil_concluido");
    exit();
} else {
    // Em caso de falha em qualquer parte (A ou B), desfaz tudo
    mysqli_rollback($conexao); 
    mysqli_close($conexao);
    
    // Log para debug
    error_log("Falha na transação de perfil (UPDATE ou INSERT de interesses) para o usuário ID: " . $usuario_id . ". Erro: " . mysqli_error($conexao));
    
    // Redirecionamento de Erro para o próprio formulário
    header('Location: index.php?erro=falha_ao_salvar');
    exit;
}

?>