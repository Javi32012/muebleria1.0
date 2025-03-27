document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalMueble");
    const btnAgregar = document.getElementById("agregarMueble");
    const btnCerrar = document.querySelector(".cerrar");
    const formMueble = document.getElementById("formMueble");

    function cargarMuebles() {
        fetch("http://localhost/HTML/Muebleria1.0/backend/models/Mueble.php")
            .then(response => response.json())
            .then(data => {
                console.log("Datos recibidos:", data);
                const tabla = document.getElementById("tablaMuebles");
                tabla.innerHTML = "";
                data.forEach(mueble => {
                    const fila = document.createElement("tr");
                    fila.innerHTML = `
                        <td>${mueble.id_mueble}</td>
                        <td>${mueble.nombre}</td>
                        <td>${mueble.descripcion}</td>
                        <td>$${mueble.precio}</td>
                        <td>${mueble.stock}</td>
                        <td>
                            <button class="btn-eliminar" data-id="${mueble.id_mueble}">Eliminar</button>
                        </td>
                    `;
                    tabla.appendChild(fila);
                });

                // Agregar evento a los botones de eliminar
                document.querySelectorAll(".btn-eliminar").forEach(boton => {
                    boton.addEventListener("click", () => {
                        eliminarMueble(boton.dataset.id);
                    });
                });
            })
            .catch(error => console.error("Error al cargar muebles:", error));
    }

    function eliminarMueble(id) {
        fetch("http://localhost/HTML/Muebleria1.0/backend/models/eliminar_mueble.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
        .then(response => response.text())
        .then(data => {
            console.log("Mueble eliminado:", data);
            cargarMuebles();
        })
        .catch(error => console.error("Error al eliminar mueble:", error));
    }

    function agregarMueble(event) {
        event.preventDefault();
        const nombre = document.getElementById("nombre").value;
        const descripcion = document.getElementById("descripcion").value;
        const precio = document.getElementById("precio").value;
        const stock = document.getElementById("stock").value;

        const muebleData = { nombre, descripcion, precio, stock };
        console.log("Enviando datos:", muebleData);

        fetch("http://localhost/HTML/Muebleria1.0/backend/models/agregar_mueble.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(muebleData)
        })
        .then(response => response.json())
        .then(data => {
            console.log("Mueble agregado:", data);
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                modal.style.display = "none";
                cargarMuebles();
            }
        })
        .catch(error => console.error("Error al agregar mueble:", error));
    }

    btnAgregar.addEventListener("click", () => {
        modal.style.display = "block";
    });

    btnCerrar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    formMueble.addEventListener("submit", agregarMueble);
    cargarMuebles();
});
