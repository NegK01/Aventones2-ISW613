const defaultImage =
    "https://img.freepik.com/premium-vector/profile-contact-icon-vector-flat-gradient-color-illustration-art_1108489-10.jpg?semt=ais_hybrid&w=740&q=80";

// Elemento HTML que se usa desde reservations.php para cargar las reservas
const tableReservationsBody = document.getElementById("reservations-tbody");

// Necasario para cargar las tablas de rideDetails.php
const tableRideBody = document.getElementById("ride-tbody");
const tableVehicleBody = document.getElementById("vehicle-tbody");

// Boton creado en rideDetails.php
const reservationButton = document.getElementById("reservation-btn");

// El idform solo se va a usar en rideDetails.php para cargar el ride como para reservarlo
const idForm = document.getElementById("id-form");

// El reservationForm solo se va a usar en reservations.php para mandar el id de la reserva
const reservationForm = document.getElementById("reservation-form");

document.addEventListener("DOMContentLoaded", () => {
    if (tableReservationsBody) {
        cargarReservas();
    }

    if (tableRideBody && tableVehicleBody) {

        console.log(document.getElementById("rideId").value);

        cargarDetalles();
    }

    if (reservationButton) {
        reservationButton.addEventListener("click", (event) => {
            event.preventDefault();

            reservarRide(idForm);
        });
    }
});

async function cargarReservas() {
    try {
        const response = await fetch("reservation/getAll");

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || "Respuesta invalida del servidor");
        }

        if (result.reservations.length === 0) {
            tableReservationsBody.innerHTML =
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

        result.reservations.forEach((reservation) => {
            const numeroEstado = reservation.id_estado;

            const estadoText = estadoLabels[numeroEstado] || "Sin estado";
            const badgeClass = estadoColors[numeroEstado] || "yellow-badge";

            // Estos ids se agregaran a los botones en diferentes casos, si es cliente podra ver el ride desde el boton "info" con el id de ride, en el caso de ser chofer solo tendra en los botones el id de la reserva.

            // Id de el ride
            const idRide = reservation.id_ride
                ? `data-id="${reservation.id_ride}"`
                : "";

            // Id de la reserva
            const idReservation = reservation.id_reserva
                ? `data-id="${reservation.id_reserva}"`
                : "";

            userRole = reservationForm.userRole.value;

            let actionButtons = "";

            if (numeroEstado == 1 && userRole == 3) {
                actionButtons += `
                        <a href="#" class="btn btn-secondary btn-none-decoration" reservation-action="details" ${idRide}>Info</a>
                        <button class="btn btn-secondary" reservation-action="decline" ${idReservation} data-state="3">Cancelar</button>
                    `;
            } else if (numeroEstado == 2) {
                if (userRole == 2) {
                    actionButtons += `
                            <button class="btn btn-secondary" reservation-action="accept" ${idReservation} data-state="1">Aceptar</button>
                            <button class="btn btn-secondary" reservation-action="decline" ${idReservation} data-state="3">Rechazar</button>
                        `;
                } else {
                    actionButtons += `
                            <a href="#" class="btn btn-secondary btn-none-decoration" reservation-action="details" ${idRide}>Info</a>
                            <button class="btn btn-secondary" reservation-action="decline" ${idReservation} data-state="3">Cancelar</button>
                        `;
                }
            } else {
                actionButtons += `
                        <a href="#" class="btn btn-secondary btn-none-decoration" reservation-action="details" ${idRide}>Info</a>
                    `;
            }

            console.log("cacacac:" + reservation.nombreUsuario);

            rows += `
                <tr>
                    <td>${reservation.nombreRide}</td>
                    <td>${reservation.fechaReserva}</td>
                    <td>${reservation.origen}</td>
                    <td>${reservation.destino}</td>
                    <td>${reservation.nombreUsuario + " " + reservation.apellidoUsuario}</td>
                    <td>${
                        reservation.marca +
                        " " +
                        reservation.modelo +
                        " " +
                        reservation.anio
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

        tableReservationsBody.innerHTML = rows;

        // Seleccionar los botones despues de renderizar la tabla
        const detailsReservation = document.querySelectorAll(
            '[reservation-action="details"]'
        );
        const acceptReservation = document.querySelectorAll(
            '[reservation-action="accept"]'
        );
        const declineReservation = document.querySelectorAll(
            '[reservation-action="decline"]'
        );

        // Agregar eventos a los botones de ver reserva
        detailsReservation.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();
                const rideId = button.dataset.id;
                if (!rideId) {
                    return;
                }

                reservationForm.rideId.value = rideId;
                reservationForm.userRole.value = true;
                reservationForm.submit();
            });
        });

        // Estos dos listener van tendran la funcion de aceptar o rechazar la reserva, cada uno obtendra el numero el estado al que debera cambiar la reserva y lo mandara con el id al reservationController.php.

        // Agregar eventos a los botones de aceptar reserva
        acceptReservation.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const reservationId = button.dataset.id;
                const reservationState = button.dataset.state;

                if (!reservationId || !reservationState) {
                    return;
                }

                reservationForm.reservationId.value = reservationId;
                reservationForm.reservationState.value = reservationState;

                cambiarEstadoReserva(reservationForm);
            });
        });

        // Agregar eventos a los botones de rechazar reserva
        declineReservation.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                const reservationId = button.dataset.id;
                const reservationState = button.dataset.state;

                if (!reservationId || !reservationState) {
                    return;
                }

                reservationForm.reservationId.value = reservationId;
                reservationForm.reservationState.value = reservationState;

                cambiarEstadoReserva(reservationForm);
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
        const url = "ride/getById";

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

// Esta funcion se utiliza tanto en search.php como en details.php, en el caso de usarse en search.php se va a llamar la funcion desde search.js, en el otro caso se llamara desde un listener aqui en Reservation.js.
async function reservarRide(RideIdForm) {
    try {
        const formData = new FormData(RideIdForm);
        const url = "reservation/store";

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            mostrarMessage("success", result.success);

            if (reservationButton) {
                // Se esconde el boton de rideDetails despues de reservar
                reservationButton.hidden = true;
            }
        } else {
            mostrarMessage("error", result.error);
        }
    } catch (error) {
        mostrarMessage("fatal", error.message);
    }
}

async function cambiarEstadoReserva(reservationInfoForm) {
    try {
        const formData = new FormData(reservationInfoForm);
        const url = "reservation/update";

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
