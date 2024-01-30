import { NavigateJs } from './Navigate.js';
import { CountUp } from './CountUp.js';

document.addEventListener("DOMContentLoaded", function () {
    let lastScrollTop = 0,
        isMobile      = false;

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
            document.querySelector(".mobile-header-btn").style.transform = "translateY(-300%)";
        } else {
            // Scrolling up, show the header
            document.querySelector("header").style.transform = "translateY(0)";
            document.querySelector(".mobile-header-btn").style.transform = "translateY(0)";
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

    function fillHeart() {
        this.querySelector('i').classList.replace('far', 'fas');
    }
    function unFillHeart() {
        this.querySelector('i').classList.replace('fas', 'far');
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
            let modal = document.querySelector('#' + btn.dataset.modalId);
            btn.addEventListener('click', () => openCloseModal(modal, overlay));
        });
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

        document.querySelector('header .donate-wrapper').addEventListener('mouseenter', fillHeart);
        document.querySelector('header .donate-wrapper').addEventListener('mouseleave', unFillHeart);

        document.addEventListener('njs:start', function (event) {
            if (document.getElementById('menu').classList.contains('active')) {
                burgerTime();
            }
        });

        document.addEventListener('njs:done', function (event) {
            scrollEvents(true);
            counterUp();
        });
    }

    initApp();
});
// -- [END] DOM CONTENT LOADED
