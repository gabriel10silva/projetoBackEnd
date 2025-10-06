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



function showEdit() {
  document.getElementById('edit-section').classList.remove('hidden');
}

function cancelEdit() {
  document.getElementById('edit-section').classList.add('hidden');
}

function saveProfile() {
  const newName = document.getElementById('editName').value;
  const newBio = document.getElementById('editBio').value;

  if (newName !== "") {
    document.getElementById('displayName').innerText = newName;
  }
  if (newBio !== "") {
    document.getElementById('displayBio').innerText = newBio;
  }

  cancelEdit();
}


// Elementos do formulário e popups edição
const form = document.getElementById('editForm');
const confirm1 = document.getElementById('confirm1');
const confirm2 = document.getElementById('confirm2');
const confirmFinal = document.getElementById('confirmacao-final');
const btnFecharFinal = document.getElementById('btn-fechar-final');

// Popups botão sair
const btnSair = document.getElementById('btn-sair');
const popupSair = document.getElementById('sair1');
const sairSim = document.getElementById('sair-sim');
const sairNao = document.getElementById('sair-nao');

// Ao tentar enviar o form, cancela e abre o primeiro popup de confirmação
form.addEventListener('submit', function (e) {
  e.preventDefault();
  confirm1.style.display = 'flex'; // flex para centralizar (ajuste no CSS)
});

// Botões do primeiro popup
document.getElementById('confirm1-sim').addEventListener('click', () => {
  confirm1.style.display = 'none';
  confirm2.style.display = 'flex';
});

document.getElementById('confirm1-nao').addEventListener('click', () => {
  confirm1.style.display = 'none';
});

// Botões do segundo popup
document.getElementById('confirm2-sim').addEventListener('click', () => {
  confirm2.style.display = 'none';
  confirmFinal.style.display = 'flex';
});

document.getElementById('confirm2-nao').addEventListener('click', () => {
  confirm2.style.display = 'none';
});

// Fechar popup final e enviar o formulário
btnFecharFinal.addEventListener('click', () => {
  confirmFinal.style.display = 'none';
  form.submit(); // Agora sim envia o formulário
});

// Abrir popup sair
btnSair.addEventListener('click', () => {
  popupSair.style.display = 'flex';
});

// Botão cancelar sair
sairNao.addEventListener('click', () => {
  popupSair.style.display = 'none';
});

// Botão confirmar sair (redireciona para logout)
sairSim.addEventListener('click', () => {
  window.location.href = '../config/logout.php';
});





