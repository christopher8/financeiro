// Seleciona o botão de alternância e o menu
const menuToggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');



// Adiciona o evento de clique para alternar o menu
menuToggle.addEventListener('click', () => {
  menu.classList.toggle('active');
});
