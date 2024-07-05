"use strict";

$(document).ready(async function () {
    const fetchData = async (url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            return null;
        }
    };

    const currentURL = window.location.href;
    const path = currentURL.split('/');
    const value = path[path.length - 1];
    const data = await fetchData(baseUrl +'/dashboard/teacher/' + value);

    if ($("#teacher-monthly-area").length > 0) {
        var options = {
        chart: { height: 350, type: "area", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "straight" },
        series: [
            {
            name: "Classes",
            color: "#3D5EE1",
            data: data.growthClassMonthly.reverse(),
            },
            {
            name: "Students",
            color: "#70C4CF",
            data: data.growthStudentMonthly.reverse(),
            },
        ],
        xaxis: { categories: upcomingMonths },
        };
        var chart = new ApexCharts(document.querySelector("#teacher-monthly-area"), options);
        chart.render();
    }

    if ($("#teacher-yearly-area").length > 0) {
        var options = {
        chart: { height: 350, type: "area", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "straight" },
        series: [
            {
            name: "Classes",
            color: "#3D5EE1",
            data: data.growthClassYearly.reverse(),
            },
            {
            name: "Students",
            color: "#70C4CF",
            data: data.growthStudentYearly.reverse(),
            },
        ],
        xaxis: { categories: recentYears },
        };
        var chart = new ApexCharts(
        document.querySelector("#teacher-yearly-area"),
        options,
        );
        chart.render();
    }
});
