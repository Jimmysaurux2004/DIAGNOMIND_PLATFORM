// ====== TOGGLE MENU: Adaptado a DiagnoMind
function toggleMenu() {
    const menu = document.getElementById("offcanvasScrolling");
    const isSmallScreen = window.innerWidth < 992;

    if (isSmallScreen) {
        menu.classList.toggle("open");
    } else {
        menu.classList.toggle("fixed");
        document.body.classList.toggle("menu-open", menu.classList.contains("fixed"));
    }
}

function initializeMenu() {
    const menu = document.getElementById("offcanvasScrolling");
    menu.classList.remove("open", "fixed");
}

// Cierra el menú lateral y de usuario si haces clic fuera
document.addEventListener("click", function(event) {
    const menu = document.getElementById("offcanvasScrolling");
    const button = document.querySelector(".btn-toggle-menu");
    const userMenu = document.getElementById('userMenu');
    const userButton = document.getElementById('userDropdown');

    if (window.innerWidth < 992 && menu.classList.contains("open") && !menu.contains(event.target) && !button.contains(event.target)) {
        menu.classList.remove("open");
    }

    if (!userButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.remove('active');
    }
});

function toggleUserMenu(event) {
    event.stopPropagation();
    document.getElementById('userMenu').classList.toggle('active');
}

window.addEventListener("resize", initializeMenu);

// ====== CARGA DE VISTAS DINÁMICAS PARA MÉDICO ======
function guardarContenidoEnLocalStorage(html, vista) {
    localStorage.setItem("contenidoDinamico", html);
    if (vista) {
        localStorage.setItem("vistaActual", vista);
    }
}

function cargarDesdeLocalStorage() {
    const vista = localStorage.getItem("vistaActual");
    switch (vista) {
        case "inicio":
            cargarVistaInicioMedico(); break;
        case "misPacientes":
            cargarFormularioMisPacientes(); break;
        case "reporteGeneral":
            cargarFormularioReporteGeneral(); break;
        default:
            cargarVistaInicioMedico(); // por defecto
    }
}

// Cargar inicio
function cargarVistaInicioMedico() {
    verificarSesion(() => {
        $("#contenido-dinamico").load("../../views/dashboard/principalMedico.php", function() {
            guardarContenidoEnLocalStorage($("#contenido-dinamico").html(), "inicio");
        });
    });
}

function cargarFormularioMisPacientes() {
    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/seguimientoPacientes/controlFormSeguimientoPacientes.php",
            dataType: "json",
            success: function(response) {
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "misPacientes");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el formulario de pacientes:", error);
            }
        });
    });
}

function cargarFormularioReporteGeneral() {
    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/reporteGeneral/controlFormReporteGeneral.php",
            dataType: "json",
            success: function(response) {
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "reporteGeneral");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el formulario de pacientes:", error);
            }
        });
    });
}

// Botón cerrar sesión
document.getElementById("cerrarSesion")?.addEventListener("click", function () {
    localStorage.removeItem("contenidoDinamico");
    localStorage.removeItem("vistaActual");
});

// Verificar sesión
function verificarSesion(callback) {
    fetch("../../utils/verificarSesionMedico.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "active") {
                if (typeof callback === "function") callback();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sesión cerrada',
                    text: 'Tu sesión ha expirado o fue cerrada.',
                    confirmButtonColor: '#981e25'
                }).then(() => {
                    window.location.href = "../../index.php";
                });
            }
        })
        .catch(() => {
            window.location.href = "../../index.php";
        });
}

// Inicia cargando la vista desde localStorage si aplica
cargarDesdeLocalStorage();
