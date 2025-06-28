document.querySelectorAll(".sp-btn-detalle").forEach(btn => {
  btn.addEventListener("click", () => {
    const data = JSON.parse(btn.getAttribute("data-paciente"));
    spVerDetallePaciente(data);
  });
});

document.querySelectorAll(".sp-cerrar").forEach(btn => {
  btn.addEventListener("click", () => {
    const modalId = btn.getAttribute("data-close");
    document.getElementById(modalId).style.display = "none";
  });
});

function spVerDetallePaciente(paciente) {
  const modal = document.getElementById('sp-modal-detalle-paciente');

  const datosHTML = `
    <div class="sp-divisor"></div>
    <p><strong>Nombre completo:</strong> ${paciente.datos.nombres} ${paciente.datos.apellidos}</p>
    <p><strong>DNI:</strong> ${paciente.datos.dni}</p>
    <p><strong>Registrado:</strong> ${paciente.datos.fecha_registro} ${paciente.datos.hora_registro}</p>
    <div class="sp-divisor"></div>
  `;
  document.querySelector('.sp-datos-paciente').innerHTML = datosHTML;

  const tbody = document.getElementById('sp-tabla-intentos');
  tbody.innerHTML = "";

  const total = paciente.historial.length;
  [...paciente.historial].reverse().forEach((intento, i) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${total - i}</td>
      <td>${intento.fecha}</td>
      <td>${intento.hora}</td>
      <td>${intento.resultado}</td>
      <td>
        <button onclick='spVerSintomas(${JSON.stringify(intento.sintomas).replace(/'/g, "&apos;")}, "${intento.fecha}", "${intento.hora}", "${intento.resultado}")'>Ver síntomas</button>
      </td>
    `;
    tbody.appendChild(tr);
  });

  modal.style.display = "flex";
}


function spVerSintomas(sintomas, fecha, hora, diagnostico) {
  const modal = document.getElementById('sp-modal-detalle-sintomas');
  document.getElementById('sp-detalle-fecha').textContent = fecha;
  document.getElementById('sp-detalle-hora').textContent = hora;
  document.getElementById('sp-detalle-diagnostico').textContent = diagnostico;

  const ul = document.getElementById('sp-lista-sintomas');
  ul.innerHTML = "";

  sintomas.forEach(s => {
    const esSi = s.respuesta.toUpperCase() === "S";
    const icono = esSi
      ? '<i class="fas fa-check-circle sp-si"></i>'
      : '<i class="fas fa-times-circle sp-no"></i>';

    const li = document.createElement("li");
    li.innerHTML = `${s.descripcion}: ${icono}`;
    ul.appendChild(li);
  });

  modal.style.display = "flex";
}

