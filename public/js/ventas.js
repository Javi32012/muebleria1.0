document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalVenta");
    const btnAgregar = document.getElementById("agregarVenta");
    const btnCerrar = document.querySelector(".cerrar");
    const formVenta = document.getElementById("formVenta");

    async function cargarVentas() {
        try {
            const respuesta = await fetch('http://localhost/HTML/Muebleria1.0/backend/models/listar_ventas.php');
    
            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }
    
            const datos = await respuesta.json();
            console.log("Datos recibidos:", datos);
    
            const tablaVentas = document.getElementById("tablaVentas");
            tablaVentas.innerHTML = ""; // Limpiar la tabla antes de insertar
    
            datos.forEach(venta => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${venta.id_orden}</td>
                    <td>${venta.cliente}</td>
                    <td>${venta.total}</td>
                    <td>${venta.fecha}</td>
                    <td>
                        <ul>
                            ${venta.detalles.map(detalle => `
                                <li>${detalle.mueble} - ${detalle.cantidad} unidades - Subtotal: $${detalle.subtotal}</li>
                            `).join('')}
                        </ul>
                    </td>
                `;
                tablaVentas.appendChild(fila);
            });
    
        } catch (error) {
            console.error("Error al cargar ventas:", error);
        }
    }
    
    document.addEventListener("DOMContentLoaded", cargarVentas);
    
    function agregarVenta(event) {
        event.preventDefault();
        const cliente = document.getElementById("cliente").value;
        const mueble = document.getElementById("mueble").value;
        const cantidad = document.getElementById("cantidad").value;
        const total = document.getElementById("total").value;

        const ventaData = { cliente, mueble, cantidad, total };

        fetch("http://localhost/HTML/Muebleria1.0/backend/models/agregar_venta.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(ventaData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                modal.style.display = "none";
                cargarVentas();
            }
        })
        .catch(error => console.error("Error al agregar venta:", error));
    }

    function eliminarVenta(id) {
        fetch("http://localhost/HTML/Muebleria1.0/backend/models/eliminar_venta.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
        .then(response => response.text())
        .then(data => {
            console.log("Venta eliminada:", data);
            cargarVentas();
        })
        .catch(error => console.error("Error al eliminar venta:", error));
    }

    btnAgregar.addEventListener("click", () => {
        modal.style.display = "block";
    });

    btnCerrar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    formVenta.addEventListener("submit", agregarVenta);
    cargarVentas();
});