document.addEventListener('DOMContentLoaded', initGallery);

if (document.querySelector('navigate-js').classList.contains('njs-page-loaded')) {
    initGallery();
}

function initGallery() {

    const gallery = document.getElementById("gallery");
    let galleryModal = document.querySelector('.gallery-modal');
    let mainOverlay = document.querySelector('.gallery-overlay');
    let replacePicture = document.getElementById('picture-replace');
    let index, prevIndex, nextIndex;
    const previousBtn = document.querySelector('.gallery-modal .previous');
    const nextBtn = document.querySelector('.gallery-modal .next');

    for (let i = gallery.children.length; i >= 0; i--) {
        gallery.appendChild(gallery.children[Math.random() * i | 0]);
    }

    const pictures = document.querySelectorAll('#gallery figure');
    const picturesArray = Array.from(pictures)

    pictures.forEach(picture => {
        picture.addEventListener('click', () => showPicture(picture) );
    });

    function showPicture(picture) {
        replacePicture.src = picture.querySelector('img').src;
        openCloseModal(galleryModal, mainOverlay);
        index = picturesArray.indexOf(picture);
        defineIndexes(index);
    }

    function defineIndexes(index) {
        // define previous
        prevIndex = index === 0 ? picturesArray.length - 1 : index - 1;
        // define next index
        nextIndex = index === picturesArray.length - 1 ? 0 : index + 1;
    }

    // Close modal btn
    document.querySelector('.close-gallery-modal').onclick = function() {
        openCloseModal(galleryModal, mainOverlay)
    }

    // Click outside ? close modal
    galleryModal.onclick = function(event) {
        if (event.target === galleryModal) {
            openCloseModal(galleryModal, mainOverlay)
        }
    }

    previousBtn.addEventListener('click', () => {
        index = (index - 1 < 0) ? picturesArray.length - 1 : index - 1;
        defineIndexes(index)
        animateChange(prevIndex);
    });
    nextBtn.addEventListener('click', () => {
        index = (index + 1 > picturesArray.length - 1) ? 0 : index + 1;
        defineIndexes(index);
        animateChange(nextIndex);
    });

    function animateChange(index) {
        // fade out current image
        galleryModal.querySelector('.modal-content').classList.add('opacity-0');

        // fade in next image
        setTimeout(() => {
            replacePicture.src = picturesArray[index].querySelector('img').src;
            galleryModal.querySelector('.modal-content').classList.remove('opacity-0')
        }, 300)
    }
}
