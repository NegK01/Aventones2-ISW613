document.addEventListener('DOMContentLoaded', async () => {
    const form = document.getElementById('ride-form');
    const submitBtn = document.getElementById('submit-ride');
    const vehicleSelect = document.getElementById('id_vehiculo'); // Elemento select de vehiculos

    // Url para obtener todos los datos del ride y rellenar el formulario
    const url = '../actions/handler.php?controller=rides&action=mostrarRide';
    const formData = new FormData(form);

    try {
        // Obtener los datos del ride, tambien nos trae todos los vehiculos del usuario actual para rellenar el select
        const responseRide = await fetch(url, {
            method: 'POST',
            body: formData
        });
        const resultRide = await responseRide.json();

        if (!resultRide.success) {
            mostrarMessage('error', resultRide.error);
            return;
        }

        const ride = resultRide.ride;
        const vehicles = resultRide.vehicles;
        console.log(ride);
        console.log(vehicles);

        // Rellenar el formulario con los datos del ride
        form.rideId.value = ride.id_ride;
        form.id_vehiculo.value = ride.id_vehiculo;
        form.rideName.value = ride.nombre;
        form.origen.value = ride.origen;
        form.destino.value = ride.destino;
        form.fecha_hora.value = ride.fechaHora;
        form.asientos.value = ride.asientos;
        form.costoAsiento.value = ride.costoAsiento;
        form.detalles.value = ride.detalles;

        // Rellenar el select de vehiculos
        vehicles.forEach(vehicle => {
            const option = document.createElement('option');
            option.value = vehicle.id_vehiculo;
            option.textContent = vehicle.marca + ' ' + vehicle.modelo + ' (' + vehicle.anio + ')' + ' - [' + vehicle.placa + ']';
            vehicleSelect.appendChild(option);
        });

        // poner como seleccionado el vehiculo del ride
        vehicleSelect.value = ride.id_vehiculo;

    } catch (error) {
        mostrarMessage('fatal', error.message);
    }

    
    // evento para cuando se haga click en el boton de submit, lanzamos fetch para actualizar el ride y mostramos mensaje si funciono o no
    submitBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        submitBtn.disabled = true;
        
        // construccion de url y formData para enviarlo en el fetch
        const formData = new FormData(form);
        const url = '../actions/handler.php?controller=rides&action=updateRide';

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

            mostrarMessage('success', result.success);
            
            setTimeout(() => {
                window.location.href = 'rides.php';
            }, 1200);
        } catch (error) {
            mostrarMessage('fatal', error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });
});
