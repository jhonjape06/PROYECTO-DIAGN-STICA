
document.addEventListener("DOMContentLoaded", function() {
    const checkboxMostrarContraseña = document.querySelector(".checkbox_most_ctr");
    const contraseñaInput = document.querySelector(".controls2");
    const formLogin = document.getElementById("formLogin");
    const usuarioInput = document.querySelector(".controls1");

    checkboxMostrarContraseña.addEventListener("change", function() {
        if (checkboxMostrarContraseña.checked) {
            contraseñaInput.type = "text";
        } else {
            contraseñaInput.type = "password";
        }
    });
});

