window.onload = function() {
    // Detecta si la página se ha recargado
    if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Obtiene la URL actual sin los parámetros de búsqueda (query string)
        const url = window.location.href.split('?')[0];
        // Redirecciona a la URL base sin parámetros
        window.location.href = url;
    }
};
