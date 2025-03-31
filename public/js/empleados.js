document.addEventListener('DOMContentLoaded', () => {
    const tablaEmpleados = document.getElementById('tablaEmpleados');
    const modalEmpleado = document.getElementById('modalEmpleado');
    const formEmpleado = document.getElementById('formEmpleado');
    const tituloModal = document.getElementById('tituloModal');
    const agregarEmpleadoBtn = document.getElementById('agregarEmpleado');

    // Función para obtener la lista de empleados
    function obtenerEmpleados() {
        fetch('empleados.php')
            .then(response => response.json())
            .then(data => {
                tablaEmpleados.innerHTML = '';
                data.forEach(empleado => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${empleado.id}</td>
                        <td>${empleado.nombre}</td>
                        <td>${empleado.puesto}</td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.telefono}</td>
                        <td>
                            <button onclick="editarEmpleado(${empleado.id})">Editar</button>
                            <button onclick="eliminarEmpleado(${empleado.id})">Eliminar</button>
                        </td>
                    `;
                    tablaEmpleados.appendChild(row);
                });
            });
    }

    // Función para abrir el modal en modo agregar
    agregarEmpleadoBtn.addEventListener('click', () => {
        tituloModal.textContent = 'Agregar Empleado';
        formEmpleado.reset();
        modalEmpleado.style.display = 'flex';
    });

    // Función para editar un empleado
    window.editarEmpleado = function(id) {
        fetch(`empleados.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id_empleado').value = data.id;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('puesto').value = data.puesto;
                document.getElementById('correo').value = data.correo;
                document.getElementById('telefono').value = data.telefono;
                tituloModal.textContent = 'Editar Empleado';
                modalEmpleado.style.display = 'flex';
            });
    };

    // Función para eliminar un empleado
    window.eliminarEmpleado = function(id) {
        if (confirm('¿Estás seguro de eliminar este empleado?')) {
            fetch(`empleados.php?id=${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(() => {
                    obtenerEmpleados();
                });
        }
    };

    // Manejar el envío del formulario
    formEmpleado.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(formEmpleado);
        fetch('empleados.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(() => {
                obtenerEmpleados();
                modalEmpleado.style.display = 'none';
            });
    });

    // Cerrar el modal
    document.querySelector('.cerrar').addEventListener('click', () => {
        modalEmpleado.style.display = 'none';
    });

    // Cerrar el modal si se hace clic fuera de él
    window.addEventListener('click', (e) => {
        if (e.target === modalEmpleado) {
            modalEmpleado.style.display = 'none';
        }
    });

    // Obtener la lista de empleados al cargar la página
    obtenerEmpleados();
});
