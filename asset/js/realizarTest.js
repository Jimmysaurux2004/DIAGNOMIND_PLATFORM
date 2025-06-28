let indiceActual = 0;
let respuestas = [];

function iniciarTest() {
    document.getElementById("intro-section").style.display = "none";
    document.getElementById("test-section").style.display = "flex";
    respuestas = new Array(SINTOMAS.length).fill(null);
    indiceActual = 0;
    document.getElementById("card-pregunta").style.display = "block";
    document.getElementById("evaluacion-final").style.display = "none";
    mostrarPregunta();
    actualizarProgreso();
}

function mostrarPregunta() {
    document.getElementById("texto-sintoma").textContent = SINTOMAS[indiceActual];
    document.getElementById("contador-pregunta").textContent = `Pregunta ${indiceActual + 1} de ${SINTOMAS.length}`;

    // Limpiar selección previa visual
    document.getElementById("btn-si").classList.remove("seleccionado");
    document.getElementById("btn-no").classList.remove("seleccionado");

    // Marcar si ya fue respondida
    const respuesta = respuestas[indiceActual];
    if (respuesta === 's') {
        document.getElementById("btn-si").classList.add("seleccionado");
    } else if (respuesta === 'n') {
        document.getElementById("btn-no").classList.add("seleccionado");
    }

    actualizarProgreso();
}

function responder(valor) {
    respuestas[indiceActual] = valor;

    // Remover selección previa
    document.getElementById("btn-si").classList.remove("seleccionado");
    document.getElementById("btn-no").classList.remove("seleccionado");

    // Agregar clase al botón presionado
    if (valor === 's') {
        document.getElementById("btn-si").classList.add("seleccionado");
    } else {
        document.getElementById("btn-no").classList.add("seleccionado");
    }
}

function avanzarPregunta() {
    if (respuestas[indiceActual] === null) {
        document.getElementById("mensaje-alerta").textContent = "Por favor, selecciona una respuesta antes de continuar.";
        return;
    } else {
        document.getElementById("mensaje-alerta").textContent = "";
    }

    if (indiceActual < SINTOMAS.length - 1) {
        indiceActual++;
        mostrarPregunta();
    } else {
        // Mostrar evaluación sin recargar nada
        document.getElementById("card-pregunta").style.display = "none";
        document.getElementById("evaluacion-final").style.display = "flex";
    }

    actualizarProgreso();
}

function retrocederPregunta() {
    if (indiceActual > 0) {
        indiceActual--;
        mostrarPregunta();
    }
}

function actualizarProgreso() {
    const total = SINTOMAS.length;
    const respondidas = respuestas.filter(r => r !== null).length;
    const porcentaje = Math.floor((respondidas / total) * 100);
    const barra = document.getElementById("barra-progreso");
    if (barra) barra.style.width = `${porcentaje}%`;

    document.getElementById("resumen-respuestas").textContent = `${respondidas} respondidas`;
    document.getElementById("contador-pregunta").textContent = `Pregunta ${indiceActual + 1} de ${SINTOMAS.length}`;
}

function evaluarDiagnostico() {
    // 'respuestas' debe existir previamente como array con 's' o 'n'
    // Ejemplo: const respuestas = ['s', 'n', 's', ...];

    const sintomasSeleccionados = respuestas
        .map((respuesta, index) => (respuesta === 's' ? (index + 1) : null))
        .filter(id => id !== null);

    const lista = sintomasSeleccionados.join(','); // Ej: "1,2,5,6"

    fetch('../../controllers/realizarTest/controlEvaluarDiagnostico.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `param_lista=${lista}`
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("resultado-final").value = data.trim();
    });
}

function reiniciarTest() {
    indiceActual = 0;
    respuestas = new Array(SINTOMAS.length).fill(null);
    document.getElementById("evaluacion-final").style.display = "none";
    document.getElementById("card-pregunta").style.display = "block";
    mostrarPregunta();
    actualizarProgreso();
}

document.addEventListener("click", function(e) {
    if (e.target && e.target.id === "btnIniciar") {
        iniciarTest();
    }
});

