function mostrarFotoVehiculo(isEditMode, fotoActual = '') {
    // obtener el input de fotos y el elemento de la imagen 
    const photoInput = document.getElementById('vehicle-photo');
    const vehicleImage = document.getElementById('vehicle-image');

    if (isEditMode && fotoActual !== '') {
        vehicleImage.src = fotoActual;
        vehicleImage.classList.remove('hidden');
    }

    // escuchamos cuando el user haga cualquier cambio en el input de fotos
    photoInput.addEventListener('change', (event) => {
        // event.target.files es un arreglo de archivos que un usuario sube al input, con [0] agarramos el primero, siempre usaremos el primero pues solo permitimos subir una foto
        const file = event.target.files[0];

        // si no hay archivo, se restaura con la que hay en la base, si no hay nada se oculta
        if (!file) {
            if (isEditMode && fotoActual !== '') {
                vehicleImage.src = fotoActual;
                vehicleImage.classList.remove('hidden');
            } else {
                vehicleImage.src = '';
                vehicleImage.classList.add('hidden');
            }
            return;
        }

        // filereader permite leer archivos del input durante la ejecucion sin subirlos al servidor como lo que hacemos con php
        const reader = new FileReader();

        // onload se ejecuta cuando filereader termina de leer el archivo con el metodo readAsDataURL
        reader.onload = function (e) {
            // e.target.result contiene la data url, un string base64 con el contenido de la imagen
            vehicleImage.src = e.target.result;
            vehicleImage.classList.remove('hidden');
        };
        // readasdataurl convierte el archivo en un string base64 listo para usar como src
        reader.readAsDataURL(file);
    });
}
