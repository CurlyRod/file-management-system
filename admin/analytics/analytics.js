document.addEventListener("DOMContentLoaded", function () {

    let reqChart = null; 

    function initChart() {
        const ctx = document.getElementById("reqChart");
        if (!ctx) {
            console.error("Canvas not found");
            return;
        }

        reqChart = new Chart(ctx, {       // <-- SAVE INSTANCE HERE
            type: 'pie',
            data: {
                labels: ['My files', 'Transaction', "Resolved Tickets"],
                datasets: [{
                    data: [15, 30, 55],
                    backgroundColor: ["#0288d1", "#81d4fa","rgb(14 69 118)"]
                }]
            }
        });
    }

    
 function generateCalendar(year, month) {
    const calendar = document.getElementById('calendar');
    const monthYear = document.getElementById('monthYear');

    calendar.innerHTML = "";

    const date = new Date(year, month, 1);
    const monthName = date.toLocaleString("default", { month: "long" });
    monthYear.textContent = `${monthName} ${year}`;

    // Day headers
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayNames.forEach((dayName, index) => {
        const header = document.createElement('div');
        header.classList.add('day-header');
        if (index === 0) header.classList.add('sunday'); // Sunday red
        header.textContent = dayName;
        calendar.appendChild(header);
    });

    const firstDay = date.getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    // Empty slots for alignment
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

        let fullDate = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        dayBox.dataset.date = fullDate;

        // Make Sundays red
        const dayOfWeek = new Date(year, month, d).getDay();
        if (dayOfWeek === 0) dayBox.classList.add('sunday');

        dayBox.addEventListener('click', () => refreshChart(fullDate));

        calendar.appendChild(dayBox);
    }
}

    //---------------------------------------------
    // 3. Update chart on click
    //---------------------------------------------
    function refreshChart(dateClicked) {

        const sampleData = {
            "2025-12-01": [150, 30,55],
            "2025-12-11": [200, 10,44],
            "2025-01-15": [299, 55],
            "2025-01-22": [130, 20]
        };

        let values = sampleData[dateClicked] || [0, 0];

        if (!reqChart) {
            console.error("Chart not initialized");
            return;
        }

        reqChart.data.datasets[0].data = values;
        reqChart.update();

        console.log("Refreshed for:", dateClicked, values);
    }

    initChart(); 
    const today = new Date();
    generateCalendar(today.getFullYear(), today.getMonth());

});

