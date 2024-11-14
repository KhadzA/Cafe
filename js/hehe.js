$(document).ready(function () {
    // Daily Chart
    const ctx = document.getElementById('myBarChart').getContext('2d');
    const dailyPrices = dailyProfitData.map(entry => entry.total_amount);
    const highestDaily = Math.max(...dailyPrices);
    const lowestDaily = Math.min(...dailyPrices);
    
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dailyProfitData.map(entry => entry.day_name),
            datasets: [{
                label: 'Total Price by Day',
                data: dailyPrices,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
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

    $('.daily .data_from_graphical li:nth-child(1) p').text(`₱${highestDaily}`);
    $('.daily .data_from_graphical li:nth-child(2) p').text(`₱${lowestDaily}`);
    $('.daily .data_from_graphical li:nth-child(1) .date').text(dailyProfitData[dailyPrices.indexOf(highestDaily)].day_name);
    $('.daily .data_from_graphical li:nth-child(2) .date').text(dailyProfitData[dailyPrices.indexOf(lowestDaily)].day_name);


    // Weekly Chart
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
                data: weeklyPrices,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
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

    $('.weekly .data_from_graphical li:nth-child(1) p').text(`₱${highestWeekly}`);
    $('.weekly .data_from_graphical li:nth-child(2) p').text(`₱${lowestWeekly}`);
    $('.weekly .data_from_graphical li:nth-child(1) .date').text(weeklyProfitData[weeklyPrices.indexOf(highestWeekly)].week_name);
    $('.weekly .data_from_graphical li:nth-child(2) .date').text(weeklyProfitData[weeklyPrices.indexOf(lowestWeekly)].week_name);




    // Monthly Chart
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
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
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

    $('.monthly .data_from_graphical li:nth-child(1) p').text(`₱${highestMonthly}`);
    $('.monthly .data_from_graphical li:nth-child(2) p').text(`₱${lowestMonthly}`);
    $('.monthly .data_from_graphical li:nth-child(1) .date').text(monthlyProfitData[monthlyPrices.indexOf(highestMonthly)].month_name);
    $('.monthly .data_from_graphical li:nth-child(2) .date').text(monthlyProfitData[monthlyPrices.indexOf(lowestMonthly)].month_name);



    // Yearly Chart
    const ctxYearly = document.getElementById('myYearlyChart').getContext('2d');
    const yearlyPrices = yearlyProfitData.map(entry => entry.total_amount);
    const highestYearly = Math.max(...yearlyPrices);
    const lowestYearly = Math.min(...yearlyPrices);

    const myYearlyChart = new Chart(ctxYearly, {
        type: 'bar',
        data: {
            labels: yearlyProfitData.map(entry => entry.year),
            datasets: [{
                label: 'Total Profit by year',
                data: yearlyProfitData.map(entry => entry.total_amount),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
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

    $('.yearly .data_from_graphical li:nth-child(1) p').text(`₱${highestYearly}`);
    $('.yearly .data_from_graphical li:nth-child(2) p').text(`₱${lowestYearly}`);
    $('.yearly .data_from_graphical li:nth-child(1) .date').text(yearlyProfitData[yearlyPrices.indexOf(highestYearly)].year_name);
    $('.yearly .data_from_graphical li:nth-child(2) .date').text(yearlyProfitData[yearlyPrices.indexOf(lowestYearly)].year_name);

});
