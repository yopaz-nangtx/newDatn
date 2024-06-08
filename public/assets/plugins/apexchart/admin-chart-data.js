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

    const data = await fetchData(baseUrl +'/dashboard/admin');

    if ($("#monthly-revenue-chart").length > 0) {
        var options = {
        chart: { height: 350, type: "line", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "straight" },
        series: [
            {
            name: "Revenue",
            color: "#3D5EE1",
            data: data.revenueMonthly.reverse(),
            },
        ],
        xaxis: { categories: upcomingMonths },
        };
        var chart = new ApexCharts(
        document.querySelector("#monthly-revenue-chart"),
        options,
        );
        chart.render();
    }

    if ($("#yearly-revenue-chart").length > 0) {
        var options = {
        chart: { height: 350, type: "line", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "straight" },
        series: [
            {
            name: "Revenue",
            color: "#3D5EE1",
            data: data.revenueYearly.reverse(),
            },
        ],
        xaxis: { categories: recentYears },
        };
        var chart = new ApexCharts(
        document.querySelector("#yearly-revenue-chart"),
        options,
        );
        chart.render();
    }

    if ($("#monthly-growth-chart").length > 0) {
        var optionsBar = {
        chart: {
            type: "bar",
            height: 350,
            width: "100%",
            stacked: false,
            toolbar: { show: false },
        },
        dataLabels: { enabled: false },
        plotOptions: { bar: { columnWidth: "55%", endingShape: "rounded" } },
        stroke: { show: true, width: 2, colors: ["transparent"] },
        series: [
            {
            name: "Teachers",
            color: "#70C4CF",
            data: data.growthTeacherMonthly.reverse(),
            },
            {
            name: "Students",
            color: "#3D5EE1",
            data: data.growthStudentMonthly.reverse(),
            },
        ],
        labels: upcomingMonths,
        title: { text: "", align: "left", style: { fontSize: "18px" } },
        };
        var chartBar = new ApexCharts(document.querySelector("#monthly-growth-chart"), optionsBar);
        chartBar.render();
    }

    if ($("#yearly-growth-chart").length > 0) {
        var optionsBar = {
        chart: {
            type: "bar",
            height: 350,
            width: "100%",
            stacked: false,
            toolbar: { show: false },
        },
        dataLabels: { enabled: false },
        plotOptions: { bar: { columnWidth: "55%", endingShape: "rounded" } },
        stroke: { show: true, width: 2, colors: ["transparent"] },
        series: [
            {
            name: "Teachers",
            color: "#70C4CF",
            data: data.growthTeacherYearly.reverse(),
            },
            {
            name: "Students",
            color: "#3D5EE1",
            data: data.growthStudentYearly.reverse(),
            },
        ],
        labels: recentYears,
        title: { text: "", align: "left", style: { fontSize: "18px" } },
        };
        var chartBar = new ApexCharts(document.querySelector("#yearly-growth-chart"), optionsBar);
        chartBar.render();
    }
});
