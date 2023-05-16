<script>
    let subDistrictInput = document.getElementById('sub_district_id');
    let subDistricts = @json($subDistricts);
    let subDistrict;

    if (subDistrictInput.value !== '') {
        subDistrict = subDistricts.find(object => object.id === parseInt(subDistrictInput.value));

        layer = new L.GeoJSON.AJAX(['{{ asset('storage/geojson/') }}' + '/' + subDistrict.geojson_name], {
                style: {
                    'color': subDistrict.fill_color,
                    'weight': 2,
                    'opacity': 0.4,
                }
            }).addTo(map);
            map.setView([subDistrict.latitude, subDistrict.longitude], 11);
    }

    subDistrictInput.addEventListener('change', function() {
        let subDistrict = subDistricts.find(object => object.id === parseInt(subDistrictInput.value));

        if (layer) {
            map.removeLayer(layer)
        }

        layer = new L.GeoJSON.AJAX(['{{ asset('storage/geojson/') }}' + '/' + subDistrict.geojson_name], {
            style: {
                'color': subDistrict.fill_color,
                'weight': 2,
                'opacity': 0.4,
            }
        }).addTo(map);
        map.setView([subDistrict.latitude, subDistrict.longitude], 11);
    });
</script>
