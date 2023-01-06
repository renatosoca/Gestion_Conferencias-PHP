if (document.querySelector('#mapa')) {
    
    const latitud =-12.014044;
    const longitud = -76.899158
    const zoom = 17

    const map = L.map('mapa').setView([latitud, longitud], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitud, longitud]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Centro del Zoologico</p>
        `)
        .openPopup();
}