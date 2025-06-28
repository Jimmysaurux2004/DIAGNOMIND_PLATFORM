document.addEventListener("DOMContentLoaded", function () {
  const table = document.getElementById("ha-tabla-autoevaluaciones");
  const rows = Array.from(table.querySelectorAll("tbody tr"));
  const paginationSelect = document.getElementById("ha-items-por-pagina");
  const paginationInfo = document.getElementById("ha-total-registros");
  const prevBtn = document.getElementById("ha-pagina-anterior");
  const nextBtn = document.getElementById("ha-pagina-siguiente");

  let currentPage = 1;
  let itemsPerPage = parseInt(paginationSelect.value);

  function filterRows() {
    return rows;
  }

  function paginateAndRender(filteredRows) {
    const totalItems = filteredRows.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    currentPage = Math.max(1, Math.min(currentPage, totalPages));
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageRows = filteredRows.slice(start, end);

    table.querySelector("tbody").innerHTML = "";
    pageRows.forEach((row) => table.querySelector("tbody").appendChild(row));

    paginationInfo.textContent = `Mostrando ${start + 1}-${Math.min(end, totalItems)} de ${totalItems} registros`;
  }

  paginationSelect.addEventListener("change", () => {
    itemsPerPage = parseInt(paginationSelect.value);
    currentPage = 1;
    paginateAndRender(filterRows());
  });

  prevBtn.addEventListener("click", () => {
    currentPage = Math.max(currentPage - 1, 1);
    paginateAndRender(filterRows());
  });

  nextBtn.addEventListener("click", () => {
    currentPage++;
    paginateAndRender(filterRows());
  });

  paginateAndRender(filterRows());
});

// Botón Ver Detalles
document.body.addEventListener("click", (e) => {
  const btn = e.target.closest(".ha-ver-detalles");
  if (!btn) return;

  document.getElementById("ha-modal-fecha").textContent = btn.dataset.fecha;
  document.getElementById("ha-modal-hora").textContent = btn.dataset.hora;
  document.getElementById("ha-modal-diagnostico").textContent = btn.dataset.diagnostico;

  const lista = document.getElementById("ha-modal-lista-sintomas");
  lista.innerHTML = "";

  const sintomas = JSON.parse(btn.dataset.sintomas);
  sintomas.forEach((s) => {
    const li = document.createElement("li");
    li.textContent = `${s.respuesta === "S" ? "✅" : "❌"} ${s.descripcion}`;
    lista.appendChild(li);
  });

  const modal = new bootstrap.Modal(document.getElementById("ha-modal-historial"));
  modal.show();
});

// Botón cerrar modal
document.body.addEventListener("click", (e) => {
  if (e.target.id === "ha-modal-cerrar" || e.target.closest("#ha-modal-cerrar")) {
    const modalEl = document.getElementById("ha-modal-historial");
    const instance = bootstrap.Modal.getInstance(modalEl);
    if (instance) instance.hide();
  }
});
