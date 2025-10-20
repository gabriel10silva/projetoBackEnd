<?php
session_start();
require_once '../config/conexao.php'; // Adicione a conexão aqui!

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header('Location: ../login/index.php'); 
    exit;
}

$usuario_id_logado = $_SESSION['id_usuario'];

// NOVO: Buscar os dados atuais do usuário, incluindo nome e bio (se já preencheu)
$sql_busca = "SELECT nome_usuario, bio, data_nascimento, area_foco 
              FROM usuarios 
              WHERE id = ?";

$stmt_busca = mysqli_prepare($conexao, $sql_busca);
mysqli_stmt_bind_param($stmt_busca, "i", $usuario_id_logado);
mysqli_stmt_execute($stmt_busca);
$resultado = mysqli_stmt_get_result($stmt_busca);
$dados_atuais = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt_busca);

// Se os dados não existirem, algo deu errado (mas o ID da sessão existe)
if (!$dados_atuais) {
    header('Location: ../tela_erro/erro_perfil.php'); // Redireciona para erro
    exit;
}

// Fechamos a conexão aqui ou deixamos para o final da página se precisar de mais consultas
mysqli_close($conexao); 
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Seu Perfil (Passo a Passo)</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="card-container">
        <h1>Olá <?= $dados_atuais['nome_usuario'] ?></h1>
        <p>Preencha as seções abaixo para começar a interagir na comunidade com recomendações personalizadas!
        </p>
        
        <div class="progress-bar-container" style="max-width: 50%; margin: 0 auto 30px auto;">
            <div id="step1-indicator" class="progress-step active">1</div>
            <div id="step2-indicator" class="progress-step">2</div>
            </div>

        <form id="perfilForm" action="processar_perfil_completo.php" method="POST">
            
            <input type="hidden" name="usuario_id"
                value="<?php echo htmlspecialchars($usuario_id_logado); ?>">

            <fieldset class="form-step active" id="step1">
                <div class="secao-perfil">
                    <legend>1. Sua Apresentação</legend>
                    
                    <div class="campo-input">
                        <label for="data_nascimento">Data de Nascimento:</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" required>
                        </div>

                    <div class="campo-input">
                        <label for="bio">Fale um pouco sobre você (Bio):</label>
                        <textarea id="bio" name="bio"
                            placeholder="Ex: Sou entusiasta de tecnologia e adoro discutir projetos de código aberto."></textarea>
                        </div>
                    </div>
                </fieldset>

            <fieldset class="form-step" id="step2">
                <div class="secao-perfil">
                    <legend>2. Foco de Atuação no Fórum</legend>
                    
                    <p
                        style="text-align: center; color: var(--text-light); font-size: 0.9em; margin-bottom: 20px;">
                        Escolha a área principal que você deseja explorar ou focar na
                        comunidade:
                        </p>

                    <div class="radio-group-foco">
                        <div class="radio-item">
                            <input type="radio" id="foco_tecnologia" name="area_foco"
                                value="Tecnologia" required>
                            <label for="foco_tecnologia">💡
                                Tecnologia/Desenvolvimento</label>
                            </div>

                        <div class="radio-item">
                            <input type="radio" id="foco_exatas" name="area_foco"
                                value="Exatas">
                            <label for="foco_exatas">📐 Exatas/Engenharia</label>
                            </div>
                        
                        <div class="radio-item">
                            <input type="radio" id="foco_humanas" name="area_foco"
                                value="Humanas">
                            <label for="foco_humanas">🗣️ Humanas/Comunicação</label>
                            </div>
                        
                        <div class="radio-item">
                            <input type="radio" id="foco_outros" name="area_foco"
                                value="Outros">
                            <label for="foco_outros">🌐 Outros Tópicos</label>
                            </div>
                        </div>
                    </div>
                </fieldset>

            <div class="botoes-navegacao">
                <button type="button" class="btn-nav btn-prev" onclick="nextPrev(-1)"
                    style="visibility: hidden;">Voltar</button>
                <button type="button" class="btn-nav btn-next" onclick="nextPrev(1)">Próximo</button>
                <button type="submit" class="btn-nav botao-submit" id="submitBtn"
                    style="display: none;">Concluir</button>
                </div>
            </form>
        </div>
    
    
    <script src="script.js"></script>

    <script>
        // ESTE É O JAVASCRIPT CORRIGIDO PARA APENAS 2 PASSOS
        let currentStep = 0; // O passo atual do formulário (começa em 0)
        const formSteps = document.getElementsByClassName("form-step");
        const prevBtn = document.querySelector(".btn-prev");
        const nextBtn = document.querySelector(".btn-next");
        const submitBtn = document.getElementById("submitBtn"); // Mantido, mas oculto

        // Total de passos é 2
        const totalSteps = formSteps.length;

        // Função para exibir o passo atual
        function showStep(n) {
            for (let i = 0; i < totalSteps; i++) {
                formSteps[i].style.display = "none";
            }
            formSteps[n].style.display = "block";

            updateNav(n);
            updateProgressBar(n);
        }

        // Função para avançar ou retroceder
        function nextPrev(n) {
            if (n === 1 && !validateForm()) {
                return false;
            }

            // Se estiver no Passo 1 (índice 0) e avançar (n=1)
            if (currentStep === 0 && n === 1) {
                formSteps[currentStep].style.display = "none";
                currentStep++; // Vai para o Passo 2 (índice 1)
                showStep(currentStep);

                // Se estiver no Passo 2 (índice 1) e avançar (n=1), SUBMETE
            } else if (currentStep === 1 && n === 1) {
                document.getElementById("perfilForm").submit();
                return false; // Previne qualquer outra ação

                // Se retroceder (n=-1)
            } else if (n === -1) {
                formSteps[currentStep].style.display = "none";
                currentStep--; // Volta para o Passo 1 (índice 0)
                showStep(currentStep);
            }
        }

        // Função para atualizar botões de Voltar/Próximo (Agora Próximo vira Concluir no Passo 2)
        function updateNav(n) {
            prevBtn.style.visibility = (n === 0) ? "hidden" : "visible";

            if (n === totalSteps - 1) { // Se for o último passo (Passo 2, índice 1)
                nextBtn.textContent = "Concluir"; // Muda o texto
                nextBtn.classList.remove("btn-next");
                nextBtn.classList.add("botao-submit");
            } else {
                nextBtn.textContent = "Próximo";
                nextBtn.classList.remove("botao-submit");
                nextBtn.classList.add("btn-next");
            }
        }

        // Função de validação (mantida a mesma, focada nos requireds)
        function validateForm() {
            let valid = true;
            const currentStepElement = formSteps[currentStep];

            // Validação para o Passo 2: Foco (só se estiver no Passo 2)
            if (currentStep === 1) {
                const radioButtons = currentStepElement.querySelectorAll('input[name="area_foco"]');
                let radioChecked = false;
                for (let i = 0; i < radioButtons.length; i++) {
                    if (radioButtons[i].checked) {
                        radioChecked = true;
                        break;
                    }
                }
                if (!radioChecked) {
                    alert("Por favor, selecione sua Área de Foco.");
                    valid = false;
                }
            }

            // Validação básica para inputs obrigatórios (HTML required)
            const requiredInputs = currentStepElement.querySelectorAll('[required]');
            for (let i = 0; i < requiredInputs.length; i++) {
                if (!requiredInputs[i].value) {
                    requiredInputs[i].style.borderColor = 'red';
                    valid = false;
                } else {
                    requiredInputs[i].style.borderColor = '';
                }
            }

            if (valid) {
                // Marca o indicador atual como completo
                document.getElementById(`step${currentStep + 1}-indicator`).classList.add("completed");
            }

            return valid;
        }

        // Função para atualizar o indicador de progresso (agora para 2 passos)
        function updateProgressBar(n) {
            const indicators = document.querySelectorAll('.progress-step');
            indicators.forEach((indicator, index) => {
                indicator.classList.remove('active');
                if (index === n) {
                    indicator.classList.add('active');
                }
            });
        }

        // Inicia o formulário no primeiro passo
        showStep(currentStep);
    </script>
</body>

</html>