document.addEventListener('DOMContentLoaded', async () => {
    // Seleccionar el tbody y el formulario invisible donde guardaremos el data id del ride seleccionado para enviarlo a la pagina de editar ride donde se agarra con metodo post
    const tableBody = document.getElementById('rides-tbody');
    const rideForm = document.getElementById('ride-form');


    try {
        const response = await fetch('ride/getAll');
        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || 'Respuesta invalida del servidor');
        }

        if (result.rides.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="8">No tienes rides registrados.</td></tr>';
            return;
        }
        let rows = '';

        result.rides.forEach(ride => {
            const idAttr = ride.id_ride ? `data-id="${ride.id_ride}"` : '';
            // la fecha tendra un formato de horas y minutos pero no segundos, hacerlo con format
            
            rows += `
                <tr>
                    <td>${ride.nombre}</td>
                    <td>${ride.origen}</td>
                    <td>${ride.destino}</td>
                    <td>${ride.fechaHoraFormateada}</td>
                    <td>${ride.costoAsiento}</td>
                    <td>${ride.asientos}</td>
                    <td>${ride.marca} ${ride.modelo} (${ride.anio})</td>
                    <td>
                        <button class="btn btn-secondary" data-rides-action="edit" ${idAttr}>Editar</button>
                        <button class="btn btn-secondary" data-rides-action="delete" ${idAttr}>Eliminar</button>
                    </td>
                </tr>
            `;
        });
        tableBody.innerHTML = rows;

        // Seleccionar los botones despues de renderizar la tabla
        const editRideButtons = document.querySelectorAll('[data-rides-action="edit"]');
        const deleteRideButtons = document.querySelectorAll('[data-rides-action="delete"]');

        // Agregar eventos a los botones de editar para guardar el id en el formulario y enviarlo para que redireccione a la pagina de editar ride
        editRideButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const rideId = button.dataset.id;
                if (!rideId) {
                    return;
                }
                rideForm.rideId.value = rideId;
                rideForm.submit();
            });
        });

        // Agregar eventos a los botones de eliminar ride
        deleteRideButtons.forEach((button) => {
            button.addEventListener('click', async (event) => {
                event.preventDefault();
                const rideId = button.dataset.id;
                if (!rideId) {
                    return;
                }
                rideForm.rideId.value = rideId;

                try {
                    const formData = new FormData(rideForm);
                    const url = '../actions/handler.php?controller=rides&action=deleteRide';

                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (!result.success) {
                        alert(result.error || 'Error al eliminar el ride.');
                        return;
                    }

                    // eliminar dinamicamente la fila sin tener que refrescar la pagina
                    const row = button.closest('tr');
                    if (row) {
                        tableBody.removeChild(row);
                    }
                } catch (error) {
                    console.error('Error al eliminar el ride:', error);
                }
            });
        });
    } catch (error) {
        console.error('Error al mostrar los rides:', error);
        tableBody.innerHTML = '<tr><td colspan="8">Error al cargar los rides.</td></tr>';
    }
});
