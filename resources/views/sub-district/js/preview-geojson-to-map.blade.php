<script>
    function previewGeoJSONToMap(geoJSON) {
        const data = JSON.parse(geoJSON)

        if (layer) {
            map.removeLayer(layer)
            map.removeLayer(marker)
        }

        layer = L.geoJSON(data, {
            style: function(feature) {
                return {
                    color: subDistrictFillColor.value,
                    weight: 2,
                    opacity: 0.4,
                }
            }
        }).addTo(map)

        let bounds = layer.getBounds()
        map.fitBounds(bounds)
        let center = bounds.getCenter()
        marker = L.marker(center).addTo(map)
        latitudeInput.value = center.lat
        longitudeInput.value = center.lng
    }

    let geojsonFile = document.getElementById('geojsonFile')

    geojsonFile.addEventListener('change', function() {
        const file = geojsonFile.files[0]
        const reader = new FileReader()

        reader.onload = function() {
            previewGeoJSONToMap(reader.result)
            document.getElementById('geoJSONTextArea').value = ''
        }
        reader.readAsText(file)
    })

    let buttonGeoJSONText = document.getElementById('buttonGeoJSONText')

    buttonGeoJSONText.addEventListener('click', function() {
        let geoJSONTextArea = document.getElementById('geoJSONTextArea')
        let badGeoJSON = geoJSONTextArea.value
        let parseGeoJSON = JSON.parse(badGeoJSON)
        let geoJSONPrettyFormat = JSON.stringify(parseGeoJSON, undefined, 2)
        geoJSONTextArea.value = geoJSONPrettyFormat

        geojsonFile.value = ''
        previewGeoJSONToMap(geoJSONPrettyFormat)
    })
</script>
