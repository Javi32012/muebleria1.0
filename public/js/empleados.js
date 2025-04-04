document.addEventListener('DOMContentLoaded', function () {
    const tablaEmpleados = document.getElementById('tablaEmpleados');
    const modalEmpleado = document.getElementById('modalEmpleado');
    const formularioEmpleado = document.getElementById('formEmpleado');
    const cerrarModal = document.getElementsByClassName('cerrar')[0];
    const btnAgregarEmpleado = document.getElementById('agregarEmpleado');

    let editando = false;
    let idEmpleadoActual = null;

    function obtenerEmpleados() {
        fetch('http://localhost/HTML/Muebleria1.0/backend/models/listar_empleados.php')
            .then(response => response.text()) // Primero como texto
            .then(text => {
                console.log("Respuesta cruda del servidor:", text);
                return JSON.parse(text); // luego lo parseas
            })
            .then(data => {
                console.log("Empleados:", data);
                tablaEmpleados.innerHTML = '';
                data.forEach(empleado => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${empleado.id_empleado}</td>
                        <td>${empleado.nombre}</td>
                        <td>${empleado.puesto}</td>
                        <td>${empleado.telefono}</td>
                        <td>${empleado.email}</td>
                        <td>
                            <button class="editar" data-id="${empleado.id_empleado}">Editar</button>
                            <button class="eliminar" data-id="${empleado.id_empleado}">Eliminar</button>
                        </td>
                    `;
                    tablaEmpleados.appendChild(fila);
                });
            })
            .catch(error => console.error('Error al obtener empleados:', error));
    }

    obtenerEmpleados();

    btnAgregarEmpleado.onclick = function () {
        modalEmpleado.style.display = 'block';
        formularioEmpleado.reset();
        editando = false;
    };

    cerrarModal.onclick = function () {
        modalEmpleado.style.display = 'none';
    };

    formularioEmpleado.onsubmit = function (event) {
        event.preventDefault();
    
        const datos = new FormData(formularioEmpleado);
        for (let [key, value] of datos.entries()) {
            console.log(`${key}: ${value}`);
        }
    
        let url = 'http://localhost/HTML/Muebleria1.0/backend/models/agregar_empleado.php';
    
        if (editando) {
            datos.append('id_empleado', idEmpleadoActual);
            url = 'http://localhost/HTML/Muebleria1.0/backend/models/editar_empleado.php';
        }
    
        fetch(url, {
            method: 'POST',
            body: datos
        })
        .then(response => response.text())
        .then(text => {
            console.log("Respuesta del servidor:", text);
            return JSON.parse(text);
        })
        .then(resultado => {
            alert(resultado.mensaje);
            modalEmpleado.style.display = 'none';
            obtenerEmpleados();
        })
        .catch(error => console.error('Error en la operación:', error));        
    };
    

    tablaEmpleados.addEventListener('click', function (event) {
        if (event.target.classList.contains('editar')) {
            idEmpleadoActual = event.target.dataset.id;
            fetch(`http://localhost/HTML/Muebleria1.0/backend/models/obtener_empleado.php?id=${idEmpleadoActual}`)
                .then(response => response.json())
                .then(empleado => {
                    document.getElementById('nombre').value = empleado.nombre;
                    document.getElementById('puesto').value = empleado.puesto;
                    document.getElementById('telefono').value = empleado.telefono;
                    document.getElementById('email').value = empleado.email;
                    modalEmpleado.style.display = 'block';
                    editando = true;
                })
                .catch(error => console.error('Error al obtener datos del empleado:', error));
        }
        if (event.target.classList.contains('eliminar')) {
            const idEmpleado = event.target.dataset.id;
            if (confirm('¿Seguro que deseas eliminar este empleado?')) {
                fetch('http://localhost/HTML/Muebleria1.0/backend/models/eliminar_empleado.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id_empleado=${idEmpleado}`
                })
                .then(response => response.text())
                .then(text => {
                    console.log("Respuesta al eliminar:", text);
                    return JSON.parse(text);
                })
                .then(resultado => {
                    alert(resultado.mensaje);
                    obtenerEmpleados();
                })
                .catch(error => console.error('Error al eliminar empleado:', error));
            }
        }
    });
});