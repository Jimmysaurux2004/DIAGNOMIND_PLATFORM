let indiceActual = 0;
let respuestas = [];

function iniciarTest() {
    document.getElementById("intro-section").style.display = "none";
    document.getElementById("test-section").style.display = "flex";
    respuestas = new Array(SINTOMAS.length).fill(null);
    mostrarPregunta();
    actualizarProgreso();
}

function mostrarPregunta() {
    document.getElementById("texto-sintoma").textContent = SINTOMAS[indiceActual];
    document.getElementById("contador-pregunta").textContent = `Pregunta ${indiceActual + 1} de ${SINTOMAS.length}`;
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
    }
    if (respuestas.every(r => r !== null)) {
        document.getElementById("evaluacion-final").style.display = "flex";
    }
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
    document.getElementById("barra-progreso").style.width = `${porcentaje}%`;
    document.getElementById("resumen-respuestas").textContent = `${respondidas} respondidas`;
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
    mostrarPregunta();
    actualizarProgreso();
}

document.getElementById("btnIniciar").addEventListener("click", iniciarTest);
