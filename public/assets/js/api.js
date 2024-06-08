const baseUrl = "http://127.0.0.1:8000/api"; 

const currentDate = new Date();

const currentMonth = currentDate.getMonth(); 
const currentYear = currentDate.getFullYear();

const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

const upcomingMonths = months.slice(0, currentMonth + 1);

const numberOfYears = 6;

const recentYears = [];
for (let i = numberOfYears - 1; i >= 0; i--) {
    recentYears.push(currentYear - i);
}