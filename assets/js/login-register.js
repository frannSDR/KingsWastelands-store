//! --------- login/register --------- //

const container = document.querySelector('.container-l');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const loginIcon = document.querySelector('.login_icon'); 
const loginContainer = document.querySelector('.login-container');

// logica para alternar a la seccion de registro
registerBtn.addEventListener('click', () => {
  container.classList.add('active');
});

// logica para alternar a la seccion de login
loginBtn.addEventListener('click', () => {
  container.classList.remove('active');
});

//** logica para alternar a la seccion de login desde el icono

// ocultamos el contenedor de login
loginContainer.style.opacity = '0';
// completamente transparente
loginContainer.style.display = 'none';

// click en el icono de usuario para mostrar el login
loginIcon.addEventListener('click', function(e) {
  e.preventDefault();
  
  // opacidad en 0, completamente transparente
  loginContainer.style.opacity = '0';
  // cambiamos display a flex
  loginContainer.style.display = 'flex';

  // forzamos un reflow para que el navegador procese los cambios antes de la animacion
  void loginContainer.offsetWidth;

  // ahora añadimos la clase para la animación
  loginContainer.classList.add('visible');
});

// al hacer click fuera del formulario se cierra
loginContainer.addEventListener('click', function(e) {
  // si el click fue en el contenedor pero no en el formulario
  if (e.target === loginContainer) {
    // primero agregamos la clase para la animacion de salida
    loginContainer.classList.remove('visible');
    loginContainer.classList.add('hiding');


    // esperamos a que termine la animacion antes de ocultar completamente
    setTimeout(() => {
      loginContainer.style.display = 'none';
      loginContainer.classList.remove('hiding');
    }, 300); // este tiempo coincide con la duracion de la animacion
  }
});