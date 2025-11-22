function mostrarMessage(estado, message = null) {
    const messageBox = document.getElementById('form-message');

    if (!messageBox) {
        return;
    }

    messageBox.classList.remove('message-error', 'message-success');

    if (estado === 'success') {
        messageBox.textContent = message || 'Solicitud exitosa. Redirigiendo...';
        messageBox.classList.add('message-success');
    } else if (estado === 'error') {
        messageBox.textContent = message || 'Ocurrio un error.';
        messageBox.classList.add('message-error');
    } else if (estado === 'fatal') {
        messageBox.textContent = message || 'Error de conexion con el servidor.';
        messageBox.classList.add('message-error');
    }

    const timeout = estado === 'success' ? 15000 : 6500;
    setTimeout(() => {
        messageBox.textContent = '';
    }, timeout);
}
