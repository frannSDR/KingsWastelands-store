// Validación de fortaleza de contraseña
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.querySelector('input[name="nueva_contraseña"]');
    const confirmInput = document.querySelector('input[name="confirmar_contraseña"]');
    const strengthLevel = document.getElementById('strength-level');
    const strengthText = document.getElementById('strength-text');
    const submitBtn = document.getElementById('submit-btn');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            // Actualizar barra de fortaleza
            strengthLevel.style.width = `${strength.percentage}%`;
            strengthLevel.className = 'strength-level ' + strength.class;
            
            // Actualizar texto
            strengthText.textContent = strength.text;
            strengthText.className = 'strength-text ' + strength.class;
            
            // Actualizar requisitos
            updateRequirements(strength.requirements);
            
            // Validar confirmación
            validatePasswordMatch();
        });
        
        confirmInput.addEventListener('input', validatePasswordMatch);
    }
    
    function checkPasswordStrength(password) {
        let score = 0;
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password)
        };
        
        // Puntaje basado en requisitos cumplidos
        score += requirements.length ? 25 : 0;
        score += requirements.uppercase ? 25 : 0;
        score += requirements.number ? 25 : 0;
        score += requirements.special ? 25 : 0;
        
        // Determinar nivel de fortaleza
        if (password.length === 0) {
            return {
                percentage: 0,
                class: '',
                text: '',
                requirements: requirements
            };
        } else if (password.length < 4) {
            return {
                percentage: 20,
                class: 'weak',
                text: 'Muy débil',
                requirements: requirements
            };
        } else if (score < 50) {
            return {
                percentage: 40,
                class: 'weak',
                text: 'Débil',
                requirements: requirements
            };
        } else if (score < 75) {
            return {
                percentage: 65,
                class: 'medium',
                text: 'Moderada',
                requirements: requirements
            };
        } else if (score < 100) {
            return {
                percentage: 85,
                class: 'strong',
                text: 'Fuerte',
                requirements: requirements
            };
        } else {
            return {
                percentage: 100,
                class: 'very-strong',
                text: 'Muy fuerte',
                requirements: requirements
            };
        }
    }
    
    function updateRequirements(requirements) {
        document.getElementById('req-length').style.color = requirements.length ? 'var(--success-color)' : 'var(--error-color)';
        document.getElementById('req-uppercase').style.color = requirements.uppercase ? 'var(--success-color)' : 'var(--error-color)';
        document.getElementById('req-number').style.color = requirements.number ? 'var(--success-color)' : 'var(--error-color)';
        document.getElementById('req-special').style.color = requirements.special ? 'var(--success-color)' : 'var(--error-color)';
    }
    
    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        if (password && confirm) {
            if (password !== confirm) {
                confirmInput.style.borderColor = 'var(--error-color)';
                submitBtn.disabled = true;
            } else {
                confirmInput.style.borderColor = 'var(--success-color)';
                
                // Solo habilitar si la contraseña tiene algo de fuerza
                const strength = checkPasswordStrength(password);
                submitBtn.disabled = strength.percentage < 65;
            }
        } else {
            confirmInput.style.borderColor = '';
            submitBtn.disabled = true;
        }
    }
});