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

        let isGood = (/\.(?=gif|jpg|png|pdf|jpeg|svg)/gi).test(file.name);
        if (isGood) {
            document.getElementById('response').classList.remove("hidden");
            document.getElementById('notimage').classList.add("hidden");

            if (document.getElementById('file-image')) {
                // Thumbnail Preview
                document.getElementById('file-image').classList.remove("hidden");
                document.getElementById('file-image').style.height="auto";
                document.getElementById('file-image').style.objectFit="cover";
                document.getElementById('file-image').style.width="100%";
                document.getElementById('file-image').src = URL.createObjectURL(file);

                output(
                    '<strong>' + encodeURI(file.name) + '</strong>'
                );
            }

            if (file.type === "application/pdf" && document.getElementById('previewPdf')) {
                document.querySelector('#previewPdf embed').src = URL.createObjectURL(file);
                output(
                    '<span class="text-center text-primary text-hover_underline" data-modal-id="previewPdf"><strong>' + encodeURI(file.name) + '</strong></span>'
                );
                window.initPdfModal(true);
            }

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

window.initPdfModal = (fromUpload = false) => {

    if (fromUpload === true) {
        document.getElementById('modals-wrapper').appendChild(document.getElementById('previewPdf'));
    }

   let openPdfModalBtn = document.querySelectorAll('[data-modal-id="previewPdf"]');
    openPdfModalBtn.forEach(pdfModal => {
       let modal = document.getElementById(pdfModal.dataset.modalId);
       pdfModal.addEventListener('click', () => openCloseModal(modal, document.querySelector('.overlay')));
   })

   window.openCloseModal = (modal, overlay) => {
       modal.classList.toggle('active');
       overlay.classList.toggle('active');
       modal.querySelector('.modal-content').classList.toggle('active');
       let closeBtn = modal.querySelector(".close-layout-modal");

       // Click on close btn ? close modal
       closeBtn.onclick = function() {
           openCloseModal(modal, overlay)
       }
       // Click outside modal ? close modal
       modal.addEventListener('click', (e) => {
           if (e.target === modal) {
               openCloseModal(modal, overlay)
           }
       });
   }
}

if (document.getElementById('previewPdf')) {
    window.initPdfModal();
}
/**************
 * END UPLOAD *
 **************/
