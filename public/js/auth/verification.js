document.addEventListener("DOMContentLoaded", () => {
    const verifyButton = document.getElementById("verify-btn");
    const verificationMessage = document.getElementById("verification-message");
    const verificationIcon = document.getElementById("verification-icon");

    if (!verifyButton || !verificationMessage) return; // evita errores si no existe

    const setIconState = (estado) => { // una funcion en una variable, debe estar inicializada antes de que se empiece de llamarla
        verificationIcon.classList.remove("verification-icon-success", "verification-icon-error");
        if (estado === "success") {
            verificationIcon.classList.add("verification-icon-success");
        } else if (estado === "error") {
            verificationIcon.classList.add("verification-icon-error");
        }
    };

    // Obtener el parametro "token"
    const params = new URLSearchParams(window.location.search);
    let token = params.get("token");

    if (!token) {
        verificationMessage.textContent = "Token invalido o expirado";
        verifyButton.disabled = true;
        verifyButton.classList.add("hidden");
        setIconState("error");
        return;
    }

    const config = window.authConfig || {};
    const verifyUrl = config.verifyUrl || '/auth/verification';
    const loginUrl = config.loginUrl || '/login';

    // Evitamos que el form redireccione a actions/handler.php
    verifyButton.addEventListener("click", async (e) => {
        // funcion asincrona para usar await
        e.preventDefault(); // evitar refrescar la pagina
        setIconState(); // limpiar cualquier estado previo
        verifyButton.disabled = true;
        verifyButton.textContent = "Verificando...";
        verificationMessage.textContent = "Verificando tu cuenta...";

        // Construir la url 
        const url = `${verifyUrl}?token=${token}`;

        try {
            // esperar una respuesta de la url
            const response = await fetch(url, {
                method: "GET",
            });

            // Response actualmente es un objeto crudo de la respuesta HTTP del servidor que enviamos
            const result = await response.json(); // esperar que se convierta la respuesta en un JSON, ocupa await pues el .json es una promesa, por lo que viene del servidor el cual debe leer y procesar la informacion

            if (result.success) {
                //Recogemos en valor de email de la respuesta fetch
                const email = result.email;
                verificationMessage.textContent = "Usuario verificado";
                verifyButton.classList.add("hidden");
                setIconState("success");

                setTimeout(() => {
                    //Redireccionar a Login
                    window.location.href = `${loginUrl}?email=${encodeURIComponent(email)}`;
                }, 3000);
            } else {
                verificationMessage.textContent = "No se pudo verificar la cuenta";
                setIconState("error");
                verifyButton.classList.add("hidden");
                console.error(result.error);
            }
        } catch (error) {
            verificationMessage.textContent = "Ocurrio un error";
            setIconState("error");
            verifyButton.classList.add("hidden");
            console.error(error);
        }
    });


});
