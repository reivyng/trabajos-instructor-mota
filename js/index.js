function abrirMenu() {
    document.getElementById("menuLateral").style.width = "300px";
}

function cerrarMenu() {
    document.getElementById("menuLateral").style.width = "0";
}

function cargarContenido(pagina) {
    fetch(pagina)
        .then(response => response.text())
        .then(data => {
            document.getElementById("contenidoPrincipal").innerHTML = data;
        })
        .catch(error => console.error('Error al cargar el contenido:', error));

    cerrarMenu(); // Cierra el menú una vez que se selecciona una opción
}
