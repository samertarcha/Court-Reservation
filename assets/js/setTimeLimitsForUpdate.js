var inputDateFootball = document.getElementById("resDay");

inputDateFootball.addEventListener('input', function () {
    var selectedDate = new Date(inputDateFootball.value);
    var day = selectedDate.getDay();
    console.log(day);
    if (1 <= day && day <= 4) {
        document.getElementById('startTime').setAttribute('min', '16:00');
        document.getElementById('startTime').setAttribute('max', '22:00');
        document.getElementById('endTime').setAttribute('min', '16:00');
        document.getElementById('endTime').setAttribute('max', '22:00');
    }else if(day == 5){
        document.getElementById('startTime').setAttribute('min', '13:00');
        document.getElementById('startTime').setAttribute('max', '16:00');
        document.getElementById('endTime').setAttribute('min', '13:00');
        document.getElementById('endTime').setAttribute('max', '16:00');
    }else if(day == 6){
        document.getElementById('startTime').setAttribute('min', '18:00');
        document.getElementById('startTime').setAttribute('max', '22:30');
        document.getElementById('endTime').setAttribute('min', '18:00');
        document.getElementById('endTime').setAttribute('max', '22:30');
    } else if (day == 0) {
        document.getElementById('startTime').setAttribute('min', '08:00');
        document.getElementById('startTime').setAttribute('max', '21:00');
        document.getElementById('endTime').setAttribute('min', '08:00');
        document.getElementById('endTime').setAttribute('max', '21:00');
    }
});