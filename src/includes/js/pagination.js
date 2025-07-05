function paginateTable(tableSelector, rowsPerPage = 5) {
    const table = document.querySelector(tableSelector);
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    const pagination = document.getElementById("pagination");

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
            btn.className = "btn btn-sm btn-primary mx-1" + (i === activePage ? " active" : "");
            btn.addEventListener("click", () => {
                currentPage = i;
                renderPage(currentPage);
            });
            pagination.appendChild(btn);
        }
    }

    renderPage(currentPage);
}

