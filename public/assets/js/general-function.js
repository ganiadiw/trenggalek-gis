function previewAvatar(avatarPreview, avatarFile, event) {
    avatarFile.addEventListener(event, function () {
        const file = this.files[0];

        if (file.type.match(/image\/*/)) {
            const url = URL.createObjectURL(file);
            avatarPreview.src = url;
        }
    });
}
