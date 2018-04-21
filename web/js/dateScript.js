var date = new Date();
date.setDate(date.getDate());
$(".datepicker").datepicker({
    daysOfWeekDisabled: [2, 0],
    startDate : date
});