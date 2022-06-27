//Call ajax
var ajax = new XMLHttpRequest();
ajax.open("GET", "../modules/data/courtTableData.php", true);

//sending ajax request
ajax.send();

//receiving response from data.php
ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        //converting JSON back to array
        var data = JSON.parse(this.responseText);

        //displaying data
        var basketballStatus = data[0].availability;
        var footballStatus = data[1].availability;
        var tennisStatus = data[2].availability;

        var today = new Date();
        var dayOfWeek = today.getDay();
        var hour = today.getHours();
        var minute = today.getMinutes();
        if (hour < 10) {
            hour = '0' + hour;
        }
        if (minute < 10) {
            minute = '0' + minute;
        }
        var time = hour + ":" + minute;

        //displaying basketball status

        if (footballStatus == 1) {
            if ((dayOfWeek >= 1 && dayOfWeek <= 4 && time >= '16:00' && time <= '22:00') || (dayOfWeek == 5 && time >= '13:00' && time <= '16:00') || (dayOfWeek == 6 && time >= '18:30' && time <= '22:30') || (dayOfWeek == 0 && time >= '08:00' && time <= '21:00')) {
                document.getElementById("footballStatus").classList.add("available");
                document.getElementById("footballStatus").innerText = "Available";
            } else {
                document.getElementById("footballStatus").classList.add("not-available");
                document.getElementById("footballStatus").innerText = "Not Available";
            }
        }else {
            document.getElementById("footballStatus").classList.add("in-use");
            document.getElementById("footballStatus").innerText = "In Use";
        }

        if (basketballStatus == 1) {
            if ((dayOfWeek >= 1 && dayOfWeek <= 4 && time >= '16:00' && time <= '22:00') || (dayOfWeek == 5 && time >= '13:00' && time <= '16:00') || (dayOfWeek == 6 && time >= '18:30' && time <= '22:30') || (dayOfWeek == 0 && time >= '08:00' && time <= '21:00')) {
                document.getElementById("basketballStatus").classList.add("available");
                document.getElementById("basketballStatus").innerText = "Available";
            } else {
                document.getElementById("basketballStatus").classList.add("not-available");
                document.getElementById("basketballStatus").innerText = "Not Available";
            }
        } else {
            document.getElementById("basketballStatus").classList.add("in-use");
            document.getElementById("basketballStatus").innerText = "In Use";
        }

        if (tennisStatus == 1) {
            if ((dayOfWeek >= 1 && dayOfWeek <= 4 && time >= '16:00' && time <= '22:00') || (dayOfWeek == 5 && time >= '13:00' && time <= '16:00') || (dayOfWeek == 6 && time >= '18:30' && time <= '22:30') || (dayOfWeek == 0 && time >= '08:00' && time <= '21:00')) {
                document.getElementById("tennisStatus").classList.add("available");
                document.getElementById("tennisStatus").innerText = "Available";
            } else {
                document.getElementById("tennisStatus").classList.add("not-available");
                document.getElementById("tennisStatus").innerText = "Not Available";
            }
        } else {
            document.getElementById("tennisStatus").classList.add("in-use");
            document.getElementById("tennisStatus").innerText = "In Use";
        }
    }
};
