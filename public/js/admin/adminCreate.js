document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('admin-create-form');
    const submitButton = document.getElementById('submit-admin');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        form.roleId.value = 1; // Establecer el rol de admin
        form.statusId.value = 4; // Establecer el estado de activo

        const url = "auth/register";
        const formData = new FormData(form);

        try {
            submitButton.disabled = true;
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (!result.success) {
                mostrarMessage('error', result.error);
                return;
            }

            mostrarMessage('success', result.success);
            setTimeout(() => {
                window.location.href = "dashboard";
            }, 1200);
        } catch (error) {
            console.error('Error al crear usuario:', error);
            mostrarMessage('fatal', error.message);
        } finally {
            submitButton.disabled = false;
        }
    });
});
