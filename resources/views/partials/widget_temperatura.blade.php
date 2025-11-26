<!-- Widget: Temperatura -->
<style>
    .weather-widget-simple {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .weather-widget-simple .weather-icon {
        font-size: 24px;
    }

    .weather-widget-simple .weather-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .weather-widget-simple .temperature {
        font-size: 18px;
        font-weight: bold;
    }

    .weather-widget-simple .location {
        font-size: 11px;
        opacity: 0.85;
    }
</style>

<div class="weather-widget-simple" id="weatherWidgetSimple">
    <div class="weather-icon" id="weatherIconSimple">🌤️</div>
    <div class="weather-info">
        <div class="temperature" id="temperatureSimple">--°C</div>
        <div class="location">Chihuahua</div>
    </div>
</div>

<script>
    (function() {
        async function obtenerClimaSimple() {
            const tempEl = document.getElementById('temperatureSimple');
            const iconEl = document.getElementById('weatherIconSimple');

            try {
                const lat = 28.6353;
                const lon = -106.0889;

                const response = await fetch(
                    `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code&timezone=America/Chihuahua`
                );

                const data = await response.json();
                const temp = Math.round(data.current.temperature_2m);
                tempEl.textContent = `${temp}°C`;

                const weatherCode = data.current.weather_code;
                iconEl.textContent = getWeatherIconSimple(weatherCode);

            } catch (error) {
                console.error('Error al obtener clima:', error);
                tempEl.textContent = '--°C';
            }
        }

        function getWeatherIconSimple(code) {
            const icons = {
                0: '☀️',
                1: '🌤️',
                2: '⛅',
                3: '☁️',
                45: '🌫️',
                48: '🌫️',
                51: '🌦️',
                53: '🌦️',
                55: '🌧️',
                61: '🌧️',
                63: '🌧️',
                65: '⛈️',
                71: '🌨️',
                73: '🌨️',
                75: '❄️',
                77: '❄️',
                80: '🌦️',
                81: '🌧️',
                82: '⛈️',
                95: '⛈️',
                96: '⛈️',
                99: '⛈️'
            };
            return icons[code] || '🌤️';
        }

        obtenerClimaSimple();
        setInterval(obtenerClimaSimple, 1000);
    })();
</script>
