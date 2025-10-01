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

const messages = document.getElementById('messages');
const input = document.getElementById('msgInput');
const sendBtn = document.getElementById('sendBtn');
const chatTitle = document.getElementById('chatTitle');

function addMessage(text, me = true) {
  if (!text) return;
  const msg = document.createElement('div');
  msg.className = 'message ' + (me ? 'me' : 'other');
  const bubble = document.createElement('div');
  bubble.className = 'bubble';
  bubble.textContent = text;
  const meta = document.createElement('div');
  meta.className = 'meta-time';
  const now = new Date();
  meta.textContent = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');
  msg.appendChild(bubble);
  msg.appendChild(meta);
  messages.appendChild(msg);
  messages.scrollTop = messages.scrollHeight;
}

sendBtn.addEventListener('click', () => {
  addMessage(input.value, true);
  input.value = '';
});

input.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    e.preventDefault();
    sendBtn.click();
  }
});

function selectGroup(name) {
  chatTitle.textContent = name;
  messages.innerHTML = '';
  addMessage('Bem-vindo ao ' + name + '!', false);
}