import { NavigateJs } from './Navigate.js';
import { CountUp } from './CountUp.js';

document.addEventListener("DOMContentLoaded", function () {
    let lastScrollTop  = 0,
        newsletterForm = document.getElementById('newsletter-form'),
        isMobile       = false;

    function revealElem(init, elem, forSvg) {

        if (typeof init === "object") {
            let windowHeight = window.innerHeight;
            let elementTop = elem.getBoundingClientRect().top;
            let elementVisible = 50;
            if (elementTop < windowHeight - elementVisible) {

                elem.classList.add(forSvg ? "animated" : "active");
            } else {
                elem.classList.remove(forSvg ? "animated" : "active");
            }
        }

        if (init === true && window.innerHeight - elem.getBoundingClientRect().top > 150) {
            elem.classList.add(forSvg ? "animated" : "active");
        }
    }

    function scrollEvents(init = false) {
        reveal(init);
        showOrHideHeader();
    }

    function reveal(init = false) {
        // Animate svg
        document.querySelectorAll('.animated-svg').forEach(svg => {
            revealElem(init, svg, true);
        });
        // Animate .reveal-type
        document.querySelectorAll(".reveal-type").forEach(reveal => {
            revealElem(init, reveal, false);
        });
    }

    function showOrHideHeader() {
        if (document.getElementById('menu').classList.contains('active')) {
            return;
        }

        let currentScrollTop = window.scrollY;

        let headerSize = isMobile ? 85 + 51 : 85;

        if (currentScrollTop > headerSize && currentScrollTop > lastScrollTop) {
            // Scrolling down, hide the header
            document.querySelector("header").style.transform = "translateY(-100%)";
        } else {
            // Scrolling up, show the header
            document.querySelector("header").style.transform = "translateY(0)";
        }

        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
    }

    function counterUp() {

        document.querySelectorAll('.count').forEach(countUpEl => {
            const endVal = +countUpEl.getAttribute('data-end');
            const timeData = +countUpEl.getAttribute('data-second-duration');

            if (isNaN(endVal) || isNaN(timeData)) {
                console.error('data-count or data-second-duration is null');
                return;
            }

            const countUp = new CountUp(countUpEl, endVal, {
                useEasing: true,
                enableScrollSpy: true,
                duration: timeData,
            });

            if (!countUp.error) {
                countUp.start();
            } else {
                console.error(countUp.error);
            }
        });
    }

    // BURGER MENU ANIMATION
    let trigger = document.querySelector('#burger'),
        menu = document.querySelector('#menu'),
        overlay = document.querySelector('.overlay'),
        menuOpen = false;

    trigger.addEventListener('click', function () {
        burgerTime();
    });

    window.burgerTime = () => {
        menuOpen = !menuOpen;
        // Hide or show menu
        overlay.classList.toggle('active');
        menu.classList.toggle('active');

        if (document.querySelector('.app') !== null) {
            document.querySelector('.app').classList.toggle('negative-index');
        }

        if (menuOpen) {
            // When open
            trigger.classList.remove('is-closed');
            trigger.classList.add('is-open');
            document.body.classList.add("no-scroll");
            menu.style.position = "fixed";
        } else {
            // When close
            trigger.classList.remove('is-open');
            trigger.classList.add('is-closed');
            document.body.classList.remove("no-scroll");

            // 500ms match menu animation time in style.css under #menu : transition: .5s cubic-bezier(.74,.08,.51,.95);
            setTimeout(() => {
                menu.style.position = "absolute";
            }, 500)
        }
    }

    // On click on the overlay
    overlay.addEventListener('click', (e) => {
        if(overlay.classList.contains('active')) {
            burgerTime();
        }
    })


    // Layout Modal
    window.closeLayoutModal = () => {
        document.querySelectorAll('.layout-modal').forEach(modal => {
            let closeBtn = modal.querySelector(".close-layout-modal");

            // Click on close btn ? close modal
            closeBtn.onclick = function() {
                openCloseModal(modal, overlay)
            }

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    openCloseModal(modal, overlay)
                }
            });
        });
    }

    window.openCloseModal = (modal, overlay) => {
        modal.classList.toggle('active');
        overlay.classList.toggle('active');
        modal.querySelector('.modal-content').classList.toggle('active');
    }

    if (window.innerWidth < 650) {

        isMobile = true;

        // Event open sub nav
        document.querySelectorAll('.menu-title').forEach(menuTitle => {
            menuTitle.addEventListener('click', () => {
                menuTitle.parentNode.querySelector('.nav-links').classList.toggle('active');
                document.querySelectorAll('.menu-title').forEach(titles => {
                    titles.classList.toggle('inactive');
                });
            })
        });

        // Event close sub nav
        document.querySelectorAll('.go-back-mobile-nav').forEach(goBackBtn => {
            goBackBtn.addEventListener('click', () => {
                goBackBtn.parentElement.classList.toggle('active');
                document.querySelectorAll('.menu-title').forEach(titles => {
                    titles.classList.toggle('inactive');
                });
            });
        });
    }

    // Event open/close layout modal
    function initModalEvents() {
        document.querySelectorAll('[data-modal-id]').forEach(btn => {
            let modal = document.getElementById(btn.dataset.modalId);
            btn.addEventListener('click', () => openCloseModal(modal, overlay));
        });
        closeLayoutModal();
    }

    function initApp() {

        new NavigateJs({
            animationType: 'slide',
            animationDuration: 500,
            navigateJsCss: {
                'position': 'relative',
                'width': '100%',
                'display': 'block',
            }
        });

        scrollEvents(true);
        counterUp();
        initModalEvents();

        window.addEventListener("scroll", scrollEvents);

        document.addEventListener('njs:start', function (event) {
            if (document.getElementById('menu').classList.contains('active')) {
                burgerTime();
            }
        });

        document.addEventListener('njs:done', function (event) {
            scrollEvents(true);
            counterUp();
        });

        document.querySelectorAll('.toast-alert').forEach((toastAlert, index) => {
            setTimeout(() => {
                toast({
                    title: toastAlert.dataset.toastTitle,
                    message: toastAlert.dataset.toastMessage,
                    type: toastAlert.dataset.toastType,
                    duration: toastAlert.dataset.toastDuration
                });
            }, 150);
        });

        document.getElementById('newsletter-form').addEventListener('submit', function (e) {
            e.preventDefault();
            addContactToNewsletter();
        });
    }

    function addContactToNewsletter() {
        const email = newsletterForm.querySelector('#newsletter-email');
        let modal = document.getElementById('newsletter-modal');
        let overlay = document.querySelector('.overlay');

        // Verify email
        if (!isValidEmail(email.value)) {
            toast({title: 'Erreur', message: 'Email invalide', type: 'error', duration: 10000});
            return;
        }

        // Add contact to newsletter
        const formData = new FormData(newsletterForm);
        let route = newsletterForm.getAttribute('data-route');

        fetch(route, { method: 'POST', body: formData }).then((response) => {
            if (response.ok) {
                // Show success notification
                toast({title: 'Super !', message: "Votre email a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.", type: 'success', duration: 10000});
            } else {
                // Show error notification
                toast({title: 'Oups', message: 'Une erreur s\'est produite', type: 'error', duration: 10000});
            }
        });

        // Close modal
        openCloseModal(modal, overlay);
    }

    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    initApp();
});
// -- [END] DOM CONTENT LOADED


// Toast function
window.toast = ({ title = "", message = "", type = "info", duration = 3000 }) => {
    const main = document.getElementById("toast");
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
            success: "fas fa-check-circle",
            info: "fas fa-info-circle",
            warning: "fas fa-exclamation-circle",
            error: "fas fa-exclamation-circle"
        };
        const icon = icons[type];
        const delay = (duration / 1000).toFixed(2);

        toast.classList.add("toast", `toast--${type}`);
        toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

        toast.innerHTML = `
                    <div class="toast__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="toast__body">
                        <h3 class="toast__title">${title}</h3>
                        <p class="toast__msg">${message}</p>
                    </div>
                    <div class="toast__close">
                        <i class="fas fa-times"></i>
                    </div>
                `;
        main.appendChild(toast);
    }
}
