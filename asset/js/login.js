// Mostrar/ocultar clave del paciente
document.getElementById("toggleClavePaciente")?.addEventListener("click", () => {
    const input = document.getElementById("clavePaciente");
    const icon = document.getElementById("toggleClavePaciente").querySelector("i");
    const visible = input.type === "password";
    input.type = visible ? "text" : "password";
    icon.className = visible ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
});

// Mostrar/ocultar clave del médico
document.getElementById("toggleClaveMedico")?.addEventListener("click", () => {
    const input = document.getElementById("claveMedico");
    const icon = document.getElementById("toggleClaveMedico").querySelector("i");
    const visible = input.type === "password";
    input.type = visible ? "text" : "password";
    icon.className = visible ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
});

// Validar campos comunes
function validarCampo(idCampo, idError) {
    const campo = document.getElementById(idCampo);
    const error = document.getElementById(idError);
    if (!campo || !error) return false;

    const valor = campo.value.trim();
    if (valor === "") {
        error.textContent = "Este campo es obligatorio.";
        error.style.display = "block";
        return false;
    }

    error.textContent = "";
    error.style.display = "none";
    return true;
}

// Enviar login paciente
function enviarLoginPaciente() {
    const usuarioOk = validarCampo("usuarioPaciente", "usuarioPacienteError");
    const claveOk = validarCampo("clavePaciente", "clavePacienteError");

    if (!usuarioOk || !claveOk) return;

    const usuario = document.getElementById("usuarioPaciente").value.trim();
    const clave = document.getElementById("clavePaciente").value.trim();

    $.ajax({
        type: "POST",
        url: "./controllers/autenticarUsuario/controlAutenticarUsuario.php",
        data: {
            usuario: usuario,
            contrasena: clave,
            btnLogin: "AccederComoPaciente"
        },
        dataType: "json",
        success: function (response) {
            if (response.flag == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Bienvenido",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => window.location.href = response.redirect);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.message || "Credenciales inválidas."
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud: " + error
            });
        }
    });
}

// Enviar login médico
function enviarLoginMedico() {
    const usuarioOk = validarCampo("usuarioMedico", "usuarioMedicoError");
    const claveOk = validarCampo("claveMedico", "claveMedicoError");

    if (!usuarioOk || !claveOk) return;

    const usuario = document.getElementById("usuarioMedico").value.trim();
    const clave = document.getElementById("claveMedico").value.trim();

    $.ajax({
        type: "POST",
        url: "./controllers/autenticarUsuario/controlAutenticarUsuario.php",
        data: {
            usuario: usuario,
            contrasena: clave,
            btnLogin: "AccederComoMedico"
        },
        dataType: "json",
        success: function (response) {
            if (response.flag == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Bienvenido",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => window.location.href = response.redirect);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.message || "Credenciales inválidas."
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud: " + error
            });
        }
    });
}
