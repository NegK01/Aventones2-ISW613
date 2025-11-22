const defaultImage =
    "https://img.freepik.com/premium-vector/profile-contact-icon-vector-flat-gradient-color-illustration-art_1108489-10.jpg?semt=ais_hybrid&w=740&q=80";

// Elemento HTML que se usa desde reservations.php para cargar las reservas
const tableReservesBody = document.getElementById("reserves-tbody");

// Necasario para cargar las tablas de rideDetails.php
const tableRideBody = document.getElementById("ride-tbody");
const tableVehicleBody = document.getElementById("vehicle-tbody");

// Boton creado en rideDetails.php
const reserveButton = document.getElementById("reserve-btn");

// El idform solo se va a usar en rideDetails.php para cargar el ride como para reservarlo
const idForm = document.getElementById("id-form");

// El reserveForm solo se va a usar en reservations.php para mandar el id de la reserva
const reserveForm = document.getElementById("reserve-form");

document.addEventListener("DOMContentLoaded", () => {
    if (tableReservesBody) {
        cargarReservas();
    }

    if (tableRideBody && tableVehicleBody) {
        cargarDetalles();
    }

    if (reserveButton) {
        reserveButton.addEventListener("click", (event) => {
            event.preventDefault();

            reservarRide(idForm);
        });
    }
});

async function cargarReservas() {
    try {
        const response = await fetch(
            "../actions/handler.php?controller=reserves&action=mostrarReservas"
        );

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || "Respuesta invalida del servidor");
        }

        if (result.reserves.length === 0) {
            tableReservesBody.innerHTML =
                '<tr><td colspan="8">No hay ninguna reserva realizada.</td></tr>';
            return;
        }

        const estadoLabels = {
            1: "Confirmado",
            2: "Pendiente",
            3: "Rechazado",
        };

        const estadoColors = {
            1: "green-badge",
            2: "yellow-badge",
            3: "red-badge",
        };

        let rows = "";

        result.reserves.forEach((reserve) => {
            const numeroEstado = reserve.id_estado;

            const estadoText = estadoLabels[numeroEstado] || "Sin estado";
            const badgeClass = estadoColors[numeroEstado] || "yellow-badge";

            // Estos ids se agregaran a los botones en diferentes casos, si es cliente podra ver el ride desde el boton "info" con el id de ride, en el caso de ser chofer solo tendra en los botones el id de la reserva.

            // Id de el ride
            const idRide = reserve.id_ride
                ? `data-id="${reserve.id_ride}"`
                : "";

            // Id de la reserva
            const idReserve = reserve.id_reserva
                ? `data-id="${reserve.id_reserva}"`
                : "";

            userRole = reserveForm.userRole.value;

            let actionButtons = "";

            if (numeroEstado == 1 && userRole == 3) {

                actionButtons += `
                        <a href="#" class="btn btn-secondary btn-none-decoration" reserve-action="details" ${idRide}>Info</a>
                        <button class="btn btn-secondary" reserve-action="decline" ${idReserve} data-state="3">Rechazar</button>
                    `;

            } else if (numeroEstado == 2) {
                if (userRole == 2) {
                    actionButtons += `
                            <button class="btn btn-secondary" reserve-action="accept" ${idReserve} data-state="1">Aceptar</button>
                            <button class="btn btn-secondary" reserve-action="decline" ${idReserve} data-state="3">Rechazar</button>
                        `;
                } else {
                    actionButtons += `
                            <a href="#" class="btn btn-secondary btn-none-decoration" reserve-action="details" ${idRide}>Info</a>
                            <button class="btn btn-secondary" reserve-action="decline" ${idReserve} data-state="3">Cancelar</button>
                        `;
                }
            } else {
                actionButtons += `
                        <a href="#" class="btn btn-secondary btn-none-decoration" reserve-action="details" ${idRide}>Info</a>
                    `;
            }

            rows += `
                <tr>
                    <td>${reserve.nombreRide}</td>
                    <td>${reserve.fechaReserva}</td>
                    <td>${reserve.origen}</td>
                    <td>${reserve.destino}</td>
                    <td>${reserve.nombre + " " + reserve.apellido}</td>
                    <td>${
                        reserve.marca +
                        " " +
                        reserve.modelo +
                        " " +
                        reserve.anio
                    }</td>
                    <td><span class="badge ${badgeClass} vehicle-status-badge">${estadoText}</span></td>
                    <td>
                        <div class="table-actions">
                            ${actionButtons}
                        </div>
                    </td>
                </tr>
            `;
        });

        tableReservesBody.innerHTML = rows;

        // Seleccionar los botones despues de renderizar la tabla
        const detailsReserve = document.querySelectorAll(
            '[reserve-action="details"]'
        );
        const acceptReserve = document.querySelectorAll(
            '[reserve-action="accept"]'
        );
        const declineReserve = document.querySelectorAll(
            '[reserve-action="decline"]'
        );

        // Agregar eventos a los botones de ver reserva
        detailsReserve.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();
                const rideId = button.dataset.id;
                if (!rideId) {
                    return;
                }

                reserveForm.rideId.value = rideId;
                reserveForm.userRole.value = true;
                reserveForm.submit();
            });
        });

        // Estos dos listener van tendran la funcion de aceptar o rechazar la reserva, cada uno obtendra el numero el estado al que debera cambiar la reserva y lo mandara con el id al reserveController.php.

        // Agregar eventos a los botones de aceptar reserva
        acceptReserve.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const reserveId = button.dataset.id;
                const reserveState = button.dataset.state;

                if (!reserveId || !reserveState) {
                    return;
                }

                reserveForm.reserveId.value = reserveId;
                reserveForm.reserveState.value = reserveState;

                cambiarEstadoReserva(reserveForm);
            });
        });

        // Agregar eventos a los botones de rechazar reserva
        declineReserve.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const reserveId = button.dataset.id;
                const reserveState = button.dataset.state;

                if (!reserveId || !reserveState) {
                    return;
                }

                reserveForm.reserveId.value = reserveId;
                reserveForm.reserveState.value = reserveState;

                cambiarEstadoReserva(reserveForm);
            });
        });
    } catch (error) {
        console.error("No se pudo cargar las reservas: ", error);
        tableBody.innerHTML = `<tr><td colspan="8">Error: ${error.message}</td></tr>`;
    }
}

async function cargarDetalles() {
    try {
        const formData = new FormData(idForm);
        const url =
            "../actions/handler.php?controller=rides&action=mostrarRide";

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (!result.success) {
            mostrarMessage("error", result.error);
            tableRideBody.innerHTML =
                '<tr><td colspan="8">Error al cargar el ride</td></tr>';

            tableVehicleBody.innerHTML =
                '<tr><td colspan="8">Error al cargar el vehiculo</td></tr>';
            return;
        }

        const ride = result.ride;

        document.getElementById("driver-photo").src =
            ride.fotografia || defaultImage;

        document.getElementById("driver-name").textContent =
            ride.nombreUsuario + " " + ride.apellidoUsuario;

        document.getElementById("ride-title").textContent = ride.nombre;

        const infoTablaRide = `
                    <tr>
                        <th>Origen:</th>
                        <td>${ride.origen}</td>
                    </tr>
                    <tr>
                        <th>Destino:</th>
                        <td>${ride.destino}</td>
                    </tr>
                    <tr>
                        <th>Fecha/Hora:</th>
                        <td>${ride.fechaHoraFormateada}</td>
                    </tr>
                    <tr>
                        <th>Costo por asiento:</th>
                        <td>${ride.costoAsiento}</td>
                    </tr>
                    <tr>
                        <th>Asientos disponibles:</th>
                        <td>${ride.asientos}</td>
                    </tr>
                    <tr>
                        <th>Descripción:</th>
                        <td>${ride.detalles}</td>
                    </tr>
                `;

        tableRideBody.innerHTML = infoTablaRide;

        const infoTablaVehiculo = `
                    <tr>
                        <th>Marca:</th>
                        <td>${ride.marca}</td>
                    </tr>
                    <tr>
                        <th>Modelo:</th>
                        <td>${ride.modelo}</td>
                    </tr>
                    <tr>
                        <th>Año:</th>
                        <td>${ride.anio}</td>
                    </tr>
                    <tr>
                        <th>Color:</th>
                        <td>${ride.color}</td>
                    </tr>
                `;

        tableVehicleBody.innerHTML = infoTablaVehiculo;
    } catch (error) {
        mostrarMessage("fatal", error.message);
        tableRideBody.innerHTML =
            '<tr><td colspan="8">Error al cargar el ride</td></tr>';

        tableVehicleBody.innerHTML =
            '<tr><td colspan="8">Error al cargar el vehiculo</td></tr>';
    }
}

// Esta funcion se utiliza tanto en index.php como en rideDetails.php, en el caso de usarse en index.php se va a llamar la funcion desde search.js, en el otro caso se llamara desde un listener aqui en reserve.js.
async function reservarRide(RideIdForm) {
    let url = "actions/handler.php?controller=reserves&action=insertReserve";

    if (tableRideBody && tableVehicleBody) {
        url = "../" + url;
    }

    try {
        const formData = new FormData(RideIdForm);

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            mostrarMessage("success", result.success);

            if (reserveButton) {
                // Se esconde el boton de rideDetails despues de reservar
                reserveButton.hidden = true;
            }
        } else {
            mostrarMessage("error", result.error);
        }
    } catch (error) {
        mostrarMessage("fatal", error.message);
    }
}

async function cambiarEstadoReserva(reserveInfoForm) {
    try {
        const formData = new FormData(reserveInfoForm);
        const url =
            "../actions/handler.php?controller=reserves&action=updateReserve";

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || "Error al realizar la solicitud");
        }

        cargarReservas();
    } catch (error) {
        console.error("Error al realizar la solicitud:", error);
    }
}
