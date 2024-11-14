$(document).ready(function () {
    const ctx = document.getElementById('myBarChart');
    const dailyPrices = dailyProfitData.map(entry => entry.total_amount);
    const highestDaily = Math.max(...dailyPrices);
    const lowestDaily = Math.min(...dailyPrices);

    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], 
            datasets: [{
                label: 'Total Price by Day',
                data: [], 
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color for daily chart
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Set highest and lowest profit values with custom colors
    $('.daily .data_from_graphical li:nth-child(1) p').text(`₱${highestDaily}`).css('color', 'cyan'); // Cyan color for highest
    $('.daily .data_from_graphical li:nth-child(2) p').text(`₱${lowestDaily}`).css('color', '#FF6347'); // Reddish-orange for lowest

    // Update chart with daily data
    if (dailyProfitData && Array.isArray(dailyProfitData)) {
        const labels = dailyProfitData.map(entry => entry.day_name);
        const prices = dailyProfitData.map(entry => entry.total_amount);

        myBarChart.data.labels = labels;
        myBarChart.data.datasets[0].data = prices;
        myBarChart.update();
    }

    // Weekly chart
    const ctxWeekly = document.getElementById('myWeeklyChart').getContext('2d');
    const weeklyPrices = weeklyProfitData.map(entry => entry.total_amount);
    const highestWeekly = Math.max(...weeklyPrices);
    const lowestWeekly = Math.min(...weeklyPrices);

    const myWeeklyChart = new Chart(ctxWeekly, {
        type: 'bar',
        data: {
            labels: weeklyProfitData.map(entry => entry.week),
            datasets: [{
                label: 'Total Profit by Week',
                data: weeklyProfitData.map(entry => entry.total_amount),
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Teal color for weekly chart
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Set highest and lowest profit values with custom colors
    $('.weekly .data_from_graphical li:nth-child(1) p').text(`₱${highestWeekly}`).css('color', 'cyan');
    $('.weekly .data_from_graphical li:nth-child(2) p').text(`₱${lowestWeekly}`).css('color', '#FF6347');

    // Monthly chart
    const ctxMonthly = document.getElementById('myMonthlyChart').getContext('2d');
    const monthlyPrices = monthlyProfitData.map(entry => entry.total_amount);
    const highestMonthly = Math.max(...monthlyPrices);
    const lowestMonthly = Math.min(...monthlyPrices);

    const myMonthlyChart = new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: monthlyProfitData.map(entry => entry.month),
            datasets: [{
                label: 'Total Profit by Month',
                data: monthlyProfitData.map(entry => entry.total_amount),
                backgroundColor: 'rgba(255, 159, 64, 0.2)', // Orange color for monthly chart
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Set highest and lowest profit values with custom colors
    $('.monthly .data_from_graphical li:nth-child(1) p').text(`₱${highestMonthly}`).css('color', 'cyan');
    $('.monthly .data_from_graphical li:nth-child(2) p').text(`₱${lowestMonthly}`).css('color', '#FF6347');

    // Yearly chart
    const ctxYearly = document.getElementById('myYearlyChart').getContext('2d');
    const yearlyPrices = yearlyProfitData.map(entry => entry.total_amount);
    const highestYearly = Math.max(...yearlyPrices);
    const lowestYearly = Math.min(...yearlyPrices);

    const myYearlyChart = new Chart(ctxYearly, {
        type: 'bar',
        data: {
            labels: yearlyProfitData.map(entry => entry.year),
            datasets: [{
                label: 'Total Profit by Year',
                data: yearlyProfitData.map(entry => entry.total_amount),
                backgroundColor: 'rgba(153, 102, 255, 0.2)', // Purple color for yearly chart
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Set highest and lowest profit values with custom colors
    $('.yearly .data_from_graphical li:nth-child(1) p').text(`₱${highestYearly}`).css('color', 'cyan');
    $('.yearly .data_from_graphical li:nth-child(2) p').text(`₱${lowestYearly}`).css('color', '#FF6347');




    if (dailyProfitData && Array.isArray(dailyProfitData)) {
        const labels = dailyProfitData.map(entry => entry.day_name);
        const prices = dailyProfitData.map(entry => entry.total_amount);

        myBarChart.data.labels = labels;
        myBarChart.data.datasets[0].data = prices;
        myBarChart.update();
    }
    else if (weeklyProfitData && Array.isArray(weeklyProfitData)) {
        const labels = weeklyProfitData.map(entry => entry.week_name);
        const prices = weeklyProfitData.map(entry => entry.total_amount);

        myBarChart.data.labels = labels;
        myBarChart.data.datasets[0].data = prices;
        myBarChart.update();
    }
    else if (monthlyProfitData && Array.isArray(monthlyProfitData)) {
        const labels = monthlyProfitData.map(entry => entry.month_name);
        const prices = monthlyProfitData.map(entry => entry.total_amount);

        myBarChart.data.labels = labels;
        myBarChart.data.datasets[0].data = prices;
        myBarChart.update();
    }
    else if (yearlyProfitData && Array.isArray(yearlyProfitData)) {
        const labels = yearlyProfitData.map(entry => entry.year_name);
        const prices = yearlyProfitData.map(entry => entry.total_amount);

        myBarChart.data.labels = labels;
        myBarChart.data.datasets[0].data = prices;
        myBarChart.update();
    }
});
