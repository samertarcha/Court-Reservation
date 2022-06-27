var ajax = new XMLHttpRequest();
ajax.open("GET", "../modules/data/reservationTableDataTennis.php", true);

//sending ajax request
ajax.send();

//receiving response from data.php
ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        //converting JSON back to array
        var data = JSON.parse(this.responseText);

        // GET current date
        var today = new Date();
        var dayOfWeekJS = today.getDay();
        var dayOfMonthJS = today.getDate();
        var month = today.getMonth() + 1; //day of month starts at 0
        var year = today.getFullYear();
        
        // Set name values for day of week
        if (dayOfWeekJS == 0) {
            dayOfWeekJS = "Sun";
        } else if (dayOfWeekJS == 1) {
            dayOfWeekJS = "Mon";
        } else if (dayOfWeekJS == 2) {
            dayOfWeekJS = "Tue";
        } else if (dayOfWeekJS == 3) {
            dayOfWeekJS = "Wed";
        } else if (dayOfWeekJS == 4) {
            dayOfWeekJS = "Thu";
        } else if (dayOfWeekJS == 5) {
            dayOfWeekJS = "Fri";
        } else if (dayOfWeekJS == 6) {
            dayOfWeekJS = "Sat";
        }

        // Add `0` to day of month if less than 10
        if (dayOfMonthJS < 10) {
            dayOfMonthJS = '0' + dayOfMonthJS;
        }

        // Date format: YYYY-MM-DD
        var date = `${year}-${add0ToMonth(month)}-${dayOfMonthJS}`;

        // time format: HH:MM:SS
        var hours = today.getHours();
        var minutes = today.getMinutes();
        var seconds = today.getSeconds();

        // Add `0` to hours if less than 10
        if (hours < 10) {
            hours = '0' + hours;
        }

        // Add `0` to minutes if less than 10
        if (minutes < 10) {
            minutes = '0' + minutes;
        }

        // Add `0` to seconds if less than 10
        if (seconds < 10) {
            seconds = '0' + seconds;
        }

        // Time format: HH:MM:SS
        var time = hours + ":" + minutes;
        
        // Var full date format
        var displayToday = dayOfWeekJS + ", " + monthToName(month) + " " + dayOfMonthJS;

        // Var Times available for each court
        const startMonThu = "16:00";
        const startMonThuPlus30 = "16:30";
        const endMonThuMinus30 = "21:30";
        const endMonThu = "22:00";

        const startFri = "13:00";
        const startFriPlus30 = "13:30";
        const endFriMinus30 = "15:30";
        const endFri = "16:00";

        const startSat = "18:30";
        const startSatPlus30 = "19:00";
        const endSatMinus30 = "22:00";
        const endSat = "22:30";

        const startSun = "08:00";
        const startSunPlus30 = "08:30";
        const endSunMinus30 = "20:30";
        const endSun = "21:00";

        // Display Start Times
        const displayStartMonThu = "4:00 PM";
        const displayStartFri = "1:00 PM";
        const displayStartSat = "6:30 PM";
        const displayStartSun = "8:00 AM";

        // Loop Break
        var breakLoop = false;

        // DOM elements
        const tennis = document.getElementById("tennisNextAvailableSlot");

        if (month < 10) {
            month = '0' + month;
        }

        // Date format: YYYY-MM-DD PLUS 1 DAY
        if (month == '01' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '02' + "-" + '01';
            var date2 = year + "-" + '03' + "-" + '01';
        } else if (month == '02' && dayOfMonthJS == '28') {
            var date1 = year + "-" + '03' + "-" + '01';
            var date2 = year + "-" + '04' + "-" + '01';
        } else if (month == '03' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '04' + "-" + '01';
            var date2 = year + "-" + '05' + "-" + '01';
        } else if (month == '04' && dayOfMonthJS == '30') {
            var date1 = year + "-" + '05' + "-" + '01';
            var date2 = year + "-" + '06' + "-" + '01';
        } else if (month == '05' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '06' + "-" + '01';
            var date2 = year + "-" + '07' + "-" + '01';
        } else if (month == '06' && dayOfMonthJS == '30') {
            var date1 = year + "-" + '07' + "-" + '01';
            var date2 = year + "-" + '08' + "-" + '01';
        } else if (month == '07' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '08' + "-" + '01';
            var date2 = year + "-" + '09' + "-" + '01';
        } else if (month == '08' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '09' + "-" + '01';
            var date2 = year + "-" + '10' + "-" + '01';
        } else if (month == '09' && dayOfMonthJS == '30') {
            var date1 = year + "-" + '10' + "-" + '01';
            var date2 = year + "-" + '11' + "-" + '01';
        } else if (month == '10' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '11' + "-" + '01';
            var date2 = year + "-" + '12' + "-" + '01';
        } else if (month == '11' && dayOfMonthJS == '30') {
            var date1 = year + "-" + '12' + "-" + '01';
            var date2 = year + "-" + '01' + "-" + '01';
        } else if (month == '12' && dayOfMonthJS == '31') {
            var date1 = year + "-" + '01' + "-" + '01';
            var date2 = year + "-" + '02' + "-" + '01';
        } else {
            var dayOfMonthJSOne = parseInt(dayOfMonthJS) + 1;

            if (dayOfMonthJS < 10) {
                dayOfMonthJSOne = '0' + dayOfMonthJSOne;
            }
            var date1 = year + "-" + month + "-" + dayOfMonthJSOne;
            var date2 = year + "-" + month + "-" + dayOfMonthJS;

        }

        Date.prototype.addDays = function (days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }
        var dateAdd = new Date();
        var tomorrow = dateAdd.addDays(1);
        var afterTomorrow = dateAdd.addDays(2);

        var tomorrowDate = tomorrow.getDate();
        var tomorrowMonth = tomorrow.getMonth() + 1;
        var tomorrowDay = tomorrow.getDay();

        var afterTomorrowDate = afterTomorrow.getDate();
        var afterTomorrowMonth = afterTomorrow.getMonth() + 1;
        var afterTomorrowDay = afterTomorrow.getDay();

        if (tomorrowDay == 0) {
            var tomorrowDay = "Sun";
        } else if (tomorrowDay == 1) {
            var tomorrowDay = "Mon";
        } else if (tomorrowDay == 2) {
            var tomorrowDay = "Tue";
        } else if (tomorrowDay == 3) {
            var tomorrowDay = "Wed";
        } else if (tomorrowDay == 4) {
            var tomorrowDay = "Thu";
        } else if (tomorrowDay == 5) {
            var tomorrowDay = "Fri";
        } else if (tomorrowDay == 6) {
            var tomorrowDay = "Sat";
        }

        if (afterTomorrowDay == 0) {
            var afterTomorrowDay = "Sun";
        } else if (afterTomorrowDay == 1) {
            var afterTomorrowDay = "Mon";
        } else if (afterTomorrowDay == 2) {
            var afterTomorrowDay = "Tue";
        } else if (afterTomorrowDay == 3) {
            var afterTomorrowDay = "Wed";
        } else if (afterTomorrowDay == 4) {
            var afterTomorrowDay = "Thu";
        } else if (afterTomorrowDay == 5) {
            var afterTomorrowDay = "Fri";
        } else if (afterTomorrowDay == 6) {
            var afterTomorrowDay = "Sat";
        }

        var displayTomorrow = `${tomorrowDay}, ${monthToName(tomorrowMonth)} ${tomorrowDate}`;
        var displayAfterTomorrow = `${afterTomorrowDay}, ${monthToName(afterTomorrowMonth)} ${afterTomorrowDate}`;

        // Logic for displaying times available for court
        if (data.length == 0) {
            if (dayOfWeekJS == 'Sun' && time < startSun) {
                tennis.innerHTML = `${displayToday} | ${displayStartSun}`;
            }
            else if (dayOfWeekJS == 'Sun' && time > startSun && time < endSun) {
                tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
            }
            else if (dayOfWeekJS == 'Sun' && time > endSun) {
                tennis.innerHTML = `${displayTomorrow} | ${displayStartMonThu}`;
            }
            else if ((dayOfWeekJS == "Mon" || dayOfWeekJS == "Tue" || dayOfWeekJS == "Wed" || dayOfWeekJS == "Thu") && time <= startMonThu) {
                tennis.innerHTML = `${displayToday} | ${displayStartMonThu}`;
            }
            else if ((dayOfWeekJS == "Mon" || dayOfWeekJS == "Tue" || dayOfWeekJS == "Wed" || dayOfWeekJS == "Thu") && time > startMonThu && time < endMonThu) {
                if (time > endMonThuMinus30) {
                    tennis.innerHTML = displayTomorrow;
                    breakLoop = true;
                } else {
                    tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
                }
            }
            else if ((dayOfWeekJS == "Sun" && time >= endSun) || (dayOfWeekJS == "Mon" && time >= endMonThu) || (dayOfWeekJS == "Tue" && time >= endMonThu) || (dayOfWeekJS == "Wed" && time >= endMonThu)) {
                tennis.innerHTML = `${displayTomorrow} | ${displayStartMonThu}`;
            }
            else if (dayOfWeekJS == "Thu" && time >= endMonThu) { 
                tennis.innerHTML = `${displayTomorrow} | ${displayStartFri}`;
            }
            else if (dayOfWeekJS == "Fri" && time <= startFri) {
                tennis.innerHTML = `${displayToday} | ${displayStartFri}`;
            }
            else if (dayOfWeekJS == "Fri" && time > startFri && time < endFri) {
                tennis.innerHTML = `${displayTomorrow} | ${tConvert(time)}`;
            }
            else if (dayOfWeekJS == "Fri" && time > endFri) {
                tennis.innerHTML = `${displayTomorrow} | ${displayStartSat}`;
            }
            else if (dayOfWeekJS == "Sat" && time <= startSat) {
                tennis.innerHTML = `${displayToday} | ${displayStartSat}`;
            }
            else if (dayOfWeekJS == "Sat" && time > startSat && time < endSat) {
                tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
            }
            else if (dayOfWeekJS == "Sat" && time > endSat) {
                tennis.innerHTML = `${displayTomorrow} | ${displayStartSun}`;
            }
            else {
                tennis.innerHTML = "err";
            }

        } else if (data.length == 1) {

            var startTimeForCurrentReservation = data[0].reservation_start;
            var hourForCurrentReservationStart = startTimeForCurrentReservation.charAt(0) + startTimeForCurrentReservation.charAt(1);
            var minuteForCurrentReservationStart = startTimeForCurrentReservation.charAt(3) + startTimeForCurrentReservation.charAt(4);
            var CurrentReservation = new Date(data[0].reservation_date);
            var yearForCurrentReservation = CurrentReservation.getFullYear();
            var monthForCurrentReservation = CurrentReservation.getMonth();
            var dayForCurrentReservation = CurrentReservation.getDate();
            var startOfCurrentReservation = new Date(yearForCurrentReservation, monthForCurrentReservation, dayForCurrentReservation, hourForCurrentReservationStart, minuteForCurrentReservationStart);
            var gapAfterNow = (startOfCurrentReservation - today) / (1000 * 60);

            function oneReservationCheckBefore (day, startPlus30, endMinus30, startToday, startTomorrow) {
                if (data[0].reservation_date == day) {
                    if (data[0].reservation_start <= startPlus30) {
                        if (data[0].reservation_end <= endMinus30) {
                            tennis.innerHTML = `${displayToday} | ${tConvert(data[0].reservation_end)}`;
                        } else {
                            tennis.innerHTML = `${displayTomorrow} | ${startTomorrow}`;
                        }
                    } else {
                        tennis.innerHTML = `${displayToday} | ${startToday}`;
                    }
                } else {
                    tennis.innerHTML = `${displayToday} | ${startToday}`;;
                }
            }

            function oneReservationCheckAfter (day, startPlus30, endMinus30, startToday, startTomorrow) {
                if (data[0].reservation_date == day) {
                    if (data[0].reservation_start <= startPlus30) {
                        if (data[0].reservation_end <= endMinus30) {
                            tennis.innerHTML = `${displayTomorrow} | ${tConvert(data[0].reservation_end)}`;
                        } else {
                            tennis.innerHTML = `${displayAfterTomorrow} | ${startTomorrow}`;
                        }
                    } else {
                        tennis.innerHTML = `${displayTomorrow} | ${startToday}`;
                    }
                } else {
                    tennis.innerHTML = `${displayTomorrow} | ${startToday}`;;
                }
            }

            function oneReservationCheckInside(day, endMinus30) {
                if (data[0].reservation_date = day) {
                    if (data[0].reservation_end > endMinus30 && gapAfterNow < 30) {
                        tennis.innerHTML = displayTomorrow;
                    }
                    else if (data[0].reservation_start <= time && data[0].reservation_end >= time) {
                        tennis.innerHTML = `${displayToday} | ${tConvert(data[0].reservation_end)}`;
                    } else if (data[0].reservation_end <= time) {
                        tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
                    } else {
                        if (gapAfterNow > 30) {
                            tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
                        } else {
                            tennis.innerHTML = `${displayToday} | ${tConvert(data[0].reservation_end)}`;
                        }
                    }
                } else if (time > endMonThuMinus30) {
                    tennis.innerHTML = displayTomorrow;
                    breakLoop = true;
                } else {
                tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
                }
            }

            if (dayOfWeekJS == 'Sun' && time < startSun) {
                oneReservationCheckBefore (date, startSunPlus30, endSunMinus30, displayStartSun, displayStartMonThu);
            }
            else if (dayOfWeekJS == 'Sun' && time > endSun) {
                oneReservationCheckAfter (date1, startSunPlus30, endMonThuMinus30, displayStartMonThu, displayStartMonThu);
            }
            else if ((dayOfWeekJS == "Mon" || dayOfWeekJS == "Tue" || dayOfWeekJS == "Wed" || dayOfWeekJS == "Thu") && time < startMonThu) {
                oneReservationCheckBefore (date, startMonThuPlus30, endMonThuMinus30, displayStartMonThu, displayStartMonThu);
            }
            else if ((dayOfWeekJS == "Mon" || dayOfWeekJS == "Tue" || dayOfWeekJS == "Wed" || dayOfWeekJS == "Thu") && time >= startMonThu && time <= endMonThu) {
                oneReservationCheckInside (date, endMonThuMinus30);
            }
            else if (dayOfWeekJS == "Fri" && time >= startFri && time <= endFri) {
                oneReservationCheckInside (date, endFriMinus30);
            }
            else if (dayOfWeekJS == "Sat" && time >= startSat && time <= endSat) {
                oneReservationCheckInside (date, endSatMinus30);
            }
            else if (dayOfWeekJS == "Sun" && time >= startSun && time <= endSun) {
                oneReservationCheckInside (date, endSunMinus30);
            }
            else if ((dayOfWeekJS == "Sun" && time > endSun) || (dayOfWeekJS == "Mon" && time > endMonThu) || (dayOfWeekJS == "Tue" && time > endMonThu) || (dayOfWeekJS == "Wed" && time > endMonThu)) {
                oneReservationCheckAfter (date1, startMonThuPlus30, endMonThuMinus30, displayStartMonThu, displayStartMonThu);
            }
            else if (dayOfWeekJS == "Thu" && time > endMonThu) { 
                oneReservationCheckAfter (date1, startFriPlus30, endFriMinus30, displayStartFri, displayStartSat);
            }
            else if (dayOfWeekJS == "Fri" && time < startFri) {
                oneReservationCheckBefore (date, startFriPlus30, endFriMinus30, displayStartFri, displayStartSat);
            }
            else if (dayOfWeekJS == "Fri" && time > endFri) {
                oneReservationCheckAfter (date1, startSatPlus30, endSatMinus30, displayStartSat, displayStartSun);
            }
            else if (dayOfWeekJS == "Sat" && time < startSat) {
                oneReservationCheckBefore (date, startSatPlus30, endSatMinus30, displayStartSat, displayStartSun);
            }
            else if (dayOfWeekJS == "Sat" && time > endSat) {
                oneReservationCheckAfter (date1, startSunPlus30, endSunMinus30, displayStartSun, displayStartMonThu);
            }
            else {
                tennis.innerHTML = "err";
            }
        }
        
        else {
            for (var i = 0; i < data.length; i++) {
                var CurrentReservation = new Date(data[i].reservation_date);
                // Get full date from the current reservation
                if (data[i + 1] != null) {
                    var yearForCurrentReservation = CurrentReservation.getFullYear();
                    var monthForCurrentReservation = CurrentReservation.getMonth();
                    var dayForCurrentReservation = CurrentReservation.getDate();

                    // Get full date from next reservation
                    var dateForNextReservation = new Date(data[i + 1].reservation_date);
                    var yearForForNextReservation = dateForNextReservation.getFullYear();
                    var monthForForNextReservation = dateForNextReservation.getMonth();
                    var dayForNextReservation = dateForNextReservation.getDate();

                    // Get hh:mm from the current reservation end
                    var endTimeForCurrentReservation = data[i].reservation_end;
                    var hourForCurrentReservationEnd = endTimeForCurrentReservation.charAt(0) + endTimeForCurrentReservation.charAt(1);
                    var minuteForCurrentReservationEnd = endTimeForCurrentReservation.charAt(3) + endTimeForCurrentReservation.charAt(4);

                    // Get hh:mm from next reservation start
                    var startTimeForNextReservation = data[i + 1].reservation_start;
                    var hourForNextReservationStart = startTimeForNextReservation.charAt(0) + startTimeForNextReservation.charAt(1);
                    var minuteForNextReservationStart = startTimeForNextReservation.charAt(3) + startTimeForNextReservation.charAt(4);

                    var startTimeForCurrentReservation = data[i].reservation_start;
                    var hourForCurrentReservationStart = startTimeForCurrentReservation.charAt(0) + startTimeForCurrentReservation.charAt(1);
                    var minuteForCurrentReservationStart = startTimeForCurrentReservation.charAt(3) + startTimeForCurrentReservation.charAt(4);

                    var endOfCurrentReservation = new Date(yearForCurrentReservation, monthForCurrentReservation, dayForCurrentReservation, hourForCurrentReservationEnd, minuteForCurrentReservationEnd);
                    var startOfNextReservation = new Date(yearForForNextReservation, monthForForNextReservation, dayForNextReservation, hourForNextReservationStart, minuteForNextReservationStart);
                    var startOfCurrentReservation = new Date(yearForCurrentReservation, monthForCurrentReservation, dayForCurrentReservation, hourForCurrentReservationStart, minuteForCurrentReservationStart);

                    var gapAfterCurrentReservation = (startOfNextReservation - endOfCurrentReservation) / (1000 * 60);
                    var gapAfterNow = (startOfCurrentReservation - today) / (1000 * 60);
                }

                function multiReservationCheckInside (endMinus30) {
                    if (data[i].reservation_date == date && data[i].reservation_start <= time && data[i].reservation_end >= time) {
                        if (gapAfterCurrentReservation > 30) {
                            if (data[i].reservation_end <= endMinus30) {
                                tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i].reservation_end)}`;
                                breakLoop = true;
                            } else {
                                tennis.innerHTML = displayTomorrow;
                                breakLoop = true;
                            }
                        } else {
                            tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i + 1].reservation_end)}`;
                        }
                    } else if (data[i].reservation_date == date && i == 0) {
                        if (gapAfterNow > 30) {
                            tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
                            breakLoop = true;
                        } else if (gapAfterNow <= 30) {
                            if (data[i].reservation_end > endMinus30) {
                                tennis.innerHTML = displayTomorrow;
                                breakLoop = true;
                            } else {
                                if (data[i + 1].reservation_date != date) {
                                    tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i].reservation_end)}`;
                                    breakLoop = true;
                                } else {
                                    tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i + 1].reservation_end)}`;
                                }
                            }
                        }
                    } else if (data[i].reservation_date == date && time <= data[i].reservation_start) {
                        if (gapAfterCurrentReservation > 30) {
                            if (data[i].reservation_end > endMinus30) {
                                tennis.innerHTML = displayTomorrow;
                                breakLoop = true;
                            } else {
                                tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i].reservation_end)}`;
                                breakLoop = true;
                            }
                        } else if (gapAfterCurrentReservation <= 30) {
                            if (data[i].reservation_end > endMinus30) {
                                tennis.innerHTML = displayTomorrow;
                                breakLoop = true;
                            } else {
                                if (data[i + 1].reservation_date != date) {
                                    tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i].reservation_end)}`;
                                    breakLoop = true;
                                } else {
                                    tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i + 1].reservation_end)}`;
                                }
                            }
                        }
                    } else if (time > endMonThuMinus30) {
                        tennis.innerHTML = displayTomorrow;
                        breakLoop = true;
                    } else {
                        tennis.innerHTML = `${displayToday} | ${tConvert(time)}`;
                    }
                }

                function multiReservationCheckBefore(day, startPlus30, endMinus30, startToday) {
                    if (data[i].reservation_date == day) {
                        if (data[i].reservation_start > startPlus30 && i == 0) {
                            tennis.innerHTML = `${displayToday} | ${startToday}`;
                            breakLoop = true;
                        } else if (gapAfterCurrentReservation > 30 && data[i].reservation_end <= endMinus30) {
                            tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i].reservation_end)}`;
                            breakLoop = true;
                        } else if (data[i].reservation_end > endMinus30) {
                            tennis.innerHTML = displayTomorrow;
                            breakLoop = true;
                        } else if (gapAfterCurrentReservation <= 30) {
                            tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i + 1].reservation_end)}`;
                        } else {
                            tennis.innerHTML = "err";
                        }
                    } else {
                        tennis.innerHTML = `${displayToday} | ${startToday}`;
                        breakLoop = true;
                    }
                }

                function multiReservationCheckAfter(day, startPlus30, endMinus30, startToday) {
                    if (data[i].reservation_date == day) {
                        if (data[i].reservation_start > startPlus30 && i == 0) {
                            tennis.innerHTML = `${displayTomorrow} | ${startToday}`;
                            breakLoop = true;
                        } else if (gapAfterCurrentReservation > 30 && data[i].reservation_end <= endMinus30) {
                            tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i].reservation_end)}`;
                            breakLoop = true;
                        } else if (data[i].reservation_end > endMinus30) {
                            tennis.innerHTML = displayAfterTomorrow;
                            breakLoop = true;
                        } else if (gapAfterCurrentReservation <= 30) {
                            tennis.innerHTML = `${setDateFromDatabase(CurrentReservation)}  ${tConvert(data[i + 1].reservation_end)}`;
                        } else {
                            tennis.innerHTML = "err";
                        }
                    } else {
                        tennis.innerHTML = `${displayTomorrow} | ${startToday}`;
                        breakLoop = true;
                    }
                }
            
                // Logic for monday to thursday inside time limit
                if ((dayOfWeekJS == "Mon" || dayOfWeekJS == "Tue" || dayOfWeekJS == "Wed" || dayOfWeekJS == "Thu") && time >= startMonThu && time <= endMonThu) {
                    multiReservationCheckInside(endMonThuMinus30);
                    if (breakLoop == true) {break;}
                }
                // Logic for friday inside time limit
                else if (dayOfWeekJS == "Fri" && time >= startFri && time <= endFri) {
                    multiReservationCheckInside(endFriMinus30);
                    if (breakLoop == true) {break;}
                }
                // Logic for Saturday inside time limit
                else if (dayOfWeekJS == "Sat" && time >= startSat && time <= endSat) {
                    multiReservationCheckInside(endSatMinus30);
                    if (breakLoop == true) {break;}
                }
                // Logic for sunday inside time limit       
                else if (dayOfWeekJS == "Sun" && time <= endSun && time >= startSun) {
                    multiReservationCheckInside(endSunMinus30);
                    if (breakLoop == true) {break;}
                }
                
            
                // Logic for Monday to thursday before time limit
                else if ((dayOfWeekJS == "Mon" || dayOfWeekJS == "Tue" || dayOfWeekJS == "Wed" || dayOfWeekJS == "Thu") && time <= startMonThu) {
                    multiReservationCheckBefore(date, startMonThuPlus30, endMonThuMinus30, displayStartMonThu);
                    if (breakLoop == true) {break;}
                }
                // Logic for Friday before time limit
                else if (dayOfWeekJS == "Fri" && time <= startFri) {
                    multiReservationCheckBefore(date, startFriPlus30, endFriMinus30, displayStartFri);
                    if (breakLoop == true) {break;}
                }
                // Logic for Saturday before time limit
                else if (dayOfWeekJS == "Sat" && time <= startSat) {
                    multiReservationCheckBefore(date, startSatPlus30, endSatMinus30, displayStartSat);
                    if (breakLoop == true) {break;}
                }
                // Logic for Sunday before time limit
                else if (dayOfWeekJS == "Sun" && time <= startSun) {
                    multiReservationCheckBefore(date, startSunPlus30, endSunMinus30, displayStartSun);
                    if (breakLoop == true) {break;}
                }
                
                
                // Logic for Sunday to wednesday after time limit
                else if ((dayOfWeekJS == "Sun" && time >= endSun) || (dayOfWeekJS == "Mon" && time >= endMonThu) || (dayOfWeekJS == "Tue" && time >= endMonThu) || (dayOfWeekJS == "Wed" && time >= endMonThu)) {
                    multiReservationCheckAfter(date1, startMonThuPlus30, endMonThuMinus30, displayStartMonThu);
                    if (breakLoop == true) {break;}
                }
                // Logic for thursday after time limit
                else if (dayOfWeekJS == "Thu" && time >= endMonThu) {
                    multiReservationCheckAfter(date1, startFriPlus30, endFriMinus30, displayStartFri);
                    if (breakLoop == true) {break;}
                }
                // Logic for friday after time limit
                else if (dayOfWeekJS == "Fri" && time >= endFri) {
                    multiReservationCheckAfter(date1, startSatPlus30, endSatMinus30, displayStartSat);
                    if (breakLoop == true) {break;}
                }
                // Logic for saturday after time limit
                else if (dayOfWeekJS == "Sat" && time >= endSat) {
                    multiReservationCheckAfter(date1, startSunPlus30, endSunMinus30, displayStartSun);
                    if (breakLoop == true) {break;}
                }
                
                    
                // Shouldn't be executed unless one of the slots is not mentioned in a if statement above
                else {
                    document.getElementById('tennisNextAvailableSlot').innerHTML = "SomTing Wong end";
                    document.getElementById('tennisNextAvailableSlot').innerHTML = "SomTing Wong end";
                    document.getElementById('tennisNextAvailableSlot').innerHTML = "SomTing Wong end";
                }
        
            }
        }
    }
}


function tConvert(time) {
// Check correct time format and split into components
time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

if (time.length > 1) { // If time format correct
    time = time.slice (1);  // Remove full string match value
    time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
    time[0] = +time[0] % 12 || 12; // Adjust hours
}
return time.join (''); // return adjusted time or original string
}

function setDateFromDatabase(CurrentReservation) {
    var dayOfWeek = CurrentReservation.getDay();
    var dayOfMonth = CurrentReservation.getDate();
    var month = CurrentReservation.getMonth() + 1;

    if (dayOfWeek == 0) {
        dayOfWeek = "Sun";
    } else if (dayOfWeek == 1) {
        dayOfWeek = "Mon";
    } else if (dayOfWeek == 2) {
        dayOfWeek = "Tue";
    } else if (dayOfWeek == 3) {
        dayOfWeek = "Wed";
    } else if (dayOfWeek == 4) {
        dayOfWeek = "Thu";
    } else if (dayOfWeek == 5) {
        dayOfWeek = "Fri";
    } else if (dayOfWeek == 6) {
        dayOfWeek = "Sat";
    }

    return dayOfWeek + ", " + dayOfMonth + " " + monthToName(month);
}

// Convert month number to month name
function monthToName(month) {
    if (month == "01") {
        month = "Jan";
    } else if (month == "02") {
        month = "Feb";
    } else if (month == "03") {
        month = "Mar";
    } else if (month == "04") {
        month = "Apr";
    } else if (month == "05") {
        month = "May";
    } else if (month == "06") {
        month = "Jun";
    } else if (month == "07") {
        month = "Jul";
    } else if (month == "08") {
        month = "Aug";
    } else if (month == "09") {
        month = "Sep";
    } else if (month == "10") {
        month = "Oct";
    } else if (month == "11") {
        month = "Nov";
    } else if (month == "12") {
        month = "Dec";
    }
    return month;
}

//Add `0` to month if less than 10
function add0ToMonth(month) {
    if (month < 10) {
        month = '0' + month;
        return month;
    } else {
        return month;
    }
}