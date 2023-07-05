<script>
    let markerTextColor = document.getElementById('markerTextColor');
    let defaultColor = '#C5A516';

    @if (request()->routeIs('dashboard.categories.create'))
        if (markerTextColor.value !== '') {
            defaultColor = '{{ old('marker_text_color') }}';
        }
    @elseif (request()->routeIs('dashboard.categories.edit'))
        if (markerTextColor.value !== '') {
            defaultColor = '{{ old('marker_text_color', $category->marker_text_color) }}';
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
        markerTextColor.value = hexColor
        pickr.hide()
    })
</script>
