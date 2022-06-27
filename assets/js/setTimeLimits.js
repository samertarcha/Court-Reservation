

var inputDateFootball = document.getElementById("resDay_f");

inputDateFootball.addEventListener('input', function () {
    var selectedDate = new Date(inputDateFootball.value);
    var day = selectedDate.getDay();
    console.log(day);
    if (1 <= day && day <= 4) {
        document.getElementById('resStart_f').setAttribute('min', '16:00');
        document.getElementById('resStart_f').setAttribute('max', '22:00');
        document.getElementById('endTime_f').setAttribute('min', '16:00');
        document.getElementById('endTime_f').setAttribute('max', '22:00');
    }else if(day == 5){
        document.getElementById('resStart_f').setAttribute('min', '13:00');
        document.getElementById('resStart_f').setAttribute('max', '16:00');
        document.getElementById('endTime_f').setAttribute('min', '13:00');
        document.getElementById('endTime_f').setAttribute('max', '16:00');
    }else if(day == 6){
        document.getElementById('resStart_f').setAttribute('min', '18:30');
        document.getElementById('resStart_f').setAttribute('max', '22:30');
        document.getElementById('endTime_f').setAttribute('min', '18:30');
        document.getElementById('endTime_f').setAttribute('max', '22:30');
    } else if (day == 0) {
        document.getElementById('resStart_f').setAttribute('min', '08:00');
        document.getElementById('resStart_f').setAttribute('max', '21:00');
        document.getElementById('endTime_f').setAttribute('min', '08:00');
        document.getElementById('endTime_f').setAttribute('max', '21:00');
    }
});

var inputDateBasketball = document.getElementById("resDay_b");

inputDateBasketball.addEventListener('input', function () {
    var selectedDate = new Date(inputDateBasketball.value);
    var day = selectedDate.getDay();
    console.log(day);
    if (1 <= day && day <= 4) {
        console.log('monday to thursday');
        document.getElementById('resStart_b').setAttribute('min', '16:00');
        document.getElementById('resStart_b').setAttribute('max', '22:00');
        document.getElementById('endTime_b').setAttribute('min', '16:00');
        document.getElementById('endTime_b').setAttribute('max', '22:00');
    } else if (day == 5) {
        console.log('friday');
        document.getElementById('resStart_b').setAttribute('min', '13:00');
        document.getElementById('resStart_b').setAttribute('max', '16:00');
        document.getElementById('endTime_b').setAttribute('min', '13:00');
        document.getElementById('endTime_b').setAttribute('max', '16:00');
    } else if (day == 6) {
        console.log('saturday');
        document.getElementById('resStart_b').setAttribute('min', '18:30');
        document.getElementById('resStart_b').setAttribute('max', '22:30');
        document.getElementById('endTime_b').setAttribute('min', '18:30');
        document.getElementById('endTime_b').setAttribute('max', '22:30');
    } else if (day == 0) {
        console.log('sunday');
        document.getElementById('resStart_b').setAttribute('min', '08:00');
        document.getElementById('resStart_b').setAttribute('max', '21:00');
        document.getElementById('endTime_b').setAttribute('min', '08:00');
        document.getElementById('endTime_b').setAttribute('max', '21:00');
    }
});

var inputDateTennis = document.getElementById('resDay_t');

inputDateTennis.addEventListener('input', function () {
    var selectedDate = new Date(inputDateTennis.value);
    var day = selectedDate.getDay();
    if (1 <= day && day <= 4) {
        console.log('monday to thursday');
        document.getElementById('resStart_t').setAttribute('min', '16:00');
        document.getElementById('resStart_t').setAttribute('max', '22:00');
        document.getElementById('endTime_t').setAttribute('min', '16:00');
        document.getElementById('endTime_t').setAttribute('max', '22:00');
    } else if (day == 5) {
        console.log('friday');
        document.getElementById('resStart_t').setAttribute('min', '13:00');
        document.getElementById('resStart_t').setAttribute('max', '16:00');
        document.getElementById('endTime_t').setAttribute('min', '13:00');
        document.getElementById('endTime_t').setAttribute('max', '16:00');
    } else if (day == 6) {
        console.log('saturday');
        document.getElementById('resStart_t').setAttribute('min', '18:30');
        document.getElementById('resStart_t').setAttribute('max', '22:30');
        document.getElementById('endTime_t').setAttribute('min', '18:30');
        document.getElementById('endTime_t').setAttribute('max', '22:30');
    } else if (day == 0) {
        console.log('sunday');
        document.getElementById('resStart_t').setAttribute('min', '08:00');
        document.getElementById('resStart_t').setAttribute('max', '21:00');
        document.getElementById('endTime_t').setAttribute('min', '08:00');
        document.getElementById('endTime_t').setAttribute('max', '21:00');
    }
});
