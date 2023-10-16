document.addEventListener('DOMContentLoaded', function () {
    const weatherForm = document.getElementById('weatherForm');
    const weatherContainer = document.getElementById('weatherContainer');

    weatherForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const city = document.getElementById('city').value;

        fetch(`get_weather.php?city=${city}`)
            .then(response => response.json())
            .then(data => {
                const { name, main, weather } = data;
                weatherContainer.innerHTML = `
                    <h2>Previsão do Tempo para ${name}</h2>
                    <p>Temperatura: ${main.temp}°C</p>
                    <p>Condição: ${weather[0].description}</p>
                `;
                weatherContainer.style.display = 'block';
            })
            .catch(error => {
                console.error('Erro ao buscar previsão do tempo:', error);
            });
    });
});
