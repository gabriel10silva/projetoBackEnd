let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  menuBtnChange();
});

searchBtn.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  menuBtnChange();
});

function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
  } else {
    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.tab-button');
  const contentSections = document.querySelectorAll('.content-section');
  const avatarWrapper = document.getElementById('profile-avatar').closest('.avatar-wrapper');
  const avatarPrompt = document.querySelector('.avatar-prompt');
  const userDetailsStatic = document.querySelector('.user-details-static');

  // Função para alternar a aba
  function switchTab(targetTab) {
      // 1. Alterna a classe 'active' nos botões da aba
      tabButtons.forEach(button => {
          button.classList.remove('active');
          if (button.dataset.tab === targetTab) {
              button.classList.add('active');
          }
      });

      // 2. Alterna a visibilidade das seções de conteúdo
      contentSections.forEach(section => {
          section.classList.remove('active');
          if (section.id === targetTab + '-mode') {
              section.classList.add('active');
          }
      });

      // 3. Gerencia o estado visual do avatar
      if (targetTab === 'edit') {
          avatarWrapper.classList.add('edit-mode');
          avatarPrompt.style.display = 'block';
          userDetailsStatic.style.display = 'none';
      } else { // targetTab === 'view'
          avatarWrapper.classList.remove('edit-mode');
          avatarPrompt.style.display = 'none';
          userDetailsStatic.style.display = 'block';
      }
  }

  // Adiciona listeners aos botões
  tabButtons.forEach(button => {
      button.addEventListener('click', function() {
          const targetTab = this.dataset.tab;
          switchTab(targetTab);
      });
  });

  // --- Funcionalidade extra: Alternar visibilidade da senha no modo Editar ---
  const passwordInput = document.getElementById('nova-senha');
  const visibilityIcon = document.querySelector('.visibility-icon');

  if (visibilityIcon && passwordInput) {
      visibilityIcon.addEventListener('click', function() {
          if (passwordInput.type === 'password') {
              passwordInput.type = 'text';
              visibilityIcon.textContent = 'visibility'; // Muda o ícone para olho aberto
          } else {
              passwordInput.type = 'password';
              visibilityIcon.textContent = 'visibility_off'; // Muda o ícone para olho fechado
          }
      });
  }

  // --- Funcionalidade extra: Contador de caracteres da Biografia ---
  const bioInput = document.getElementById('biografia');
  const charCountElement = document.querySelector('.char-count');
  const MAX_CHARS = 150; // Definindo um limite máximo

  if (bioInput && charCountElement) {
      // Inicializa o contador
      updateCharCount();
      
      bioInput.addEventListener('input', updateCharCount);
      
      function updateCharCount() {
          const currentLength = bioInput.value.length;
          
          // Simular o limite de 95 caracteres visto na imagem
          charCountElement.textContent = `${currentLength} caracteres`;
          
          // Exemplo de como aplicar limite, embora na imagem não pareça ter um limite visual
          /*
          charCountElement.textContent = `${currentLength}/${MAX_CHARS} caracteres`;
          if (currentLength > MAX_CHARS) {
              charCountElement.style.color = 'red';
          } else {
              charCountElement.style.color = 'var(--text-color-light)';
          }
          */
      }
  }

  // Garante que o modo de visualização esteja ativo ao carregar
  switchTab('view'); 
});




