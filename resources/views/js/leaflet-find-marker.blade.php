{{-- It only works by first including leaflet-init.blade.php
Create button with id buttonFindOnMap to use this script --}}
<script>
    let buttonFindOnMap = document.getElementById('buttonFindOnMap')
    let layer

    map.on('click', onMapClick)

    let marker
    let latitudeInput = document.getElementById('latitude')
    let longitudeInput = document.getElementById('longitude')

    function onMapClick(event) {
        let latitude = event.latlng.lat
        let longitude = event.latlng.lng

        if (!marker) {
            marker = L.marker(event.latlng).addTo(map)
        } else {
            marker.setLatLng(event.latlng)
        }

        latitudeInput.value = latitude
        longitudeInput.value = longitude
    }

    buttonFindOnMap.addEventListener('click', function() {
        if (!marker) {
            marker = L.marker([latitudeInput.value, longitudeInput.value]).addTo(map)
        } else {
            marker.setLatLng([latitudeInput.value, longitudeInput.value])
        }
    })
</script>
