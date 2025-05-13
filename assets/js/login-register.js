// Efecto de partículas
function createParticles() {
    const section = document.querySelector('.auth-section');
    const particleCount = window.innerWidth < 768 ? 20 : 50;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Tamaño aleatorio entre 2px y 6px
        const size = Math.random() * 4 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        // Posición aleatoria
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        
        // Opacidad aleatoria
        particle.style.opacity = Math.random() * 0.5 + 0.1;
        
        // Animación flotante
        const duration = Math.random() * 20 + 10;
        const delay = Math.random() * -20;
        particle.style.animation = `float ${duration}s ease-in-out ${delay}s infinite`;
        
        section.appendChild(particle);
    }
}

// Validación de formularios
function setupFormValidation() {
    const forms = document.querySelectorAll('.auth-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            
            // Simular carga (en un caso real sería una petición AJAX)
            submitBtn.classList.add('loading');
            
            // Validación adicional para registro
            if (form.closest('.register-page')) {
                const password = this.querySelector('input[name="contraseña"]');
                const confirmPassword = this.querySelector('input[name="confirmar_contraseña"]');
                
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    submitBtn.classList.remove('loading');
                    showMessage('Las contraseñas no coinciden', 'error');
                    return;
                }
                
                if (password.value.length < 6) {
                    e.preventDefault();
                    submitBtn.classList.remove('loading');
                    showMessage('La contraseña debe tener al menos 6 caracteres', 'error');
                    return;
                }
            }
            
            // Aquí iría la lógica real de envío del formulario
            // setTimeout solo para simulación
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                // showMessage('Operación exitosa', 'success');
            }, 2000);
        });
    });
}

// Mostrar mensajes de error/éxito
function showMessage(text, type) {
    // Eliminar mensajes existentes
    const existingMessages = document.querySelectorAll('.auth-message');
    existingMessages.forEach(msg => msg.remove());
    
    const form = document.querySelector('.auth-form');
    const message = document.createElement('div');
    message.className = `auth-message ${type}`;
    message.textContent = text;
    
    form.insertBefore(message, form.firstChild);
}

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    createParticles();
    setupFormValidation();
    
    // Efecto de enfoque en los inputs
    const inputs = document.querySelectorAll('.input-box input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('i').style.color = 'var(--hover-color)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.querySelector('i').style.color = 'var(--color-principal)';
        });
    });
});