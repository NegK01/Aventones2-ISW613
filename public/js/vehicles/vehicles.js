document.addEventListener('DOMContentLoaded', async () => {
    // Seleccionar el tbody y el formulario invisible donde guardaremos el data id del vehiculo seleccionado para enviarlo a la pagina de editar vehiculo donde se agarra con metodo post
    const tableBody = document.getElementById('vehicles-tbody');
    const vehicleForm = document.getElementById('vehicle-form');

    try {
        const response = await fetch('vehicle/getAll');
        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || 'Respuesta invalida del servidor');
        }

        if (result.vehicles.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="8">No tienes vehiculos registrados.</td></tr>';
            return;
        }

        const estadoLabels = {
            1: 'Confirmado',
            2: 'Pendiente',
            3: 'Rechazado',
            4: 'Activo',
            5: 'Inactivo'
        };

        let rows = '';

        result.vehicles.forEach(vehicle => {
            const estadoText = estadoLabels[vehicle.id_estado] || 'Sin estado';
            const badgeClass = String(estadoText) === 'Activo' ? 'green-badge' : 'red-badge';
            const idAttr = vehicle.id_vehiculo ? `data-id="${vehicle.id_vehiculo}"` : '';

            rows += `
                <tr>
                    <td>${vehicle.marca}</td>
                    <td>${vehicle.modelo}</td>
                    <td>${vehicle.anio}</td>
                    <td>${vehicle.color}</td>
                    <td>${vehicle.placa}</td>
                    <td>${vehicle.asientos}</td>
                    <td><span class="badge ${badgeClass} vehicle-status-badge">${estadoText}</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="#" class="btn btn-secondary btn-none-decoration" vehicle-action="edit" ${idAttr}>Editar</a>
                            <button class="btn btn-secondary" vehicle-action="delete" ${idAttr}>Eliminar</button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = rows;

        // Seleccionar los botones despues de renderizar la tabla
        const editVehicle = document.querySelectorAll('[vehicle-action="edit"]');
        const deleteVehicle = document.querySelectorAll('[vehicle-action="delete"]');

        // Agregar eventos a los botones de editar
        editVehicle.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const vehicleId = button.dataset.id;
                if (!vehicleId) {
                    return;
                }
                vehicleForm.vehicleId.value = vehicleId;
                vehicleForm.submit();
            });
        });

        // Agregar eventos a los botones de eliminar
        deleteVehicle.forEach((button) => {
            button.addEventListener('click', async (event) => {
                event.preventDefault();

                const vehicleId = button.dataset.id;
                if (!vehicleId) {
                    return;
                }
                vehicleForm.vehicleId.value = vehicleId;

                try {
                    const formData = new FormData(vehicleForm);
                    const url = 'vehicle/getAll';

                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (!result.success) {
                        throw new Error(result.error || 'Error al eliminar el vehículo');
                    }

                    // modificar el estado de la vista pues es un eliminado logico
                    const row = button.closest('tr');
                    const statusBadge = row ? row.querySelector('.vehicle-status-badge') : null;

                    if (statusBadge) {
                        statusBadge.textContent = 'Inactivo';
                        statusBadge.classList.remove('green-badge');
                        statusBadge.classList.add('red-badge');
                    }
                } catch (error) {
                    console.error('Error al eliminar el vehículo:', error);
                }
            });
        });
        
    } catch (error) {
        console.error('No se pudieron cargar los vehículos: ', error);
        tableBody.innerHTML = `<tr><td colspan="8">Error: ${error.message}</td></tr>`;
    }
});
