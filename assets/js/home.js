//! ----------- logica del slider ----------- //
const slides = document.querySelectorAll('.slide');
let currentIndex = 0;
let slideInterval = setInterval(nextSlide, 10000);

function showSlide(index) {
  slides.forEach(slide => slide.classList.remove('active'));
  slides[index].classList.add('active');
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % slides.length;
  showSlide(currentIndex);
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  showSlide(currentIndex);
  resetInterval();
}

function resetInterval() {
  clearInterval(slideInterval);
  slideInterval = setInterval(nextSlide, 10000);
}

// Inicializar el slider
document.addEventListener('DOMContentLoaded', function() {
  showSlide(currentIndex);
  
  document.querySelector('.nav-left').addEventListener('click', prevSlide);
  document.querySelector('.nav-right').addEventListener('click', function() {
    nextSlide();
    resetInterval();
  });
});

//! -------------- reproduccion de videos en las tarjetas -------------- //

document.addEventListener('DOMContentLoaded', function() {
  const gameCards = document.querySelectorAll('.game-card');
  
  // cargamos la API de youTube
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  
  // controlamos que la api haya cargado correctamente
  window.onYouTubeIframeAPIReady = function() {
    gameCards.forEach(card => {
      const iframe = card.querySelector('iframe');
      if (iframe) {
        const player = new YT.Player(iframe, {
          events: {
            'onReady': onPlayerReady
          }
        });
        
        card.addEventListener('mouseenter', () => {
          player.playVideo();
        });
        
        card.addEventListener('mouseleave', () => {
          player.pauseVideo();
        });
      }
    });
  }
  
  function onPlayerReady(event) {
    event.target.mute(); // nos aseguramos de que el video este muteado
  }
});

//! -------------- logica del menu hamburguesa -------------- //

document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('nav');
  const navOverlay = document.querySelector('.nav-overlay');
  const dropdowns = document.querySelectorAll('.dropdown1');
  
  // Toggle menu function to reduce code duplication
  function toggleMenu(isOpen) {
    nav.classList.toggle('active', isOpen);
    navOverlay.classList.toggle('active', isOpen);
    
    const icon = menuToggle.querySelector('i');
    if (isOpen) {
      icon.classList.remove('bi-list');
      icon.classList.add('bi-x-lg');
      document.body.style.overflow = 'hidden';
    } else {
      icon.classList.remove('bi-x-lg');
      icon.classList.add('bi-list');
      document.body.style.overflow = '';
      
      // reseteamos el dropdown cuando cerramos el menu hamburguesa
      dropdowns.forEach(dropdown => {
        const dropdownIcon = dropdown.querySelector('a i');
        dropdown.classList.remove('active');
        if (dropdownIcon) {
          dropdownIcon.classList.remove('bi-chevron-up');
          dropdownIcon.classList.add('bi-chevron-down');
        }
      });
    }
  }
  
  menuToggle.addEventListener('click', function() {
    toggleMenu(!nav.classList.contains('active'));
  });
  
  navOverlay.addEventListener('click', function() {
    toggleMenu(false);
  });
  
  dropdowns.forEach(dropdown => {
    const link = dropdown.querySelector('a');
    
    link.addEventListener('click', function(e) {
      if (window.innerWidth <= 992) {
        e.preventDefault();
        
        dropdowns.forEach(otherDropdown => {
          if (otherDropdown !== dropdown && otherDropdown.classList.contains('active')) {
            otherDropdown.classList.remove('active');
            const otherIcon = otherDropdown.querySelector('a i');
            if (otherIcon) {
              otherIcon.classList.remove('bi-chevron-up');
              otherIcon.classList.add('bi-chevron-down');
            }
          }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('active');
        
        const dropdownIcon = this.querySelector('i');
        if (dropdownIcon) {
          if (dropdown.classList.contains('active')) {
            dropdownIcon.classList.remove('bi-chevron-down');
            dropdownIcon.classList.add('bi-chevron-up');
          } else {
            dropdownIcon.classList.remove('bi-chevron-up');
            dropdownIcon.classList.add('bi-chevron-down');
          }
        }
      }
    });
  });

  // Handle mobile cart link click
  const mobileCartLink = document.querySelector('.mobile-cart');
  if (mobileCartLink) {
    mobileCartLink.addEventListener('click', function(e) {
      e.preventDefault();
      toggleMenu(false); // Close mobile menu
      openCart(); // Open cart sidebar
    });
  }

  window.addEventListener('resize', function() {
    if (window.innerWidth > 992 && nav.classList.contains('active')) {
      toggleMenu(false);
    }
  });
  
  // Close menu when clicking regular links
  const mobileLinks = document.querySelectorAll('.nav_links li:not(.dropdown1) a:not(.mobile-cart)');
  mobileLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 992 && nav.classList.contains('active')) {
        toggleMenu(false);
      }
    });
  });
  
  function updateMobileCartCount() {
    const cartCount = document.querySelector('.cart-item-count');
    const mobileCartCount = document.querySelector('.mobile-cart-count');
    
    if (cartCount && mobileCartCount) {
      mobileCartCount.textContent = cartCount.textContent;
      mobileCartCount.style.display = cartCount.textContent > 0 ? 'inline-block' : 'none';
    }
  }
  
  updateMobileCartCount();
  
  const observer = new MutationObserver(function(mutations) {
    updateMobileCartCount();
  });
  
  const cartCount = document.querySelector('.cart-item-count');
  if (cartCount) {
    observer.observe(cartCount, { childList: true, characterData: true, subtree: true, attributes: true });
  }
});

//! -------------- newsletter modal -------------- //

const subscriptionForm = document.getElementById('subscriptionForm');
const modal = document.getElementById('thankYouModal');
const modalButton = document.getElementById('modalButton');

// función para mostrar la ventana modal con una pequeña animacion
function showModal() {
  modal.style.display = 'flex';
  // forzar el reflow para que la animación funcione
  void modal.offsetWidth;
  modal.classList.add('visible');
  
  // deshabilitar el scroll del body cuando el modal está abierto
  document.body.style.overflow = 'hidden';
}

// funcion para cerrar la ventana modal con animacion
function hideModal() {
  modal.classList.remove('visible');
  modal.classList.add('hiding');
  
  setTimeout(() => {
    modal.style.display = 'none';
    modal.classList.remove('hiding');
    // restaurar el scroll del body
    document.body.style.overflow = 'auto';
  }, 300);
}

// evento para enviar el formulario
subscriptionForm.addEventListener('submit', function(event) {
  event.preventDefault();
  const emailInput = this.querySelector('.email-input');
  
  // validacion basica del email
  if (emailInput.value && emailInput.checkValidity()) {
    // mas adelante, aca va a ir la logica para mandar el email
    console.log('Email enviado:', emailInput.value);
    
    // limpiar el campo de email
    emailInput.value = '';
    
    // mostrar el modal de agradecimiento
    showModal();
  } else {
    // mostrar la excepcion en caso de mail invalido
    emailInput.style.border = '2px solid #ff4444';
    setTimeout(() => {
      emailInput.style.border = 'none';
    }, 2000);
  }
});

// evento para cerrar el modal al hacer clic en el boton
modalButton.addEventListener('click', hideModal);

// cerrar el modal al hacer clic fuera del contenido
modal.addEventListener('click', function(event) {
  if (event.target === modal) {
    hideModal();
  }
});