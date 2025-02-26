document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalCliente");
    const btnAgregar = document.getElementById("agregarCliente");
    const btnCerrar = document.querySelector(".cerrar");
    const formCliente = document.getElementById("formCliente");

    function cargarClientes() {
        //fetch("../../backend/models/Cliente.php")
        fetch("http://localhost/HTML/Muebleria1.0/backend/models/Cliente.php")
            .then(response => response.json())
            .then(data => {
                console.log("Datos recibidos:", data); // Agrega este log para ver la respuesta
                const tabla = document.getElementById("tablaClientes");
                tabla.innerHTML = "";
                data.forEach(cliente => {
                    const fila = document.createElement("tr");
                    fila.innerHTML = `
                <td>${cliente.id_cliente}</td>
                <td>${cliente.nombre}</td>
                <td>${cliente.email}</td>
                <td>${cliente.telefono}</td>
                <td>${cliente.direccion}</td>
                <td><button class="btn-eliminar" data-id="${cliente.id_cliente}">Eliminar</button></td>
            `;
                    tabla.appendChild(fila);
                });
                // Agregar evento a los botones de eliminar
                document.querySelectorAll(".btn-eliminar").forEach(boton => {
                    boton.addEventListener("click", () => {
                        eliminarCliente(boton.dataset.id);
                    });
                });
            })
            .catch(error => console.error("Error al cargar clientes:", error));
    }

    function eliminarCliente(id) {
        //fetch("../../backend/models/eliminar_cliente.php", {
        fetch("http://localhost/HTML/Muebleria1.0/backend/models/eliminar_cliente.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
            .then(response => response.text())
            .then(data => {
                console.log("Cliente eliminado:", data);
                cargarClientes();
            })
            .catch(error => console.error("Error al eliminar cliente:", error));
    }


    function agregarCliente(event) {
        event.preventDefault();
        const nombre = document.getElementById("nombre").value;
        const email = document.getElementById("email").value;
        const telefono = document.getElementById("telefono").value;
        const direccion = document.getElementById("direccion").value;
    
        const clienteData = { nombre, email, telefono, direccion };
        console.log("Enviando datos:", clienteData); // Verifica que los datos sean correctos
    
        fetch("http://localhost/HTML/Muebleria1.0/backend/models/agregar_cliente.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(clienteData)
        })
        .then(response => response.json())
        .then(data => {
            console.log("Cliente agregado:", data);
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                modal.style.display = "none";
                cargarClientes();
            }
        })
        .catch(error => console.error("Error al agregar cliente:", error));
    }
    

    btnAgregar.addEventListener("click", () => {
        modal.style.display = "block";
    });

    btnCerrar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    formCliente.addEventListener("submit", agregarCliente);
    cargarClientes();
});