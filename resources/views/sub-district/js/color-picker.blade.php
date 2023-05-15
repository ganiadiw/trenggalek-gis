<script>
    let subDistrictFillColor = document.getElementById('subDistrictFillColor');
    let defaultColor = '#C5A516';

    @if (request()->routeIs('dashboard.sub-districts.create'))
        if (subDistrictFillColor.value !== '') {
            defaultColor = '{{ old('fill_color') }}';
        }
    @elseif (request()->routeIs('dashboard.sub-districts.edit'))
        if (subDistrictFillColor.value !== '') {
            defaultColor = '{{ old('fill_color', $subDistrict->fill_color) }}';
        }
    @endif

    const pickr = Pickr.create({
        el: '.color-picker',
        theme: 'nano',
        default: defaultColor,

        swatches: [
            '#059669',
            '#0284c7',
            '#8b5cf6',
            '#db2777',
            '#84cc16',
            '#fbbf24',
            '#78716c',
        ],

        components: {
            preview: true,
            opacity: false,
            hue: true,

            interaction: {
                hex: false,
                rgba: false,
                hsla: false,
                hsva: false,
                cmyk: false,
                input: true,
                clear: false,
                save: true,
            }
        }
    });

    pickr.on('save', (color, instance) => {
        const hexColor = color.toHEXA().toString()
        subDistrictFillColor.value = hexColor
        if (layer) {
            layer.setStyle({
                'color': hexColor,
                'weight': 2,
                'opacity': 0.4,
            })
        }
        pickr.hide()
    })
</script>
