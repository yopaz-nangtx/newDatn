"use strict";

$(document).ready(function () {
    if ($("#school-area").length > 0) {
        var options = {
        chart: { height: 350, type: "area", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "straight" },
        series: [
            {
            name: "Classes",
            color: "#3D5EE1",
            data: [45, 60, 75, 51, 42, 42, 30],
            },
            {
            name: "Students",
            color: "#70C4CF",
            data: [24, 48, 56, 32, 34, 52, 25],
            },
        ],
        xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"] },
        };
        var chart = new ApexCharts(document.querySelector("#school-area"), options);
        chart.render();
    }

    if ($("#in-progress-area").length > 0) {
        var options = {
        chart: { height: 350, type: "area", toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: "straight" },
        series: [
            {
            name: "Happend",
            color: "#3D5EE1",
            data: [45, 60, 75, 51, 42, 42, 30],
            },
            {
            name: "All",
            color: "#70C4CF",
            data: [24, 48, 56, 32, 34, 52, 25],
            },
        ],
        xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"] },
        };
        var chart = new ApexCharts(
        document.querySelector("#in-progress-area"),
        options,
        );
        chart.render();
    }
});
