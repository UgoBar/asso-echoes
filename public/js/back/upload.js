/**********
 * UPLOAD *
 *********/
function ekUpload(){
    function Init() {

        let fileSelect    = document.querySelector('input[type=file]'),
            fileDrag      = document.getElementById('fileDrag'),
            submitButton  = document.querySelector('input[type=submit]');

        fileSelect.addEventListener('change', fileSelectHandler, false);

        // Is XHR2 available?
        let xhr = new XMLHttpRequest();
        if (xhr.upload) {
            // File Drop
            fileDrag.addEventListener('dragover', fileDragHover, false);
            fileDrag.addEventListener('dragleave', fileDragHover, false);
            fileDrag.addEventListener('drop', fileSelectHandler, false);
        }
    }

    function fileDragHover(e) {
        let fileDrag = document.getElementById('file-drag');

        e.stopPropagation();
        e.preventDefault();
    }

    function fileSelectHandler(e) {
        // Fetch FileList object
        let files = e.target.files || e.dataTransfer.files;

        // Cancel event and hover styling
        fileDragHover(e);

        // Process all File objects
        for (let i = 0, f; f = files[i]; i++) {
            parseFile(f);
            uploadFile(f);
        }
    }

    // Output
    function output(msg) {
        // Response
        let m = document.getElementById('messages');
        m.innerHTML = msg;
    }

    function parseFile(file) {

        output(
            '<strong>' + encodeURI(file.name) + '</strong>'
        );

        // let fileType = file.type;
        // console.log(fileType);
        let imageName = file.name;

        let isGood = (/\.(?=gif|jpg|png|pdf|jpeg)/gi).test(imageName);
        if (isGood) {
            document.getElementById('response').classList.remove("hidden");
            document.getElementById('notimage').classList.add("hidden");
            // Thumbnail Preview
            document.getElementById('file-image').classList.remove("hidden");
            //document.getElementById('file-image').style.height="200px";
            document.getElementById('file-image').style.width="100%";
            document.getElementById('file-image').src = URL.createObjectURL(file);
        }
        else {
            document.getElementById('file-image').classList.add("hidden");
            document.getElementById('notimage').classList.remove("hidden");
            document.getElementById('start').classList.remove("hidden");
            document.getElementById('response').classList.add("hidden");
            document.getElementById("file-upload-form").reset();
        }
    }

    function uploadFile(file) {

        let xhr = new XMLHttpRequest(),
            fileSizeLimit = 1024; // In MB
        if (xhr.upload) {
            // Check if file is less than x MB
            if (file.size <= fileSizeLimit * 1024 * 1024) {
                // Start upload
                xhr.open('POST', document.getElementById('file-upload-form').action, true);
                xhr.setRequestHeader('X-File-Name', file.name);
                xhr.setRequestHeader('X-File-Size', file.size);
                xhr.setRequestHeader('Content-Type', 'multipart/form-data');
                xhr.send(file);
            } else {
                output('Please upload a smaller file (< ' + fileSizeLimit + ' MB).');
            }
        }
    }

    // Check for the letious File API support.
    if (window.File && window.FileList && window.FileReader) {
        Init();
    } else {
        document.getElementById('file-drag').style.display = 'none';
    }
}
ekUpload();
/**************
 * END UPLOAD *
 **************/
