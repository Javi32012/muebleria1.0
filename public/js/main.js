document.addEventListener("DOMContentLoaded", () => {
    console.log("Página cargada");
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const usuario = document.getElementById("usuario").value;
            const password = document.getElementById("password").value;
            
            // Simulación de autenticación
            if (usuario === "admin" && password === "1234") {
                alert("Ingreso exitoso");
                window.location.href = "dashboard.html";
            } else {
                alert("Usuario o contraseña incorrectos");
            }
        });
    }
});