@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Canchas cerca de ti</h3>
    <div class="card mb-3">
        <div class="card-body row g-2">
            <div class="col-md-3">
                <label>Radio (km)</label>
                <input type="range" id="radio" min="1" max="20" value="5"
                    class="form-range">
                <small><span id="radioValue">5</span> km</small>
            </div>

            <div class="col-md-3">
                <label>Tipo de cancha</label>
                <select id="tipo" class="form-select">
                    <option value="">Todas</option>
                    <option value="futbol">Fútbol</option>
                    <option value="voley">Voley</option>
                    <option value="polideportivo">Polideportivo</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Precio máx (S/)</label>
                <input type="number" id="precio" class="form-control" placeholder="Ej: 100">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100" onclick="aplicarFiltros()">
                    Buscar canchas
                </button>
            </div>
        </div>
    </div>
    <button class="btn btn-primary mb-3" onclick="getUserLocation()">
        Usar mi ubicación
    </button>

    <div id="map" style="height: 400px; width: 100%;"></div>
</div>
@endsection

<script>
let map;
let userMarker;
let canchaMarkers = [];

function initMap() {
    // Mapa inicial (Lima por defecto)
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -12.0464, lng: -77.0428 },
        zoom: 13
    });
}

function getUserLocation() {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const location = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(location);

            userMarker = new google.maps.Marker({
                map,
                position: location,
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                title: 'Tu ubicación'
            });

            cargarCanchas(location.lat, location.lng);
        },
        () => alert('No se pudo obtener tu ubicación')
    );
}

document.getElementById('radio').addEventListener('input', e => {
    document.getElementById('radioValue').innerText = e.target.value;
});

function aplicarFiltros() {
    if (!userMarker) {
        alert('Primero obten tu ubicación');
        return;
    }

    const pos = userMarker.getPosition();

    cargarCanchas(
        pos.lat(),
        pos.lng(),
        document.getElementById('radio').value,
        document.getElementById('tipo').value,
        document.getElementById('precio').value
    );
}
function cargarCanchas(lat, lng, radio = 5, tipo = '', precio = '') {
    const params = new URLSearchParams({
        lat, lng, radio, tipo, precio
    });

    fetch(`/explorar/canchas-cercanas?${params}`)
        .then(res => res.json())
        .then(empresas => {
            limpiarMarkers();

            empresas.forEach(empresa => {
                const marker = new google.maps.Marker({
                    map,
                    position: {
                        lat: parseFloat(empresa.latitud),
                        lng: parseFloat(empresa.longitud)
                    },
                    title: empresa.nombre
                });

                marker.addListener('click', () => {
                    new google.maps.InfoWindow({
                        content: `
                            <strong>${empresa.nombre}</strong><br>
                            ${empresa.canchas.map(c =>
                                `${c.nombre} - S/ ${c.precio_hora}`
                            ).join('<br>')}
                        `
                    }).open(map, marker);
                });

                canchaMarkers.push(marker);
            });
        });
}

function limpiarMarkers() {
    canchaMarkers.forEach(m => m.setMap(null));
    canchaMarkers = [];
}
window.onload = initMap;
</script>

