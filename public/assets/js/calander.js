$(document).ready(function () {
    $("#calendar-doctor").simpleCalendar({
        fixedStartDay: 0,
        disableEmptyDetails: true,
        events: [
            {
                startDate: new Date(
                    new Date().setHours(new Date().getHours() + 24),
                ).toDateString(),
                endDate: new Date(
                    new Date().setHours(new Date().getHours() + 25),
                ).toISOString(),
            },
        ],
    });
});