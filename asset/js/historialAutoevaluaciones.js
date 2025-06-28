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
document.querySelectorAll(".ha-ver-detalles").forEach(btn => {
  btn.addEventListener("click", () => {
    const fecha = btn.getAttribute("data-fecha");
    const hora = btn.getAttribute("data-hora");
    const diagnostico = btn.getAttribute("data-diagnostico");
    const sintomas = JSON.parse(btn.getAttribute("data-sintomas"));

    document.getElementById("ha-modal-fecha").textContent = fecha;
    document.getElementById("ha-modal-hora").textContent = hora;
    document.getElementById("ha-modal-diagnostico").textContent = diagnostico;

    const ul = document.getElementById("ha-modal-lista-sintomas");
    ul.innerHTML = "";

    sintomas.forEach(s => {
      const esSi = s.respuesta.toUpperCase() === "S";
      const icono = esSi
        ? '<i class="fas fa-circle-check ha-si"></i>'
        : '<i class="fas fa-circle-xmark ha-no"></i>';

      const li = document.createElement("li");
      li.innerHTML = `${s.descripcion}: ${icono}`;
      ul.appendChild(li);
    });

    document.getElementById("ha-modal-detalle-autoevaluacion").style.display = "flex";
  });
});

document.getElementById("ha-modal-cerrar").addEventListener("click", () => {
  document.getElementById("ha-modal-detalle-autoevaluacion").style.display = "none";
});


/** */
window.HistorialAutoevaluacionesPagination = (function () {
    let currentPage = 1;
    let rowsPerPage = 10;

    const storageKey = "haRowsPerPage";
    const tableId = "ha-tabla-autoevaluaciones";
    const selectId = "ha-items-por-pagina";
    const infoId = "ha-total-registros";
    const btnPrevId = "ha-pagina-anterior";
    const btnNextId = "ha-pagina-siguiente";

    const loadSavedConfig = () => {
        const saved = localStorage.getItem(storageKey);
        if (saved) rowsPerPage = parseInt(saved, 10);
    };

    const saveConfig = () => {
        localStorage.setItem(storageKey, rowsPerPage);
    };

    const updatePagination = () => {
        const table = document.getElementById(tableId);
        if (!table) return;

        const rows = table.querySelectorAll("tbody tr");
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        rows.forEach((row, index) => {
            const show = index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage;
            row.style.display = show ? "" : "none";
        });

        const info = document.getElementById(infoId);
        if (info) {
            info.innerText = totalRows > 0
                ? `de ${totalRows} registros`
                : "de 0 registros";
        }

        const btnPrev = document.getElementById(btnPrevId);
        const btnNext = document.getElementById(btnNextId);
        if (btnPrev) btnPrev.disabled = currentPage === 1;
        if (btnNext) btnNext.disabled = currentPage >= totalPages || totalPages === 0;
    };

    const init = () => {
        loadSavedConfig();

        const select = document.getElementById(selectId);
        if (select) {
            select.value = rowsPerPage;
            select.addEventListener("change", function () {
                rowsPerPage = parseInt(this.value, 10);
                currentPage = 1;
                saveConfig();
                updatePagination();
            });
        }

        const btnPrev = document.getElementById(btnPrevId);
        const btnNext = document.getElementById(btnNextId);

        if (btnPrev) {
            btnPrev.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });
        }

        if (btnNext) {
            btnNext.addEventListener("click", () => {
                const table = document.getElementById(tableId);
                const totalRows = table.querySelectorAll("tbody tr").length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });
        }

        updatePagination();
    };

    return {
        init
    };
})();


