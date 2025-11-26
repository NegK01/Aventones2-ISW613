document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('ride-form');
    const submitBtn = document.getElementById('submit-ride');
    const vehicleSelect = document.getElementById('id_vehiculo'); // Elemento select de vehiculos

    // Url para obtener los vehiculos del usuario y cargarlos en el select
    const url = 'vehicle/listForDropdown';

    try {
        const response = await fetch(url);
        const result = await response.json();

        if (!result.success) {
            mostrarMessage('error', result.error);
            return;
        }

        // Poner como primera opcion 'Selecciona un vehiculo', pero esta estara deshabilitada y seleccionada por defecto
        let options = '<option value="0" disabled selected>Selecciona un vehiculo</option>';

        result.vehicles.forEach(vehicle => {
            options += `
                <option value="${vehicle.id_vehiculo}">
                ${vehicle.marca} ${vehicle.modelo} (${vehicle.placa})
                </option>
            `;
        });

        // Insertar todas las opciones en el select de vehiculos
        vehicleSelect.innerHTML = options;

    } catch (error) {
        mostrarMessage('fatal', error.message);
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const url = 'ride/store';

        try {   
            submitBtn.disabled = true;
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
                window.location.href = baseUrl + 'rides';
            }, 1200);
        } catch (error) {
            console.error('No se pudo insertar el ride: ', error);
            mostrarMessage('fatal', error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });
});

