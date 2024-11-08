function getWeatherByCity() {
    const city = document.getElementById('address');
    const req = new XMLHttpRequest();
    req.open('GET', `https://api.openweathermap.org/data/2.5/weather?q=${city.value}&units=metric&appid=5913e6cd0e9c8a5932a834daed70615f`, true);
    req.addEventListener('load', () => {
        console.log(req.responseText);
        const weatherData = JSON.parse(req.responseText);

        const temperature = weatherData.main.temp;
        const description = weatherData.weather[0].description;
        const windSpeed = weatherData.wind.speed;
        const humidity = weatherData.main.humidity;
        const cityName = weatherData.name;

        const weatherContainer = document.getElementById('weatherContainer');
        weatherContainer.innerHTML = `
                <h2>Pogoda w ${cityName}</h2>
                <p>Temperatura: ${temperature}°C</p>
                <p>Opis pogody: ${description}</p>
                <p>Prędkość wiatru: ${windSpeed} m/s</p>
                <p>Wilgotność: ${humidity}%</p>`;
    })
    req.send();
}

async function getForeCast() {
    console.log("wchodze w 5d");
    try {
        const city = document.getElementById('address');
        const response = await fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${city.value}&units=metric&appid=5913e6cd0e9c8a5932a834daed70615f`, { method: "GET" });
        const forecastData = await response.json();
        const forecastList = forecastData.list;
        const forecastContainer = document.getElementById('weatherContainer');
        console.log(forecastData);
        forecastList.forEach(forecast => {
            const date = forecast.dt_txt;
            const temperature = forecast.main.temp;
            const description = forecast.weather[0].description;
            const windSpeed = forecast.wind.speed;
            const humidity = forecast.main.humidity;
            forecastContainer.innerHTML += `
            <div>
                <h3>${date}</h3>
                <p>Temperatura: ${temperature}°C</p>
                <p>Opis pogody: ${description}</p>
                <p>Prędkość wiatru: ${windSpeed} m/s</p>
                <p>Wilgotność: ${humidity}%</p>
            </div>`;
        });
    } catch(error){
        console.log(error);
    }

}

document.querySelector("#weather5d").addEventListener("click", async () => await getForeCast() );