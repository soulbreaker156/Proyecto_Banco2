document.addEventListener('DOMContentLoaded', () => {
    const depositForm = document.querySelector('#deposit-form');
    const withdrawForm = document.querySelector('#withdraw-form');

    // Función genérica para manejar envíos de formulario con Fetch
    const handleFormSubmit = async (form, event) => {
        event.preventDefault(); // Prevenir recarga de página

        const formData = new FormData(form);
        const url = form.action;
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const result = await response.json(); // Esperamos una respuesta JSON del servidor

            const notification = document.querySelector('#notification');
            notification.textContent = result.message;
            notification.className = 'notification'; // Limpiar clases previas

            if (result.success) {
                notification.classList.add('is-success');
                // Actualizar el saldo en la página
                const saldoDisplay = document.querySelector('#current-balance');
                if (saldoDisplay) {
                    saldoDisplay.textContent = `$${result.newBalance.toFixed(2)}`;
                }
            } else {
                notification.classList.add('is-danger');
            }

        } catch (error) {
            console.error('Error al enviar el formulario:', error);
            const notification = document.querySelector('#notification');
            notification.textContent = 'Ocurrió un error de red. Inténtelo de nuevo.';
            notification.className = 'notification is-danger';
        }
    };
    
    // Asignar el manejador a los formularios si existen
    if (depositForm) {
        depositForm.addEventListener('submit', (e) => handleFormSubmit(depositForm, e));
    }

    if (withdrawForm) {
        withdrawForm.addEventListener('submit', (e) => handleFormSubmit(withdrawForm, e));
    }
});