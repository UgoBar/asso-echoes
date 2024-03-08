/**********
 * UPLOAD *
 *********/
function ekUpload(){
    function Init() {

        const dropZones   = document.querySelectorAll('.drop-zone');
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
            // Prevent further processing if file is too large
            if (!checkFileSize(f)) {
                return;
            }

            // Update input value
            const input = document.querySelector('input[type=file]');
            input.files = files; // Set the FileList object to the input

            parseFile(f);
            uploadFile(f);
        }
    }

    function checkFileSize(file) {
        const fileSizeLimit = 2097152; // In Octets (2 MB)

        if (file.size > fileSizeLimit) {
            Swal.fire({
                icon: "error",
                text: `Fichier trop volumineux (${convertOctetInMo(file.size)} Mo). Taille max : 2 Mo`,
            });
            return false; // Indicate file size exceeded
        }
        return true; // Indicate file size is within limit
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
        let imageName = file.name;

        let isGood = (/\.(?=gif|jpg|png|pdf|jpeg|svg)/gi).test(imageName);
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
            // document.querySelector('form')
        }
    }

    function uploadFile(file) {

        let xhr = new XMLHttpRequest(),
            fileSizeLimit = 2097152; // In Octet
        if (xhr.upload) {
            // Check if file is less than size limit
            if (file.size > fileSizeLimit) {
                Swal.fire({
                    icon: "error",
                    text: `Fichier trop volumineux (${convertOctetInMo(file.size)} Mo). Taille max : 2 Mo`,
                });
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

function convertOctetInMo(octets) {
    return (octets / 1024 / 1024).toFixed(1);
}
/**************
 * END UPLOAD *
 **************/
