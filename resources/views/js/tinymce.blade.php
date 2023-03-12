<script>
    $(window).on('load', function () {
        $("#spinner").fadeOut(1000);
    })

    let uploadedImage = [];
    const image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', "{{ route('dashboard.images.store') }}");
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }

            const json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
            }

            resolve(json.location);
            uploadedImage.push(json.filename);
            localStorage.setItem('uploaded-images', JSON.stringify(uploadedImage));
        };

        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('image', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    });

    let mediaFiles = document.getElementById('mediaFiles');

    tinymce.init({
        selector: 'textarea#description',
        plugins: 'save autosave anchor autolink charmap codesample emoticons image link lists searchreplace table visualblocks wordcount fullscreen preview',
        toolbar: 'fullscreen undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap visualblocks | removeformat preview',
        referrer_policy: 'origin',
        promotion: false,
        setup: (editor) => {
            let imageFilesInit = [];
            let editorContentInit;
            editor.on('init', () => {
                editorContentInit = tinymce.activeEditor.getContent();

                if (localStorage.getItem('uploaded-images')) {
                    localStorage.removeItem('uploaded-images');
                }

                $(editorContentInit).find('img').each(function(){
                    let imgSrcInit = $(this).attr('src');
                    let imgTitleInit = $(this).attr('title');
                    let imgFilenameInit = imgSrcInit.split('/').pop();
                    imageFilesInit.push(imgFilenameInit);
                });
            });

            editor.on('blur', () => {
                let imageFiles = [];
                let unusedImages = [];
                let editorContent = tinymce.activeEditor.getContent();

                $(editorContent).find('img').each(function(){
                    let imgSrc = $(this).attr('src');
                    let imgTitle = $(this).attr('title');
                    let imgFilename = imgSrc.split('/').pop();
                    imageFiles.push(imgFilename);
                });

                if (imageFilesInit.length > 0) {
                    let filterredArray1 = imageFilesInit.filter(item => !imageFiles.includes(item));

                    if (filterredArray1.length > 0) {
                        filterredArray1.forEach(item => {
                            unusedImages.push(item);
                        })
                    }
                }

                if (localStorage.getItem('uploaded-images') != null) {
                    let filterredArray2 = JSON.parse(localStorage.getItem('uploaded-images')).filter(item => !imageFiles.includes(item));

                    if (filterredArray2.length > 0) {
                        filterredArray2.forEach(item => {
                            unusedImages.push(item);
                        })
                    }
                }

                mediaFiles.value = JSON.stringify({
                    used_images: imageFiles.map(item => ({filename: item})),
                    unused_images: unusedImages.map(item => ({filename: item}))
                });
            });
        },
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: image_upload_handler,
        image_advtab: true,
        image_description: false,
        image_uploadtab: false,
        images_file_types: 'png,jpg,jpeg,gif',
        image_caption: true,
        color_map: [
            '000000', 'Black',
            '808080', 'Gray',
            'FFFFFF', 'White',
            'FF0000', 'Red',
            'FFFF00', 'Yellow',
            '008000', 'Green',
            '0000FF', 'Blue'
        ],
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    const id = 'image' + (new Date()).getTime();
                    const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), { title: file.name });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
    });

    window.addEventListener('beforeunload', (event) => {
        if (tinymce.activeEditor.isDirty()) {
            JSON.parse(localStorage.getItem('uploaded-images')).map(item => {
                $.ajax({
                    url: '/dashboard/images/' + item,
                    type: 'DELETE'
                })
            })

            tinymce.activeEditor.setContent('');

            localStorage.removeItem('uploaded-images');
        }
    });
</script>
