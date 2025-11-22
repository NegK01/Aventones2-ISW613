document.addEventListener("DOMContentLoaded", function () {
    // Seleccionar el elemento del filtro
    const filtro = document.getElementById("user-status-filter");

    cargarUsuarios(0);

    // Agregar evento a la busqueda de usuarios mediante el filtro
    filtro.addEventListener("change", async function () {
        const selectedValue = filtro.value;
        console.log("Filtro seleccionado:", selectedValue);
        cargarUsuarios(selectedValue);
    });
});

// funcion para renderizar la tabla de usuarios con el filtro previamente seleccionado
async function cargarUsuarios(idEstado) {
    const tableBody = document.getElementById("users-tbody");
    const userForm = document.getElementById("user-form");

    try {
        const response = await fetch(
            `../actions/handler.php?controller=auth&action=cargarUsuarios&id=${idEstado}`
        );
        const result = await response.json();

        if (!result.success) {
            throw new Error(result.error || "Error al cargar los usuarios.");
        }

        if (result.users.length === 0) {
            tableBody.innerHTML =
                '<tr><td colspan="8">No hay usuarios registrados.</td></tr>';
            return;
        }

        let rows = "";

        result.users.forEach((usuario) => {
            let badgeClass = "";
            switch (usuario.estado) {
                case "Activo":
                    badgeClass = "green-badge";
                    break;
                case "Pendiente":
                    badgeClass = "yellow-badge";
                    break;
                case "Inactivo":
                    badgeClass = "red-badge";
                    break;
            }
            const idAttr = usuario.id_usuario
                ? `data-id="${usuario.id_usuario}"`
                : "";

            // almacenar cuales seran los botones de accion a mostrar segun el estado del usuario
            let actionButtons = "";

            // verificar si el usuario esta activo, inactivo o pendiente para mostrar los botones correspondientes
            if (usuario.estado === "Activo") {
                // mostrar boton de desactivar
                actionButtons += `<button type="button" class="btn btn-secondary" data-users-action="desactivar" ${idAttr}>Desactivar</button>`;
            } else if (usuario.estado === "Inactivo") {
                // mostrar boton de activar
                actionButtons += `<button type="button" class="btn btn-secondary" data-users-action="activar" ${idAttr}>Activar</button>`;
            } else if (usuario.estado === "Pendiente") {
                // mostrar boton de aprobar
                actionButtons += `<button type="button" class="btn btn-secondary" data-users-action="aprobar" ${idAttr}>Aprobar</button>`;
            }

            rows += `
                <tr>
                    <td>${usuario.id_usuario}</td>
                    <td>${usuario.nombre} ${usuario.apellido}</td>
                    <td>${usuario.correo}</td>
                    <td>${usuario.rol}</td>
                    <td>${usuario.fechaDeRegistro}</td>
                    <td><span class="badge ${badgeClass}">${usuario.estado}</span></td>
                    <td class="table-actions">
                        ${actionButtons}
                    </td>
                </tr>
            `;
        });
        tableBody.innerHTML = rows;

        // Seleccionar los botones despues de renderizar la tabla
        const desactivarUserButtons = document.querySelectorAll(
            '[data-users-action="desactivar"]'
        );
        const activarUserButtons = document.querySelectorAll(
            '[data-users-action="activar"]'
        );
        const aprobarUserButtons = document.querySelectorAll(
            '[data-users-action="aprobar"]'
        );

        // Agregar eventos a los botones de desactivar usuario, estado cambiado a inactivo y boton desactivar => activar
        desactivarUserButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();

                const userId = button.getAttribute("data-id");
                if (!userId) return;

                userForm.userId.value = userId;
                userForm.statusId.value = 5; // Estado "Inactivo"

                try {
                    const url =
                        "../actions/handler.php?controller=auth&action=cambiarEstadoUsuario";
                    const formData = new FormData(userForm);

                    const response = await fetch(url, {
                        method: "POST",
                        body: formData,
                    });
                    const result = await response.json();

                    if (!result) {
                        throw new Error("Error al activar el usuario.");
                    }

                    // refrescar la pagina
                    location.reload();
                } catch (error) {
                    console.error("Error al activar el usuario:", error);
                }
            });
        });

        // Agregar eventos a los botones de activar usuario, estado cambiado a activo y boton activar => desactivar
        activarUserButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();

                const userId = button.getAttribute("data-id");
                if (!userId) return;

                userForm.userId.value = userId;
                userForm.statusId.value = 4; // Estado "Inactivo"

                try {
                    const url =
                        "../actions/handler.php?controller=auth&action=cambiarEstadoUsuario";
                    const formData = new FormData(userForm);

                    const response = await fetch(url, {
                        method: "POST",
                        body: formData,
                    });
                    const result = await response.json();

                    if (!result) {
                        throw new Error("Error al desactivar el usuario.");
                    }

                    // refrescar la pagina
                    location.reload();
                } catch (error) {
                    console.error("Error al desactivar el usuario:", error);
                }
            });
        });

        // Agregar eventos a los botones de aprobar usuario, estado cambiado a activo y boton aprobar => activar
        aprobarUserButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();

                const userId = button.getAttribute("data-id");
                if (!userId) return;

                userForm.userId.value = userId;
                userForm.statusId.value = 4; // Estado "Activo"

                try {
                    const url = "../actions/handler.php?controller=auth&action=cambiarEstadoUsuario";
                    const formData = new FormData(userForm);

                    const response = await fetch(url, {
                        method: "POST",
                        body: formData,
                    });
                    const result = await response.json();

                    if (!result) {
                        throw new Error("Error al aprobar el usuario.");
                    }

                    // refrescar la pagina
                    location.reload();
                } catch (error) {
                    console.error("Error al aprobar el usuario:", error);
                }
            });
        });

    } catch (error) {
        console.error("Error al mostrar los usuarios:", error);
        tableBody.innerHTML =
            '<tr><td colspan="7">Error al cargar los usuarios.</td></tr>';
    }
}
