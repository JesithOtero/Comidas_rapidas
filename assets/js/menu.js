document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav ul');
  
    menuToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');  
    });

    const links = document.querySelectorAll('.nav a');
    links.forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('active');  // Esto cierra el menú al hacer clic en un enlace
      });
    });
  });
  