$(document).ready(function () {
    var calendar = $("#calendar-doctor").simpleCalendar({
        fixedStartDay: 0,
        disableEmptyDetails: true,
        events: [], // Khởi tạo events rỗng ban đầu
    });

    $('#calendar-doctor').on('click', '.day', async function () {
        $('.day.today').removeClass('today');

        $(this).addClass('today');

        var dateISO = $(this).data('date');
        var selectedDate = new Date(dateISO);

        var year = selectedDate.getFullYear();
        var month = ('0' + (selectedDate.getMonth() + 1)).slice(-2);
        var day = ('0' + selectedDate.getDate()).slice(-2); 

        var formattedDate = `${year}-${month}-${day}`;
        console.log(formattedDate); 

        const currentURL = window.location.href;
        const path = currentURL.split('/');
        const teacher_id = path[path.length - 1];

        try {
            const response = await fetch(baseUrl + `/dashboard/schedule/teacher/${teacher_id}?date=${formattedDate}`);
            if (!response.ok) {
                throw new Error('Failed to fetch teacher lessons.');
            }

            const data = await response.json();

            if (data) {
                updateCalendarUI(data);
            }
        } catch (error) {
            console.error('Error fetching teacher lessons:', error);
        }
    });

    function updateCalendarUI(data) {
        const calendarInfo = document.querySelector('.calendar-info1');
        
        if (!calendarInfo) {
            console.error('Element with ID calendar-info1 not found.', calendarInfo);
            return;
        }
    
        calendarInfo.innerHTML = ''; // Clear previous content
    
        data.classrooms.forEach(classroom => {
            classroom.lessons.forEach(lesson => {
                const startTime = new Date(lesson.start_time);
                const endTime = new Date(lesson.end_time);
    
                var options = {
                    hour: '2-digit', minute: '2-digit',
                    hour12: false,
                    timeZone: 'Asia/Ho_Chi_Minh' // Example timeZone setting
                };
    
                var formattedStartTime = startTime.toLocaleString('en-US', options);
                var formattedEndTime = endTime.toLocaleString('en-US', options);
    
                const lessonHTML = `
                    <div class="upcome-event-date">
                        <h3>${startTime.getDate()} ${startTime.toLocaleDateString('en-US', { month: 'short' })}</h3>
                        <span><i class="fas fa-ellipsis-h"></i></span>
                    </div>
                    <div class="calendar-details">
                        <p>${formattedStartTime}</p>
                        <div class="calendar-box normal-bg">
                            <div class="calendar-event-name">
                                <h4 style="margin-left: 7px; font-size: 16px; font-weight:bold;">${classroom.classroomName}</h4>
                                <h5 style="margin-left: 7px; font-size: 14px">${classroom.roomName}</h5>
                            </div>
                            <span>${formattedStartTime} - ${formattedEndTime}</span>
                        </div>
                    </div>
                `;
    
                calendarInfo.insertAdjacentHTML('beforeend', lessonHTML);
            });
        });
    }     
});
