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

function toggleReplyForm(formId) {
  const form = document.getElementById(formId);
  if (form) {
      form.classList.toggle('hidden');
  }
}

function viewReplies(repliesId) {
  const replies = document.getElementById(repliesId);
  if (replies) {
      replies.classList.toggle('hidden');
  }
}

function addDuvida() {
  window.location.href = 'criar_post.php';
}