function deleteElem(entityId, entityName, elemId, textWarning) {
    Swal.fire({
        title: 'Attention',
        html: textWarning,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#929292',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(window.deleteElemRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Set content type for JSON data
                },
                body: JSON.stringify({ // Convert data object to JSON string
                    entityId: entityId,
                    entityName: entityName
                }),
                async: true // Keep async behavior for consistency
            })
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    Swal.fire(
                        'C\'est fait !',
                        data.successDeleteMsg,
                        'success'
                    );
                    document.getElementById(elemId).remove();
                })
                .catch(error => {
                    // Handle errors, e.g., display an error message
                    console.error('Error:', error);
                });
        }
    })
}

// Toast function
function toastFn({ title = "", message = "", type = "info", duration = 3000 }) {
    const main = document.getElementById("toast");

    console.log(duration)

    if (main) {
        const toast = document.createElement("div");

        // Auto remove toast
        const autoRemoveId = setTimeout(function () {
            main.removeChild(toast);
        }, duration + 1000);

        // Remove toast when clicked
        toast.onclick = function (e) {
            if (e.target.closest(".toast__close")) {
                main.removeChild(toast);
                clearTimeout(autoRemoveId);
            }
        };

        const icons = {
            success: "check_circle",
            info: "info",
            warning: "warning",
            error: "error"
        };
        const icon = icons[type];
        console.log(icon, type)
        const delay = (duration / 1000).toFixed(2);

        toast.classList.add("toast", `toast--${type}`, 'show');
        toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

        toast.innerHTML = `
                    <div class="toast__icon">
                        <i class="material-icons">${icon}</i>
                    </div>
                    <div class="toast__body">
                        <h3 class="toast__title">${title}</h3>
                        <p class="toast__msg">${message}</p>
                    </div>
                    <div class="toast__close">
                        <i class="material-icons">close</i>
                    </div>
                `;
        main.appendChild(toast);
    }
}


document.querySelectorAll('.toast-alert').forEach(toastAlert => {
    // setTimeout(() => {
        toastFn({
            title: toastAlert.dataset.toastTitle,
            message: toastAlert.dataset.toastMessage,
            type: toastAlert.dataset.toastType,
            duration: toastAlert.dataset.toastDuration
        });
    // }, 150);
});

// INPUT UI
const inputsText = document.querySelectorAll('input[type=text], input[type="number"]') ?? false;

if (inputsText) {
    inputsText.forEach( (input) => {
        if(input.value) {
            input.parentNode.classList.add('is-filled');
        }
    });
}

document.querySelectorAll('input[type="date"]').forEach(input => {
    input.parentNode.classList.add('is-filled');
});

document.querySelectorAll('.input-group').forEach(group => {
    let errorToRemove = group.querySelector('ul')
    if (errorToRemove)
        errorToRemove.remove();
});
// -- END INPUT UI

// SCROLL TO NAV ACTIVE
document.querySelectorAll('.nav-item').forEach(navItem => {
    let link = navItem.querySelector('a');
    if (link && link.classList.contains('bg-gradient-primary')) {
        let top = link.offsetTop;
        document.getElementById('sidenav-collapse-main').scrollTo({
            top: top - 200,
            behavior: "smooth",
        })
    }
})
// -- END SCROLL TO NAV ACTIVE
