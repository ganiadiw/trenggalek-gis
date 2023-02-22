<script>
        function imagePreview(imagePreviewTagName, imageFile, event) {
            imageFile.addEventListener(event, function () {
                const file = this.files[0];

                if (file.type.match(/image\/*/)) {
                    const url = URL.createObjectURL(file);
                    imagePreviewTagName.src = url;
                }
            });
        }
</script>
