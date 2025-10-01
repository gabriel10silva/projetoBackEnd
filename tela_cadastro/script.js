const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');
togglePassword.addEventListener('click', () => {
  const type = password.type === 'password' ? 'text' : 'password';
  password.type = type;
  togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
});

const toggleConfirm = document.getElementById('toggleConfirmPassword');
const confirmPassword = document.getElementById('confirmPassword');
toggleConfirm.addEventListener('click', () => {
  const type = confirmPassword.type === 'password' ? 'text' : 'password';
  confirmPassword.type = type;
  toggleConfirm.textContent = type === 'password' ? '👁️' : '🙈';
});