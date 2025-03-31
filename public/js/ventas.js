document.addEventListener("DOMContentLoaded", function () {
    cargarClientes();
    cargarMuebles();
    cargarVentas(); 
});

function cargarClientes() {
    fetch("http://localhost/HTML/Muebleria1.0/backend/models/listar_clientes.php")
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("id_cliente");
            data.forEach(cliente => {
                let option = document.createElement("option");
                option.value = cliente.id_cliente;
                option.textContent = cliente.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar clientes:", error));
}

function cargarMuebles() {
    fetch("http://localhost/HTML/Muebleria1.0/backend/models/listar_muebles.php")
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("id_mueble");
            data.forEach(mueble => {
                let option = document.createElement("option");
                option.value = mueble.id_mueble;
                option.textContent = `${mueble.nombre} - $${mueble.precio}`;
                option.dataset.precio = mueble.precio; // Guardamos el precio en el dataset
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar muebles:", error));
}

// Lógica para agregar muebles a la orden
let mueblesOrden = [];
document.getElementById("agregarMueble").addEventListener("click", function () {
    const selectMueble = document.getElementById("id_mueble");
    const cantidad = document.getElementById("cantidad").value;
    const idMueble = selectMueble.value;
    const nombreMueble = selectMueble.options[selectMueble.selectedIndex].text;
    const precio = parseFloat(selectMueble.options[selectMueble.selectedIndex].dataset.precio);
    
    if (!idMueble || cantidad <= 0) {
        alert("Seleccione un mueble y una cantidad válida.");
        return;
    }

    const subtotal = cantidad * precio;
    mueblesOrden.push({ id_mueble: idMueble, cantidad, subtotal });

    const lista = document.getElementById("listaMuebles");
    const item = document.createElement("li");
    item.textContent = `${nombreMueble} - Cantidad: ${cantidad} - Subtotal: $${subtotal.toFixed(2)}`;
    lista.appendChild(item);
});

// Enviar la venta al backend
document.getElementById("formVenta").addEventListener("submit", function (e) {
    e.preventDefault();

    const idCliente = document.getElementById("id_cliente").value;
    if (!idCliente || mueblesOrden.length === 0) {
        alert("Seleccione un cliente y al menos un mueble.");
        return;
    }

    fetch("http://localhost/HTML/Muebleria1.0/backend/models/agregar_venta.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_cliente: idCliente, muebles: mueblesOrden })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Error: " + data.error);
        } else {
            alert("Venta registrada con éxito.");
            location.reload();
        }
    })
    .catch(error => console.error("Error al registrar venta:", error));
});

function cargarVentas() {
    fetch("http://localhost/HTML/Muebleria1.0/backend/models/listar_ventas.php")
        .then(response => response.json())
        .then(data => {
            console.log("Ventas cargadas:", data); // Verifica qué los datos se estan recibiendo
            const tbody = document.getElementById("tablaVentas").querySelector("tbody");
            tbody.innerHTML = ""; // Limpiar tabla
            console.log("Ventas cargadas:", data);

            data.forEach(venta => {
                let total = parseFloat(venta.total) || 0; // Asegurar que sea número
                let fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${venta.id_orden}</td>
                    <td>${venta.cliente}</td>
                    <td>${venta.fecha}</td>
                    <td>$${total.toFixed(2)}</td> 
                    <td>
                        <button  "id="buttonDetalles" onclick="verDetalles(${venta.id_orden})">Detalles</button>
                    </td>
                `;
                tbody.appendChild(fila);
            });
        })
        .catch(error => console.error("Error al cargar ventas:", error));
}


function verDetalles(id_orden) {
    fetch(`http://localhost/HTML/Muebleria1.0/backend/models/listar_detalles.php?id_orden=${id_orden}`)
        .then(response => response.json())
        .then(data => {
            console.log("Detalles cargados:", data);
            const listaDetalles = document.getElementById("listaDetalles");
            const detallesVenta = document.getElementById("detallesVenta");

            if (!listaDetalles || !detallesVenta) {
                console.error("Error: No se encontró el elemento en el HTML.");
                return;
            }

            listaDetalles.innerHTML = "";

            data.forEach(detalle => {
                let subtotal = parseFloat(detalle.subtotal) || 0; 
                let item = document.createElement("li");
                item.textContent = `${detalle.mueble} - Cantidad: ${detalle.cantidad} - Subtotal: $${subtotal.toFixed(2)}`;
                listaDetalles.appendChild(item);
            });

            detallesVenta.style.display = "block";
        })
        .catch(error => console.error("Error al cargar detalles:", error));
}

function cerrarDetalles() {
    document.getElementById("detallesVenta").style.display = "none";
}