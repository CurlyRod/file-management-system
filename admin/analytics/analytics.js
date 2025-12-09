document.addEventListener("DOMContentLoaded", function () {

    let reqChart = null;

    // -------------------------------------------------------------
    // 1. Initialize Chart
    // -------------------------------------------------------------
    function initChart() {
        const ctx = document.getElementById("reqChart");
        if (!ctx) {
            console.error("Canvas not found");
            return;
        }

        reqChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['My files', 'Transaction', "Resolved Tickets"],
                datasets: [{
                    data: [15, 30, 55],
                    backgroundColor: ["#0288d1", "#81d4fa", "rgb(14 69 118)"]
                }]
            }
        });
    }

    // -------------------------------------------------------------
    // 2. Setup Year Input + Clickable Months
    // -------------------------------------------------------------
    function setupMonthYearControls() {

        const yearInput = document.getElementById("yearInput");
        const monthList = document.getElementById("monthList");

        const now = new Date();
        yearInput.value = now.getFullYear();

        const monthNames = [
            "Jan","Feb","Mar","Apr","May","Jun",
            "Jul","Aug","Sep","Oct","Nov","Dec"
        ];

        // Create clickable month buttons
        monthList.innerHTML = "";
        monthNames.forEach((name, index) => {

            const span = document.createElement("span");
            span.classList.add("month-item");
            span.textContent = name;
            span.dataset.month = index;

            if (index === now.getMonth()) span.classList.add("active-month");

            span.addEventListener("click", () => {
                document.querySelectorAll(".month-item")
                        .forEach(m => m.classList.remove("active-month"));
                span.classList.add("active-month");

                const y = parseInt(yearInput.value);
                generateCalendar(y, index);
            });

            monthList.appendChild(span);
        });

        // When the year changes → refresh active month
        yearInput.addEventListener("input", () => {
            const active = document.querySelector(".active-month");
            const m = parseInt(active.dataset.month);
            const y = parseInt(yearInput.value);
            if (!isNaN(y)) generateCalendar(y, m);
        });
    }

    // -------------------------------------------------------------
    // 3. Generate Calendar
    // -------------------------------------------------------------
    function generateCalendar(year, month) {
        const calendar = document.getElementById('calendar');
        const monthYear = document.getElementById('monthYear');

        calendar.innerHTML = "";

        const date = new Date(year, month, 1);
        const monthName = date.toLocaleString("default", { month: "long" });
        monthYear.textContent = `${monthName} ${year}`;

        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dayNames.forEach((dayName, index) => {
            const header = document.createElement('div');
            header.classList.add('day-header');
            if (index === 0) header.classList.add('sunday');
            header.textContent = dayName;
            calendar.appendChild(header);
        });

        const firstDay = date.getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        // Empty days before first day
        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement("div");
            empty.classList.add("day", "empty");
            calendar.appendChild(empty);
        }

        // Days
        for (let d = 1; d <= lastDate; d++) {

            const dayBox = document.createElement("div");
            dayBox.classList.add("day");
            dayBox.textContent = d;

            let fullDate =
                `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            dayBox.dataset.date = fullDate;

            const dayOfWeek = new Date(year, month, d).getDay();
            if (dayOfWeek === 0) dayBox.classList.add('sunday');

            // Highlight clicked date
            dayBox.addEventListener('click', () => {
                document.querySelectorAll('.day').forEach(day => day.classList.remove('active'));
                dayBox.classList.add('active');
                refreshChart(fullDate);
            });

            calendar.appendChild(dayBox);
        }
    }

    // -------------------------------------------------------------
    // 4. Refresh Chart Based on Clicked Date
    // -------------------------------------------------------------
    function refreshChart(dateClicked) {

        const sampleData = {
            "2025-12-01": [150, 30, 55],
            "2025-12-11": [200, 10, 44],
            "2025-01-15": [299, 55, 22],
            "2025-01-22": [130, 20, 10]
        };

        let values = sampleData[dateClicked] || [0, 0, 0];

        if (!reqChart) {
            console.error("Chart not initialized");
            return;
        }

        reqChart.data.datasets[0].data = values;
        reqChart.update();

        console.log("Refreshed for:", dateClicked, values);
    }

    // -------------------------------------------------------------
    // 5. Initialize Everything
    // -------------------------------------------------------------
    initChart();
    setupMonthYearControls();

    const today = new Date();
    generateCalendar(today.getFullYear(), today.getMonth());

});
