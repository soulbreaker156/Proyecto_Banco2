document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required]');

        inputs.forEach(input => {
            if (input.value.trim() === '') {
                isValid = false;
                // Podrías añadir una clase de error al input aquí
                console.error(`El campo ${input.name} es obligatorio.`);
            }
        });

        // Ejemplo de validación de contraseña
        const password = form.querySelector('input[name="password"]');
        if (password && password.value.length < 4) {
            isValid = false;
            alert('La contraseña debe tener al menos 4 caracteres.');
        }

        if (!isValid) {
            event.preventDefault(); // Detiene el envío del formulario si no es válido
            alert('Por favor, complete todos los campos correctamente.');
        }
    });
});