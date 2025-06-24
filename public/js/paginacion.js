document.addEventListener('DOMContentLoaded', function() {
    // Función para cargar propiedades vía AJAX
    function cargarPropiedades(pagina) {
        const url = new URL(window.location.href);
        url.searchParams.set('pagina', pagina);
        
        // Mostrar indicador de carga
        const tabla = document.querySelector('.propiedades');
        const contenedorTabla = document.querySelector('.contenedor-tabla');
        contenedorTabla.style.opacity = '0.7';
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Crear un elemento temporal para parsear el HTML
            const temp = document.createElement('div');
            temp.innerHTML = html;
            
            // Actualizar la tabla
            const nuevaTabla = temp.querySelector('.propiedades');
            if (nuevaTabla) {
                tabla.outerHTML = nuevaTabla.outerHTML;
            }
            
            // Actualizar la paginación
            const nuevaPaginacion = temp.querySelector('.paginacion');
            const contenedorPaginacion = document.querySelector('.paginacion');
            
            if (nuevaPaginacion && contenedorPaginacion) {
                contenedorPaginacion.outerHTML = nuevaPaginacion.outerHTML;
            } else if (nuevaPaginacion) {
                document.querySelector('.contenedor-tabla').appendChild(nuevaPaginacion);
            } else if (contenedorPaginacion) {
                contenedorPaginacion.remove();
            }
            
            // Actualizar la URL sin recargar la página
            window.history.pushState({}, '', url);
            
            // Restaurar opacidad
            contenedorTabla.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error al cargar las propiedades:', error);
            contenedorTabla.style.opacity = '1';
        });
    }
    
    // Delegación de eventos para los botones de paginación
    document.addEventListener('click', function(e) {
        const boton = e.target.closest('.paginacion a');
        if (boton) {
            e.preventDefault();
            const url = new URL(boton.href);
            const pagina = url.searchParams.get('pagina');
            if (pagina) {
                cargarPropiedades(pagina);
                // Desplazarse suavemente hacia arriba
                window.scrollTo({
                    top: document.querySelector('.contenedor-tabla').offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        }
    });
    
    // Manejar el botón de retroceso/adelanto del navegador
    window.addEventListener('popstate', function() {
        const url = new URL(window.location.href);
        const pagina = url.searchParams.get('pagina') || 1;
        cargarPropiedades(pagina);
    });
});
