function validarlogin(usuario, clave) {
    var regex = /[-!$%^&*()_+|~=`{}\[\]:";'<>?.\/]/;

    if (regex.test(usuario) || regex.test(clave)) {
        alert('Los datos introducidos contienen caracteres no permitidos.');
        return false;
    }

    return true;
}

function validarDatos(datos) {
     var regex = /[^a-zA-Z0-9\s,.áéíóúÁÉÍÓÚñÑüÜ]/;

    var valido = true;
    datos.forEach(function(dato) {
        if (regex.test(dato)) {
            alert('El dato "' + dato + '" contiene caracteres no permitidos.');
            valido = false;
        }
    });
    return valido;
}

function login() { 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta == "false") {
                alert("Revise usuario y contraseña");
            } else {
                window.location.href = "../vista/principal.php";
            }
        }
    }
    var usuario = document.getElementById("usuario").value;
    var clave = document.getElementById("clave").value;
    $comprobar = validarlogin(usuario, clave);
    if ($comprobar === false){
        return false;
    }else{
    var params ="usuario="+ usuario + " & clave=" + clave;
    xhttp.open("post", "http://localhost/proyecto_alejandro_vega/BD/loginmodelo.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
    }
}

function logout(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/loginmodelo.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            window.location.href = "../vista/loginvista.php";
        } else if (xhr.readyState === 4) {
            console.error('Error al hacer el logout:', xhr.status);
        }
    };
    xhr.send();
}

//eventos

function obtenereventos() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/evento', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            if(response.mensaje == "No hay eventos"){
                var div = document.createElement('div');
                var br = document.createElement('br');
                div.classList.add('text-center');
                var botonCrear = document.createElement('button');
                botonCrear.classList.add('btn');
                botonCrear.classList.add('btn-success');
                botonCrear.classList.add('btn-lg');
                botonCrear.classList.add('btn-block');
                botonCrear.textContent = 'Añadir evento';
                botonCrear.addEventListener('click', function() {
                    anadireventoformulario();
                });
                div.appendChild(botonCrear);
                principal.appendChild(br);
                principal.appendChild(div);
            } else{
                response.sort(function(a, b) {
                    return new Date(a.fecha) - new Date(b.fecha);
                });
                var tabla = document.createElement('table');
                tabla.classList.add('table');
                tabla.classList.add('table-primary');
                var cabecera = document.createElement('thead');
                var cabeceraFila = document.createElement('tr');
                var cabeceraID = document.createElement('th');
                cabeceraID.textContent = 'ID';
                var cabeceraNombre = document.createElement('th');
                cabeceraNombre.textContent = 'Nombre Evento';
                var cabeceraFecha = document.createElement('th');
                cabeceraFecha.textContent = 'Fecha';
                var cabeceraAcciones = document.createElement('th');
                cabeceraAcciones.textContent = 'Acciones';
                cabeceraFila.appendChild(cabeceraID);
                cabeceraFila.appendChild(cabeceraNombre);
                cabeceraFila.appendChild(cabeceraFecha);
                cabeceraFila.appendChild(cabeceraAcciones);
                cabecera.appendChild(cabeceraFila);
                tabla.appendChild(cabecera);

                var cuerpo = document.createElement('tbody');
                response.forEach(function (evento) {
                    var fila = document.createElement('tr');
                    var columnaID = document.createElement('td');
                    columnaID.textContent = evento.id;
                    var columnaNombre = document.createElement('td');
                    columnaNombre.textContent = evento.nombre_evento;
                    var columnaFecha = document.createElement('td');
                    columnaFecha.textContent = evento.fecha;
                    fila.appendChild(columnaID);
                    fila.appendChild(columnaNombre);
                    fila.appendChild(columnaFecha);

                    var columnaAcciones = document.createElement('td');
                    var botonVer = document.createElement('button');
                    botonVer.classList.add('btn');
                    botonVer.classList.add('btn-primary');
                    botonVer.textContent = 'Ver';
                    botonVer.addEventListener('click', function() {
                        verEvento(evento.id);
                    });
                    columnaAcciones.appendChild(botonVer);

                    var botonBorrar = document.createElement('button');
                    botonBorrar.classList.add('btn');
                    botonBorrar.classList.add('btn-danger');
                    botonBorrar.textContent = 'Eliminar';
                    botonBorrar.addEventListener('click', function() {
                        borrarEvento(evento.id);
                    });
                    columnaAcciones.appendChild(botonBorrar);

                    fila.appendChild(columnaAcciones);
                    cuerpo.appendChild(fila);
                });
                tabla.appendChild(cuerpo);
                var botonCrear = document.createElement('button');
                    botonCrear.classList.add('btn');
                    botonCrear.classList.add('btn-success');
                    botonCrear.classList.add('btn-lg');
                    botonCrear.classList.add('btn-block');
                    botonCrear.textContent = 'Añadir Evento';
                    botonCrear.addEventListener('click', function() {
                        anadireventoformulario();
                    });
                var botonactualizar = document.createElement('button');
                botonactualizar.classList.add('btn');
                botonactualizar.classList.add('btn-info');
                botonactualizar.classList.add('btn-lg');
                botonactualizar.classList.add('btn-block');
                botonactualizar.textContent = 'Actualizar un evento';
                botonactualizar.addEventListener('click', function() {
                    actualizareventoformulario();
                });
                var botoncalendario = document.createElement('button');
                botoncalendario.classList.add('btn');
                botoncalendario.classList.add('btn-warning');
                botoncalendario.classList.add('btn-lg');
                botoncalendario.classList.add('btn-block');
                botoncalendario.textContent = 'Calendario';
                botoncalendario.addEventListener('click', function() {
                    obtenerEventosYCrearCalendario();
                });
                var div = document.createElement('div');
                div.classList.add('text-center');
                div.appendChild(tabla);
                div.appendChild(botonCrear);
                div.appendChild(botonactualizar);
                div.appendChild(botoncalendario);
                principal.appendChild(div);
            }
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener eventos:', xhr.status);
        }
    };
    xhr.send();
}

function crearCalendario(eventos) {
    var calendario = document.getElementById('principal');
    calendario.innerHTML= '';

    var tabla = document.createElement('table');
    tabla.classList.add('calendario');

    var cabecera = document.createElement('thead');
    var cabeceraFila = document.createElement('tr');
    ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'].forEach(function(dia) {
        var cabeceraDia = document.createElement('th');
        cabeceraDia.textContent = dia;
        cabeceraFila.appendChild(cabeceraDia);
    });
    cabecera.appendChild(cabeceraFila);
    tabla.appendChild(cabecera);

    var cuerpo = document.createElement('tbody');
    var fechaActual = new Date();
    var primerDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
    var ultimoDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);
    var diaSemanaInicio = primerDiaMes.getDay();
    var diaSemanaFin = ultimoDiaMes.getDay();
    var diaMes = 1;

    for (var i = 0; i < 6; i++) {
        var fila = document.createElement('tr');
        for (var j = 0; j < 7; j++) {
            var celda = document.createElement('td');
            if ((i === 0 && j < diaSemanaInicio) || diaMes > ultimoDiaMes.getDate()) {
                celda.textContent = '';
            } else {
                celda.textContent = diaMes;
                var tieneEvento = eventos.some(function(evento) {
                    var fechaEvento = new Date(evento.fecha);
                    return diaMes === fechaEvento.getDate() && fechaActual.getMonth() === fechaEvento.getMonth() && fechaActual.getFullYear() === fechaEvento.getFullYear();
                });
                if (tieneEvento) {
                    celda.classList.add('evento');
                }
                diaMes++;
            }
            fila.appendChild(celda);
        }
        cuerpo.appendChild(fila);
        if (diaMes > ultimoDiaMes.getDate()) {
            break;
        }
    }
    tabla.appendChild(cuerpo);
    calendario.appendChild(tabla);
}

function obtenerEventosYCrearCalendario() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/evento', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var eventos = JSON.parse(xhr.responseText);
            crearCalendario(eventos);
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener eventos:', xhr.status);
        }
    };
    xhr.send();
}

//create evento

function anadireventoformulario(){
    window.location.href = "../vista/formularioevento.php";
}

function anadirevento(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Evento creado exitosamente") {
                alert("Evento creado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al crear el evento");
            }
        }
    }
    var nombre = document.getElementById("nombre_evento").value;
    var descripcion = document.getElementById("descripcion_evento").value;
    var aforo = document.getElementById("aforo_evento").value;
    var fecha = document.getElementById("fecha_evento").value;
    var datos = [nombre, descripcion, aforo];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="nombre="+ nombre + " & descripcion=" + descripcion + " & aforo=" + aforo + " & fecha=" + fecha;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/evento/anadirevento';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

//read evento

function verEvento(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';

            var tabla = document.createElement('table');
            tabla.classList.add('table');
            tabla.classList.add('table-primary');
            var cabecera = document.createElement('thead');
            var cabeceraFila = document.createElement('tr');
            var cabeceraID = document.createElement('th');
            cabeceraID.textContent = 'ID';
            var cabeceraNombre = document.createElement('th');
            cabeceraNombre.textContent = 'Nombre Evento';
            var cabeceraDescripcion = document.createElement('th');
            cabeceraDescripcion.textContent = 'Descripción';
            var cabeceraaforo = document.createElement('th');
            cabeceraaforo.textContent = 'Aforo';
            var cabeceraFecha = document.createElement('th');
            cabeceraFecha.textContent = 'Fecha';
            cabeceraFila.appendChild(cabeceraID);
            cabeceraFila.appendChild(cabeceraNombre);
            cabeceraFila.appendChild(cabeceraDescripcion);
            cabeceraFila.appendChild(cabeceraaforo);
            cabeceraFila.appendChild(cabeceraFecha);
            cabecera.appendChild(cabeceraFila);
            tabla.appendChild(cabecera);

            var cuerpo = document.createElement('tbody');
            response.forEach(function (evento) {
                var fila = document.createElement('tr');

                var columnaID = document.createElement('td');
                columnaID.textContent = evento.id;

                var columnaNombre = document.createElement('td');
                columnaNombre.textContent = evento.nombre_evento;

                var columnaDescripcion = document.createElement('td');
                columnaDescripcion.textContent = evento.descripcion;

                var columnaAforo = document.createElement('td');
                columnaAforo.textContent = evento.aforo_max;

                var columnaFecha = document.createElement('td');
                columnaFecha.textContent = evento.fecha;

                fila.appendChild(columnaID);
                fila.appendChild(columnaNombre);
                fila.appendChild(columnaDescripcion);
                fila.appendChild(columnaAforo);
                fila.appendChild(columnaFecha);

                cuerpo.appendChild(fila);
            });
            tabla.appendChild(cuerpo);

            principal.appendChild(tabla);
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el evento:', xhr.status);
        }
    }
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/evento/obtenerEventoID?id=' + id, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    return false;
}

//update evento(terminar)

function actualizareventoformulario(){
    window.location.href = "../vista/actualizarevento.php";
}

function actualizarEvento() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Evento actualizado") {
                alert("Evento actualizado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al actualizar el evento");
            }
        }
    }
    var id = document.getElementById("id_evento").value;
    var nombre = document.getElementById("nombre_evento").value;
    var descripcion = document.getElementById("descripcion_evento").value;
    var aforo = document.getElementById("aforo_evento").value;
    var fecha = document.getElementById("fecha_evento").value;
    var datos = [nombre, descripcion, aforo];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="id="+ id + "& nombre="+ nombre + " & descripcion=" + descripcion + " & aforo=" + aforo + " & fecha=" + fecha;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/evento/actualizarevento';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

//delete evento

function borrarEvento(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var respuesta = JSON.parse(this.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            alert('evento eliminado con éxito');
            obtenereventos();
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el evento:', xhr.status);
        }
    }
    var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/evento/eliminarEventoID?id=' + id;
    xhr.open('DELETE', url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
}

//cursos

function obtenercursos() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/curso', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            if(response.mensaje == "No hay cursos"){
                var div = document.createElement('div');
                var br = document.createElement('br');
                div.classList.add('text-center');
                var botonCrear = document.createElement('button');
                botonCrear.classList.add('btn');
                botonCrear.classList.add('btn-success');
                botonCrear.classList.add('btn-lg');
                botonCrear.classList.add('btn-block');
                botonCrear.textContent = 'Añadir curso';
                botonCrear.addEventListener('click', function() {
                    anadircursoformulario();
                });
                div.appendChild(botonCrear);
                principal.appendChild(br);
                principal.appendChild(div);
            } else{
                response.sort(function(a, b) {
                    return new Date(a.fecha) - new Date(b.fecha);
                });
                var tabla = document.createElement('table');
                tabla.classList.add('table');
                tabla.classList.add('table-success');
                var cabecera = document.createElement('thead');
                var cabeceraFila = document.createElement('tr');
                var cabeceraID = document.createElement('th');
                cabeceraID.textContent = 'ID';
                var cabeceraNombre = document.createElement('th');
                cabeceraNombre.textContent = 'Nombre Curso';
                var cabeceraFecha = document.createElement('th');
                cabeceraFecha.textContent = 'Fecha';
                var cabeceraAcciones = document.createElement('th');
                cabeceraAcciones.textContent = 'Acciones';
                cabeceraFila.appendChild(cabeceraID);
                cabeceraFila.appendChild(cabeceraNombre);
                cabeceraFila.appendChild(cabeceraFecha);
                cabeceraFila.appendChild(cabeceraAcciones);
                cabecera.appendChild(cabeceraFila);
                tabla.appendChild(cabecera);

                var cuerpo = document.createElement('tbody');
                response.forEach(function (curso) {
                    var fila = document.createElement('tr');
                    var columnaID = document.createElement('td');
                    columnaID.textContent = curso.id;
                    var columnaNombre = document.createElement('td');
                    columnaNombre.textContent = curso.nombre_curso;
                    var columnaFecha = document.createElement('td');
                    columnaFecha.textContent = curso.fecha_inicio;
                    fila.appendChild(columnaID);
                    fila.appendChild(columnaNombre);
                    fila.appendChild(columnaFecha);

                    var columnaAcciones = document.createElement('td');
                    var botonVer = document.createElement('button');
                    botonVer.classList.add('btn');
                    botonVer.classList.add('btn-primary');
                    botonVer.textContent = 'Ver';
                    botonVer.addEventListener('click', function() {
                        verCurso(curso.id);
                    });
                    columnaAcciones.appendChild(botonVer);

                    var botonBorrar = document.createElement('button');
                    botonBorrar.classList.add('btn');
                    botonBorrar.classList.add('btn-danger');
                    botonBorrar.textContent = 'Eliminar';
                    botonBorrar.addEventListener('click', function() {
                        borrarCurso(curso.id);
                    });
                    columnaAcciones.appendChild(botonBorrar);

                    fila.appendChild(columnaAcciones);
                    cuerpo.appendChild(fila);
                });
                tabla.appendChild(cuerpo);
                var botonCrear = document.createElement('button');
                    botonCrear.classList.add('btn');
                    botonCrear.classList.add('btn-success');
                    botonCrear.classList.add('btn-lg');
                    botonCrear.classList.add('btn-block');
                    botonCrear.textContent = 'Añadir Curso';
                    botonCrear.addEventListener('click', function() {
                        anadircursoformulario();
                    });
                var botonactualizar = document.createElement('button');
                botonactualizar.classList.add('btn');
                botonactualizar.classList.add('btn-info');
                botonactualizar.classList.add('btn-lg');
                botonactualizar.classList.add('btn-block');
                botonactualizar.textContent = 'Actualizar un curso';
                botonactualizar.addEventListener('click', function() {
                    actualizarcursoformulario();
                });
                var div = document.createElement('div');
                div.classList.add('text-center');
                div.appendChild(tabla);
                div.appendChild(botonCrear);
                div.appendChild(botonactualizar);
                principal.appendChild(div);
            }
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener Cursos:', xhr.status);
        }
    };
    xhr.send();
}


function anadircursoformulario(){
    window.location.href = "../vista/formulariocurso.php";
}


function anadircurso(){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Curso creado exitosamente") {
                alert("Curso creado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al crear el curso");
            }
        }
    }
    var nombre = document.getElementById("nombre_curso").value;
    var descripcion = document.getElementById("descripcion_curso").value;
    var estado = document.getElementById("estado_curso").value;
    var aforo = document.getElementById("aforo_curso").value;
    var fecha_inicio = document.getElementById("fecha_inicio_curso").value;
    var fecha_final = document.getElementById("fecha_final_curso").value;
    var horario = document.getElementById("horario_curso").value;
    var precio = document.getElementById("precio_curso").value;
    var datos = [nombre, descripcion, estado, aforo, horario, precio];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="nombre="+ nombre + " & descripcion=" + descripcion + " & estado=" + estado + " & aforo=" + aforo + " & fecha_inicio=" + fecha_inicio + " & fecha_final=" + fecha_final + " & horario=" + horario + " & precio=" + precio;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/curso/anadircurso';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

function verCurso(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';

            var tabla = document.createElement('table');
            tabla.classList.add('table');
            tabla.classList.add('table-success');
            var cabecera = document.createElement('thead');
            var cabeceraFila = document.createElement('tr');
            var cabeceraID = document.createElement('th');
            cabeceraID.textContent = 'ID';
            var cabeceraNombre = document.createElement('th');
            cabeceraNombre.textContent = 'Nombre Evento';
            var cabeceraDescripcion = document.createElement('th');
            cabeceraDescripcion.textContent = 'Descripción';
            var cabeceraEstado = document.createElement('th');
            cabeceraEstado.textContent = 'Estado';
            var cabeceraaforo = document.createElement('th');
            cabeceraaforo.textContent = 'Aforo';
            var cabeceraFechaInicio = document.createElement('th');
            cabeceraFechaInicio.textContent = 'Fecha de inicio';
            var cabeceraFechaFinal = document.createElement('th');
            cabeceraFechaFinal.textContent = 'Fecha de finalización';
            var cabeceraDuracion = document.createElement('th');
            cabeceraDuracion.textContent = 'Horario';
            var cabeceraPrecio = document.createElement('th');
            cabeceraPrecio.textContent = 'Precio';
            cabeceraFila.appendChild(cabeceraID);
            cabeceraFila.appendChild(cabeceraNombre);
            cabeceraFila.appendChild(cabeceraDescripcion);
            cabeceraFila.appendChild(cabeceraEstado);
            cabeceraFila.appendChild(cabeceraaforo);
            cabeceraFila.appendChild(cabeceraFechaInicio);
            cabeceraFila.appendChild(cabeceraFechaFinal);
            cabeceraFila.appendChild(cabeceraDuracion);
            cabeceraFila.appendChild(cabeceraPrecio);

            cabecera.appendChild(cabeceraFila);
            tabla.appendChild(cabecera);

            var cuerpo = document.createElement('tbody');
            response.forEach(function (curso) {
                var fila = document.createElement('tr');

                var columnaID = document.createElement('td');
                columnaID.textContent = curso.id;

                var columnaNombre = document.createElement('td');
                columnaNombre.textContent = curso.nombre_curso;

                var columnaDescripcion = document.createElement('td');
                columnaDescripcion.textContent = curso.descripcion;

                var columnaEstado = document.createElement('td');
                columnaEstado.textContent = curso.estado;

                var columnaAforo = document.createElement('td');
                columnaAforo.textContent = curso.aforo_max;

                var columnaFechaInicio = document.createElement('td');
                columnaFechaInicio.textContent = curso.fecha_inicio;

                var columnaFechaFinal = document.createElement('td');
                columnaFechaFinal.textContent = curso.fecha_final;

                var columnaDuracion = document.createElement('td');
                columnaDuracion.textContent = curso.horario;

                var columnaPrecio = document.createElement('td');
                columnaPrecio.textContent = curso.precio + "€";

                fila.appendChild(columnaID);
                fila.appendChild(columnaNombre);
                fila.appendChild(columnaDescripcion);
                fila.appendChild(columnaEstado);
                fila.appendChild(columnaAforo);
                fila.appendChild(columnaFechaInicio);
                fila.appendChild(columnaFechaFinal);
                fila.appendChild(columnaDuracion);
                fila.appendChild(columnaPrecio);

                cuerpo.appendChild(fila);
            });
            tabla.appendChild(cuerpo);

            principal.appendChild(tabla);
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el evento:', xhr.status);
        }
    }
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/curso/obtenerCursoID?id=' + id, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    return false;
}

function actualizarcursoformulario(){
    window.location.href = "../vista/actualizarcurso.php";
}

function actualizarCurso() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Curso actualizado") {
                alert("Curso actualizado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al actualizar el Curso");
            }
        }
    }
    var id = document.getElementById("id_curso").value;
    var nombre = document.getElementById("nombre_curso").value;
    var descripcion = document.getElementById("descripcion_curso").value;
    var estado = document.getElementById("estado_curso").value;
    var aforo = document.getElementById("aforo_curso").value;
    var fecha_inicio = document.getElementById("fecha_inicio_curso").value;
    var fecha_final = document.getElementById("fecha_final_curso").value;
    var horario = document.getElementById("horario_curso").value;
    var precio = document.getElementById("precio_curso").value;
    var datos = [nombre, descripcion, estado, aforo, horario, precio];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="id="+ id + " & nombre="+ nombre + " & descripcion=" + descripcion + " & estado=" + estado + " & aforo=" + aforo + " & fecha_inicio=" + fecha_inicio + " & fecha_final=" + fecha_final + " & horario=" + horario + " & precio=" + precio;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/curso/actualizarCurso';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

function borrarCurso(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var respuesta = JSON.parse(this.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            alert('curso eliminado con éxito');
            obtenercursos();
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el curso:', xhr.status);
        }
    }
    var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/curso/eliminarCursoID?id=' + id;
    xhr.open('DELETE', url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
}

//talleres

function obtenertalleres() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/taller', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            if(response.mensaje == "No hay talleres"){
                var div = document.createElement('div');
                var br = document.createElement('br');
                div.classList.add('text-center');
                var botonCrear = document.createElement('button');
                botonCrear.classList.add('btn');
                botonCrear.classList.add('btn-success');
                botonCrear.classList.add('btn-lg');
                botonCrear.classList.add('btn-block');
                botonCrear.textContent = 'Añadir taller';
                botonCrear.addEventListener('click', function() {
                    anadirtallerformulario();
                });
                div.appendChild(botonCrear);
                principal.appendChild(br);
                principal.appendChild(div);
            } else{
                response.sort(function(a, b) {
                    return new Date(a.fecha) - new Date(b.fecha);
                });
                var tabla = document.createElement('table');
                tabla.classList.add('table');
                tabla.classList.add('table-warning');
                var cabecera = document.createElement('thead');
                var cabeceraFila = document.createElement('tr');
                var cabeceraID = document.createElement('th');
                cabeceraID.textContent = 'ID';
                var cabeceraNombre = document.createElement('th');
                cabeceraNombre.textContent = 'Nombre Taller';
                var cabeceraFecha = document.createElement('th');
                cabeceraFecha.textContent = 'Fecha';
                var cabeceraAcciones = document.createElement('th');
                cabeceraAcciones.textContent = 'Acciones';
                cabeceraFila.appendChild(cabeceraID);
                cabeceraFila.appendChild(cabeceraNombre);
                cabeceraFila.appendChild(cabeceraFecha);
                cabeceraFila.appendChild(cabeceraAcciones);
                cabecera.appendChild(cabeceraFila);
                tabla.appendChild(cabecera);

                var cuerpo = document.createElement('tbody');
                response.forEach(function (taller) {
                    var fila = document.createElement('tr');
                    var columnaID = document.createElement('td');
                    columnaID.textContent = taller.id;
                    var columnaNombre = document.createElement('td');
                    columnaNombre.textContent = taller.nombre_taller;
                    var columnaFecha = document.createElement('td');
                    columnaFecha.textContent = taller.fecha;
                    fila.appendChild(columnaID);
                    fila.appendChild(columnaNombre);
                    fila.appendChild(columnaFecha);

                    var columnaAcciones = document.createElement('td');
                    var botonVer = document.createElement('button');
                    botonVer.classList.add('btn');
                    botonVer.classList.add('btn-primary');
                    botonVer.textContent = 'Ver';
                    botonVer.addEventListener('click', function() {
                        verTaller(taller.id);
                    });
                    columnaAcciones.appendChild(botonVer);

                    var botonBorrar = document.createElement('button');
                    botonBorrar.classList.add('btn');
                    botonBorrar.classList.add('btn-danger');
                    botonBorrar.textContent = 'Eliminar';
                    botonBorrar.addEventListener('click', function() {
                        borrarTaller(taller.id);
                    });
                    columnaAcciones.appendChild(botonBorrar);

                    fila.appendChild(columnaAcciones);
                    cuerpo.appendChild(fila);
                });
                tabla.appendChild(cuerpo);
                var botonCrear = document.createElement('button');
                    botonCrear.classList.add('btn');
                    botonCrear.classList.add('btn-success');
                    botonCrear.classList.add('btn-lg');
                    botonCrear.classList.add('btn-block');
                    botonCrear.textContent = 'Añadir Taller';
                    botonCrear.addEventListener('click', function() {
                        anadirtallerformulario();
                    });
                var botonactualizar = document.createElement('button');
                botonactualizar.classList.add('btn');
                botonactualizar.classList.add('btn-info');
                botonactualizar.classList.add('btn-lg');
                botonactualizar.classList.add('btn-block');
                botonactualizar.textContent = 'Actualizar un taller';
                botonactualizar.addEventListener('click', function() {
                    actualizartallerformulario();
                });
                var div = document.createElement('div');
                div.classList.add('text-center');
                div.appendChild(tabla);
                div.appendChild(botonCrear);
                div.appendChild(botonactualizar);
                principal.appendChild(div);
            }
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener talleres:', xhr.status);
        }
    };
    xhr.send();
}

function anadirtallerformulario(){
    window.location.href = "../vista/formulariotaller.php";
}

function anadirtaller(){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Taller creado exitosamente") {
                alert("Taller creado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al crear el taller");
            }
        }
    }
    var nombre = document.getElementById("nombre_taller").value;
    var descripcion = document.getElementById("descripcion_taller").value;
    var aforo = document.getElementById("aforo_taller").value;
    var fecha = document.getElementById("fecha_taller").value;
    var duracion = document.getElementById("duracion_taller").value;
    var precio = document.getElementById("precio_taller").value;
    var datos = [nombre, descripcion, aforo, duracion, precio];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="nombre="+ nombre + " & descripcion=" + descripcion + " & aforo=" + aforo + " & fecha=" + fecha + " & duracion=" + duracion + " & precio=" + precio;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/taller/anadirtaller';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

function verTaller(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';

            var tabla = document.createElement('table');
            tabla.classList.add('table');
            tabla.classList.add('table-warning');
            var cabecera = document.createElement('thead');
            var cabeceraFila = document.createElement('tr');
            var cabeceraID = document.createElement('th');
            cabeceraID.textContent = 'ID';
            var cabeceraNombre = document.createElement('th');
            cabeceraNombre.textContent = 'Nombre Taller';
            var cabeceraDescripcion = document.createElement('th');
            cabeceraDescripcion.textContent = 'Descripción';
            var cabeceraaforo = document.createElement('th');
            cabeceraaforo.textContent = 'Aforo';
            var cabeceraFecha = document.createElement('th');
            cabeceraFecha.textContent = 'Fecha';
            var cabeceraDuracion = document.createElement('th');
            cabeceraDuracion.textContent = 'Duración';
            var cabeceraPrecio = document.createElement('th');
            cabeceraPrecio.textContent = 'Precio';
            cabeceraFila.appendChild(cabeceraID);
            cabeceraFila.appendChild(cabeceraNombre);
            cabeceraFila.appendChild(cabeceraDescripcion);
            cabeceraFila.appendChild(cabeceraaforo);
            cabeceraFila.appendChild(cabeceraFecha);
            cabeceraFila.appendChild(cabeceraDuracion);
            cabeceraFila.appendChild(cabeceraPrecio);

            cabecera.appendChild(cabeceraFila);
            tabla.appendChild(cabecera);

            var cuerpo = document.createElement('tbody');
            response.forEach(function (taller) {
                var fila = document.createElement('tr');

                var columnaID = document.createElement('td');
                columnaID.textContent = taller.id;

                var columnaNombre = document.createElement('td');
                columnaNombre.textContent = taller.nombre_taller;

                var columnaDescripcion = document.createElement('td');
                columnaDescripcion.textContent = taller.descripcion;

                var columnaAforo = document.createElement('td');
                columnaAforo.textContent = taller.aforo_max;

                var columnaFecha = document.createElement('td');
                columnaFecha.textContent = taller.fecha;

                var columnaDuracion = document.createElement('td');
                columnaDuracion.textContent = taller.duracion;

                var columnaPrecio = document.createElement('td');
                columnaPrecio.textContent = taller.precio + "€";

                fila.appendChild(columnaID);
                fila.appendChild(columnaNombre);
                fila.appendChild(columnaDescripcion);
                fila.appendChild(columnaAforo);
                fila.appendChild(columnaFecha);
                fila.appendChild(columnaDuracion);
                fila.appendChild(columnaPrecio);

                cuerpo.appendChild(fila);
            });
            tabla.appendChild(cuerpo);

            principal.appendChild(tabla);
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el evento:', xhr.status);
        }
    }
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/taller/obtenerTallerID?id=' + id, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    return false;
}

function actualizartallerformulario(){
    window.location.href = "../vista/actualizartaller.php";
}

function actualizarTaller(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Taller actualizado") {
                alert("Taller actualizado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al actualizar el Taller");
            }
        }
    }
    var id = document.getElementById("id_taller").value;
    var nombre = document.getElementById("nombre_taller").value;
    var descripcion = document.getElementById("descripcion_taller").value;
    var aforo = document.getElementById("aforo_taller").value;
    var fecha = document.getElementById("fecha_taller").value;
    var duracion = document.getElementById("duracion_taller").value;
    var precio = document.getElementById("precio_taller").value;
    var datos = [nombre, descripcion, aforo, duracion, precio];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="id="+ id + "& nombre="+ nombre + " & descripcion=" + descripcion + " & aforo=" + aforo + " & fecha=" + fecha + " & duracion=" + duracion + " & precio=" + precio;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/taller/actualizartaller';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

function borrarTaller(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var respuesta = JSON.parse(this.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            alert('taller eliminado con éxito');
            obtenertalleres();
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el taller:', xhr.status);
        }
    }
    var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/taller/eliminarTallerID?id=' + id;
    xhr.open('DELETE', url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
}

//proyectos

function obtenerproyectos() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/proyecto_alejandro_vega/BD/api.php/proyecto', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            if(response.mensaje == "No hay proyectos"){
                var div = document.createElement('div');
                var br = document.createElement('br');
                div.classList.add('text-center');
                var botonCrear = document.createElement('button');
                botonCrear.classList.add('btn');
                botonCrear.classList.add('btn-success');
                botonCrear.classList.add('btn-lg');
                botonCrear.classList.add('btn-block');
                botonCrear.textContent = 'Añadir Proyecto';
                botonCrear.addEventListener('click', function() {
                    anadirproyectoformulario();
                });
                div.appendChild(botonCrear);
                principal.appendChild(br);
                principal.appendChild(div);
            } else{
                var tabla = document.createElement('table');
                tabla.classList.add('table');
                tabla.classList.add('table-striped');
                var cabecera = document.createElement('thead');
                var cabeceraFila = document.createElement('tr');
                var cabeceraID = document.createElement('th');
                cabeceraID.textContent = 'ID';
                var cabeceraNombre = document.createElement('th');
                cabeceraNombre.textContent = 'Titulo del proyecto';
                var cabeceraDescripcion = document.createElement('th');
                cabeceraDescripcion.textContent = 'Descripción';
                var cabeceraEstado = document.createElement('th');
                cabeceraEstado.textContent = 'Estado';
                var cabeceraTipo = document.createElement('th');
                cabeceraTipo.textContent = 'Tipo';
                var cabeceraAcciones = document.createElement('th');
                cabeceraAcciones.textContent = 'Acciones';
                cabeceraFila.appendChild(cabeceraID);
                cabeceraFila.appendChild(cabeceraNombre);
                cabeceraFila.appendChild(cabeceraDescripcion);
                cabeceraFila.appendChild(cabeceraEstado);
                cabeceraFila.appendChild(cabeceraTipo);
                cabeceraFila.appendChild(cabeceraAcciones);
                cabecera.appendChild(cabeceraFila);
                tabla.appendChild(cabecera);

                var cuerpo = document.createElement('tbody');
                response.forEach(function (proyecto) {
                    var fila = document.createElement('tr');
                    var columnaID = document.createElement('td');
                    columnaID.textContent = proyecto.id;
                    var columnaTitulo = document.createElement('td');
                    columnaTitulo.textContent = proyecto.titulo;
                    var columnaDescripcion = document.createElement('td');
                    columnaDescripcion.textContent = proyecto.descripcion;
                    var columnaEstado = document.createElement('td');
                    columnaEstado.textContent = proyecto.estado;
                    var columnaTipo = document.createElement('td');
                    columnaTipo.textContent = proyecto.tipo;
                    fila.appendChild(columnaID);
                    fila.appendChild(columnaTitulo);
                    fila.appendChild(columnaDescripcion);
                    fila.appendChild(columnaEstado);
                    fila.appendChild(columnaTipo);

                    var columnaAcciones = document.createElement('td');
                    var botonBorrar = document.createElement('button');
                    botonBorrar.classList.add('btn');
                    botonBorrar.classList.add('btn-danger');
                    botonBorrar.textContent = 'Eliminar';
                    botonBorrar.addEventListener('click', function() {
                        borrarproyecto(proyecto.id);
                    });
                    columnaAcciones.appendChild(botonBorrar);
                    fila.appendChild(columnaAcciones);

                    cuerpo.appendChild(fila);
                });
                tabla.appendChild(cuerpo);
                var botonCrear = document.createElement('button');
                    botonCrear.classList.add('btn');
                    botonCrear.classList.add('btn-success');
                    botonCrear.classList.add('btn-lg');
                    botonCrear.classList.add('btn-block');
                    botonCrear.textContent = 'Añadir Proyecto';
                    botonCrear.addEventListener('click', function() {
                        anadirproyectoformulario();
                    });
                var botonactualizar = document.createElement('button');
                botonactualizar.classList.add('btn');
                botonactualizar.classList.add('btn-info');
                botonactualizar.classList.add('btn-lg');
                botonactualizar.classList.add('btn-block');
                botonactualizar.textContent = 'Actualizar un Proyecto';
                botonactualizar.addEventListener('click', function() {
                    actualizarproyectoformulario();
                });
                var div = document.createElement('div');
                div.classList.add('text-center');
                div.appendChild(tabla);
                div.appendChild(botonCrear);
                div.appendChild(botonactualizar);
                principal.appendChild(div);
            }
            } else if (xhr.readyState === 4) {
                console.error('Error al obtener proyectos:', xhr.status);
            }
        };
        xhr.send();
}

function anadirproyectoformulario(){
        window.location.href = "../vista/formularioproyecto.php";
}

function anadirproyecto(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Proyecto creado exitosamente") {
                alert("Proyecto creado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al crear el proyecto");
            }
        }
    }
    var titulo = document.getElementById("titulo_proyecto").value;
    var descripcion = document.getElementById("descripcion_proyecto").value;
    var estado = document.getElementById("estado_proyecto").value;
    var tipo = document.getElementById("tipo_proyecto").value;
    var datos = [titulo, descripcion, estado, tipo];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="titulo="+ titulo + " & descripcion=" + descripcion + " & estado=" + estado + " & tipo=" + tipo;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/proyecto/anadirproyecto';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

function actualizarproyectoformulario(){
    window.location.href = "../vista/actualizarproyecto.php";
}

function actualizarProyecto(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var respuesta = JSON.parse(xhttp.responseText);
            if (respuesta.mensaje == "Proyecto actualizado") {
                alert("Proyecto actualizado con éxito");
                window.location.href = "../vista/principal.php";
            } else {
                alert("Error al actualizar el Proyecto");
            }
        }
    }
    var id = document.getElementById("id_proyecto").value;
    var titulo = document.getElementById("titulo_proyecto").value;
    var descripcion = document.getElementById("descripcion_proyecto").value;
    var estado = document.getElementById("estado_proyecto").value;
    var tipo = document.getElementById("tipo_proyecto").value;
    var datos = [titulo, descripcion, estado, tipo];
    $comprobar = validarDatos(datos);
    if ($comprobar === false){
        return false;
    }else{
        var params ="id="+ id + "& titulo="+ titulo + " & descripcion=" + descripcion + " & estado=" + estado + " & tipo=" + tipo;
        var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/proyecto/actualizarproyecto';
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        return false;
    }
}

function borrarproyecto(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var respuesta = JSON.parse(this.responseText);
            var principal = document.getElementById('principal');
            principal.innerHTML = '';
            alert('Proyecto eliminado con éxito');
            obtenertalleres();
        } else if (xhr.readyState === 4) {
            console.error('Error al obtener el proyecto:', xhr.status);
        }
    }
    var url = 'http://localhost/proyecto_alejandro_vega/BD/api.php/proyecto/eliminarProyectoID?id=' + id;
    xhr.open('DELETE', url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
}

function volver(){
    window.location.href = "../vista/principal.php";
}