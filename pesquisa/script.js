        let currentStep = 0; // O passo atual do formulário (começa em 0)
        const formSteps = document.getElementsByClassName("form-step");
        const prevBtn = document.querySelector(".btn-prev");
        const nextBtn = document.querySelector(".btn-next");
        const submitBtn = document.getElementById("submitBtn");

        // Função para exibir o passo atual
        function showStep(n) {
            // Oculta todos os passos
            for (let i = 0; i < formSteps.length; i++) {
                formSteps[i].style.display = "none";
            }
            // Mostra o passo atual
            formSteps[n].style.display = "block";
            
            // Atualiza a navegação
            updateNav(n);
            
            // Atualiza o indicador de progresso
            updateProgressBar(n);
        }

        // Função para avançar ou retroceder
        function nextPrev(n) {
            // Validação
            if (n === 1 && !validateForm()) {
                return false;
            }

            // Esconde o passo atual
            formSteps[currentStep].style.display = "none";
            
            // Incrementa ou decrementa o passo
            currentStep = currentStep + n;

            // Se chegou ao fim do formulário (todos os passos preenchidos)
            if (currentStep >= formSteps.length) {
                document.getElementById("perfilForm").submit();
                return false;
            }

            // Caso contrário, mostra o novo passo
            showStep(currentStep);
        }
        
        // Função para atualizar botões de Voltar/Próximo/Concluir
        function updateNav(n) {
            // Mostra o botão Voltar a partir do passo 2
            prevBtn.style.visibility = (n === 0) ? "hidden" : "visible";
            
            // Se for o último passo, mostra o botão Concluir e oculta o Próximo
            if (n === formSteps.length - 1) {
                nextBtn.style.display = "none";
                submitBtn.style.display = "block";
            } else {
                nextBtn.style.display = "block";
                submitBtn.style.display = "none";
            }
        }

        // Função para validar o passo atual
        function validateForm() {
            let valid = true;
            const currentStepElement = formSteps[currentStep];
            
            // Validação para o Passo 2: Foco (garantir que um rádio button foi selecionado)
            if (currentStep === 1) {
                const radioButtons = currentStepElement.querySelectorAll('input[name="area_foco"]');
                let radioChecked = false;
                for(let i = 0; i < radioButtons.length; i++) {
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
                    // Adicione uma classe de erro visual se necessário
                    requiredInputs[i].style.borderColor = 'red';
                    valid = false;
                } else {
                    requiredInputs[i].style.borderColor = ''; // Reseta a cor
                }
            }

            if (valid) {
                // Marca o indicador atual como completo
                document.getElementById(`step${currentStep + 1}-indicator`).classList.add("completed");
            }
            
            return valid;
        }

        // Função para atualizar o indicador de progresso
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