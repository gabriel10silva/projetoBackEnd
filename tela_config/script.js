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

document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.painel-configuracoes__item-menu');
    const sections = document.querySelectorAll('.painel-configuracoes__cartao');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            navLinks.forEach(l => l.classList.remove('ativo'));
            link.classList.add('ativo');

            sections.forEach(s => s.classList.add('oculta'));

            const targetSection = document.querySelector(link.getAttribute('href'));
            if (targetSection) {
                targetSection.classList.remove('oculta');
            }
        });
    });
});
