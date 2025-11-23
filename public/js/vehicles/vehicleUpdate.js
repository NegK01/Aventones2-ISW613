document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('vehicle-form');
    const submitBtn = document.getElementById('submit-form-btn');

    const url = 'vehicle/getById';
    const formData = new FormData(form);

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (!result.success) {
            mostrarMessage('error', result.error);
            return;
        }

        const vehicle = result.vehicle;

        // Rellenar el formulario con los datos del vehiculo
        form.vehicleBrand.value = vehicle.marca || '';
        form.vehicleModel.value = vehicle.modelo || '';
        form.vehicleYear.value = vehicle.anio || '';
        form.vehicleColor.value = vehicle.color || '';
        form.vehiclePlate.value = vehicle.placa || '';
        form.vehicleSeats.value = vehicle.asientos || '';
        form.vehicleStatus.value = vehicle.id_estado || 4;
        // Mostrar la foto del vehiculo si existe
        mostrarFotoVehiculo(true, vehicle.fotografia || '');

    } catch (error) {
        mostrarMessage('fatal', error.message);
    }

    submitBtn.addEventListener('click', async (event) => {
        event.preventDefault();

        const url = 'vehicle/update';
        const formData = new FormData(form);

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
                window.location.href = 'vehicles';
            }, 1200);
        } catch (error) {
            console.error('No se pudo editar el vehiculo: ', error);
            mostrarMessage('fatal', error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });
});