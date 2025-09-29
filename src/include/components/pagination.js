function paginateTable(tableSelector, rowsPerPage = 5, paginate) {
    const paginationId = paginate || "pagination";

    const table = document.querySelector(tableSelector);
    if (!table) return;

    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    const pagination = document.getElementById(paginationId);

    if (!pagination) {
        console.warn(`Pagination container #${paginationId} not found`);
        return;
    }

    pagination.innerHTML = "";
    if (rows.length === 0) {

        tbody.innerHTML = `<tr><td colspan="100%" class="text-center">No records found</td></tr>`;

        const span = document.createElement("span");
        span.textContent = "No records found";
        pagination.appendChild(span);
        return;
    }

    const totalPages = Math.ceil(rows.length / rowsPerPage);
    let currentPage = 1;

    function renderPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? "" : "none";
        });

        renderPagination(page);
    }

    function renderPagination(activePage) {
        pagination.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.className =
                "btn btn-sm btn-primary mx-1" + (i === activePage ? " active" : "");
            btn.addEventListener("click", () => {
                currentPage = i;
                renderPage(currentPage);
            });
            pagination.appendChild(btn);
        }
    }

    renderPage(currentPage);
}
