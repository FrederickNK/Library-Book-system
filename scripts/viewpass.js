window.addEventListener("DOMContentLoaded", () => {


const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#passwd');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-solid fa-eye');
});
});