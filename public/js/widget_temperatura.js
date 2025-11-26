// ===== TEMPERATURA =====
async function obtenerTemperatura() {
    try {
        // Usando OpenWeatherMap API gratuita
        // Coordenadas de Ciudad Juárez: 31.6904, -106.4245
        const apiKey = "TU_API_KEY"; // Necesitas registrarte en openweathermap.org
        const lat = 31.6904;
        const lon = -106.4245;

        // Alternativa: usando wttr.in (no requiere API key)
        const response = await fetch(`https://wttr.in/Ciudad_Juarez?format=j1`);
        const data = await response.json();

        const tempC = data.current_condition[0].temp_C;
        const descripcion =
            data.current_condition[0].lang_es?.[0]?.value ||
            data.current_condition[0].weatherDesc[0].value;

        document.getElementById("temperatura").innerHTML = `
                    <span class="font-bold">${tempC}°C</span>
                    <span class="text-xs text-gray-500 ml-1">${descripcion}</span>
                `;
    } catch (error) {
        console.error("Error al obtener temperatura:", error);
        document.getElementById("temperatura").innerHTML =
            '<span class="text-xs text-red-500">No disponible</span>';
    }
}

obtenerTemperatura();
setInterval(obtenerTemperatura, 600000); // Actualizar cada 10 minutos
