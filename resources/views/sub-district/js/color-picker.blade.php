<script>
    let subDistrictFillColor = document.getElementById('subDistrictFillColor');
    let defaultColor;

    @if (request()->routeIs('dashboard.sub-districts.create'))
        defaultColor = '{{ old('fill_color', '#C5A516') }}';
    @elseif (request()->routeIs('dashboard.sub-districts.edit'))
        defaultColor = '{{ old('fill_color', $subDistrict->fill_color) }}';
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
