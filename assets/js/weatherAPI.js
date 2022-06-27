// https://api.openweathermap.org/data/2.5/forecast?lat=33.87291446513183&lon=35.56785370992055&units=metric&appid=d94bc060ee72eaee70451044008e234b
//Weather data API forecast above instead of weather for detailed weather for every 3 hours.!
let weather = {
    apiKey: "d94bc060ee72eaee70451044008e234b",
    fetchWeather: function () {
        fetch(`https://api.openweathermap.org/data/2.5/weather?lat=33.87291446513183&lon=35.56785370992055&units=metric&appid=d94bc060ee72eaee70451044008e234b`)
            .then((response) => response.json())
            .then((data) => this.displayWeather(data));
    },

    displayWeather: function (data) {
        const { icon, description } = data.weather[0];
        const { temp, humidity } = data.main;
        const { speed } = data.wind;

        const allicons = document.querySelectorAll(".icon");
        allicons.forEach((element1) => {
            element1.src = "http://openweathermap.org/img/wn/" + icon + ".png";
        });

        const alldescriptions = document.querySelectorAll(".description");
        alldescriptions.forEach((element2) => {
            element2.innerText = description.toUpperCase();
        });

        const alltemp = document.querySelectorAll(".temp");
        alltemp.forEach((element3) => {
            element3.innerText = Math.round(temp) + " °C";
        });

        const allhumidity = document.querySelectorAll(".humidity");
        allhumidity.forEach((element4) => {
            element4.innerText = "Humidity: " + humidity + " %";
        });

        const allspeed = document.querySelectorAll(".speed");
        allspeed.forEach((element5) => {
            element5.innerText = "Wind Speed: " + Math.round(speed * 3.6) + " km/h";
        });
    },
};
weather.fetchWeather();


