const searchForm = document.getElementById("search-form");
const tableBody = document.getElementById("rides-tbody");
const rideForm = document.getElementById("ride-form");
const tableOrder = document.getElementById("sort-criteria");

document.addEventListener("DOMContentLoaded", () => {

    cargarRides();

    searchForm.addEventListener("submit", (event) => {
        event.preventDefault();

        cargarRides();
    });

    tableOrder.addEventListener("change", (event) => {
        event.preventDefault();

        ordenarRides();
    });
});

async function cargarRides() {
    try {
        const formData = new FormData(searchForm);
        const url = "ride/search";

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (!result.success) {
            mostrarMessage("error", result.error);
            tableBody.innerHTML =
                '<tr><td colspan="8">No se encontro ningun ride disponible.</td></tr>';
            return;
        }

        if (result.rides.length === 0) {
            tableBody.innerHTML =
                '<tr><td colspan="8">No se encontro ningun ride disponible.</td></tr>';
            return;
        }

        let rows = "";

        result.rides.forEach((ride) => {
            const idAttr = ride.id_ride ? `data-id="${ride.id_ride}"` : "";
            // la fecha tendra un formato de horas y minutos pero no segundos, hacerlo con format

            rows += `
                    <tr ${idAttr}>
                        <td>${ride.nombre}</td>
                        <td>${ride.origen}</td>
                        <td>${ride.destino}</td>
                        <td>${ride.fechaHoraFormateada}</td>
                        <td>${ride.costoAsiento}</td>
                        <td>${ride.asientos}</td>
                        <td>${ride.marca} ${ride.modelo} (${ride.anio})</td>
                        <td>
                            <button class="btn btn-secondary" data-rides-action="details" ${idAttr}>Info</button>
                            <button class="btn btn-secondary" data-rides-action="reservation" ${idAttr}>Reservar</button>
                        </td>
                    </tr>
                `;
        });
        tableBody.innerHTML = rows;

        const detailsRideButtons = document.querySelectorAll(
            '[data-rides-action="details"]'
        );
        const reservationRideButtons = document.querySelectorAll(
            '[data-rides-action="reservation"]'
        );

        detailsRideButtons.forEach((button) => {
            button.addEventListener("click", (event) => {
                event.preventDefault();
                const rideId = button.dataset.id;
                if (!rideId) {
                    return;
                }
                rideForm.rideId.value = rideId;
                rideForm.submit();
            });
        });

        reservationRideButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();
                const rideId = button.dataset.id;
                if (!rideId) {
                    return;
                }
                rideForm.rideId.value = rideId;

                // Esta funcion es de reservations.js y se manda el id del ride desde aca
                reservarRide(rideForm);
            });
        });

        ordenarRides();
    } catch (error) {
        mostrarMessage("fatal", error.message);
        tableBody.innerHTML =
            '<tr><td colspan="8">Error al cargar los rides.</td></tr>';
    }
}

function ordenarRides() {
    const option = tableOrder.value;
    const rows = Array.from(tableBody.querySelectorAll("tr"));

    let newRows = [];

    switch (option) {
        case "date-asc":
            newRows = rows.sort(
                (a, b) =>
                    new Date(a.children[3].textContent) -
                    new Date(b.children[3].textContent)
            );
            break;
        case "date-desc":
            newRows = rows.sort(
                (a, b) =>
                    new Date(b.children[3].textContent) -
                    new Date(a.children[3].textContent)
            );
            break;
        case "origin-asc":
            newRows = rows.sort((a, b) =>
                a.children[1].textContent.localeCompare(
                    b.children[1].textContent
                )
            );
            break;
        case "origin-desc":
            newRows = rows.sort((a, b) =>
                b.children[1].textContent.localeCompare(
                    a.children[1].textContent
                )
            );
            break;
        case "destination-asc":
            newRows = rows.sort((a, b) =>
                a.children[1].textContent.localeCompare(
                    b.children[1].textContent
                )
            );
            break;
        case "destination-desc":
            newRows = rows.sort((a, b) =>
                b.children[1].textContent.localeCompare(
                    a.children[1].textContent
                )
            );
            break;
        default:
            newRows = rows;
            break;
    }

    tableBody.innerHTML = "";
    newRows.forEach((row) => tableBody.appendChild(row));
}
