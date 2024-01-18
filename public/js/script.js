import { NavigateJs } from './Navigate.js';

document.addEventListener("DOMContentLoaded", function () {
    let playerTrack = document.getElementById("player-track"),
        albumName = document.getElementById("album-name"),
        trackName = document.getElementById("track-name"),
        albumArt = document.getElementById("album-art"),
        sArea = document.getElementById("s-area"),
        seekBar = document.getElementById("seek-bar"),
        trackTime = document.getElementById("track-time"),
        insTime = document.getElementById("ins-time"),
        sHover = document.getElementById("s-hover"),
        playPauseButton = document.getElementById("play-pause-button"),
        i = playPauseButton.querySelector("i"),
        tProgress = document.getElementById("current-time"),
        tTime = document.getElementById("track-length"),
        volumeArea = document.getElementById('volume-area'),
        hasBounceAnimation = false,
        lastScrollTop = 0,
        seekT,
        seekLoc,
        seekBarPos,
        cM,
        ctMinutes,
        ctSeconds,
        curMinutes,
        curSeconds,
        durMinutes,
        durSeconds,
        playProgress,
        bTime,
        nTime = 0,
        buffInterval = null,
        isPlayerActive = false,
        tFlag = false,
        playPreviousTrackButton = document.getElementById("play-previous"),
        playNextTrackButton = document.getElementById("play-next"),
        currIndex = -1,
        volumeInput = document.getElementById("volume-input"),
        // circle = document.querySelector('.circle-2'),
        rememberVolume = 100,
        isVolumeOn = true,
        volumeIcon = document.querySelector('.control #volume i');

    let audio;

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
            revealElem(init, svg, true)
        });
        // Animate .reveal-type
        document.querySelectorAll(".reveal-type").forEach(reveal => {
            revealElem(init, reveal, false)
        });
    }

    function showOrHideHeader() {
        if (document.getElementById('menu').classList.contains('active')) {
            return;
        }

        let currentScrollTop = window.scrollY;

        if (currentScrollTop > lastScrollTop) {
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

    function playPause() {
        setTimeout(function () {
            if (audio.paused) {
                // playerTrack.classList.add("active");
                checkBuffering();
                i.className = "fas fa-pause";
                audio.play();
                playPauseButton.classList.add('active');
            } else {
                // playerTrack.classList.remove("active");
                clearInterval(buffInterval);
                // albumArt.classList.remove("buffering");
                i.className = "fas fa-play";
                playPauseButton.classList.remove('active');
                audio.pause();
            }
        }, 300);
    }

    function showHover(event) {
        seekBarPos = sArea.getBoundingClientRect();
        seekT = event.clientX - seekBarPos.left;
        seekLoc = audio.duration * (seekT / sArea.offsetWidth);

        sHover.style.width = seekT + "px";

        cM = seekLoc / 60;

        ctMinutes = Math.floor(cM);
        ctSeconds = Math.floor(seekLoc - ctMinutes * 60);

        if (ctMinutes < 0 || ctSeconds < 0) return;

        if (ctMinutes < 0 || ctSeconds < 0) return;

        if (ctMinutes < 10) ctMinutes = "0" + ctMinutes;
        if (ctSeconds < 10) ctSeconds = "0" + ctSeconds;

        if (isNaN(ctMinutes) || isNaN(ctSeconds)) insTime.textContent = "--:--";
        else insTime.textContent = ctMinutes + ":" + ctSeconds;

        insTime.style.left = seekT + "px";
        insTime.style.marginLeft = "-21px";
        insTime.style.display = "block";
    }

    function hideHover() {
        sHover.style.width = "0";
        insTime.textContent = "00:00";
        insTime.style.left = "0px";
        insTime.style.marginLeft = "0px";
        insTime.style.display = "none";
    }

    function playFromClickedPos() {
        audio.currentTime = seekLoc;
        seekBar.style.width = seekT + "px";
        hideHover();
    }

    function updateCurrTime() {
        nTime = new Date();
        nTime = nTime.getTime();

        if (!tFlag) {
            tFlag = true;
            trackTime.classList.add("active");
        }

        curMinutes = Math.floor(audio.currentTime / 60);
        curSeconds = Math.floor(audio.currentTime - curMinutes * 60);

        durMinutes = Math.floor(audio.duration / 60);
        durSeconds = Math.floor(audio.duration - durMinutes * 60);

        playProgress = (audio.currentTime / audio.duration) * 100;

        if (curMinutes < 10) curMinutes = "0" + curMinutes;
        if (curSeconds < 10) curSeconds = "0" + curSeconds;

        if (durMinutes < 10) durMinutes = "0" + durMinutes;
        if (durSeconds < 10) durSeconds = "0" + durSeconds;

        if (isNaN(curMinutes) || isNaN(curSeconds)) tProgress.textContent = "00:00";
        else tProgress.textContent = curMinutes + ":" + curSeconds;

        if (isNaN(durMinutes) || isNaN(durSeconds)) tTime.textContent = "00:00";
        else tTime.textContent = durMinutes + ":" + durSeconds;

        if (
            isNaN(curMinutes) ||
            isNaN(curSeconds) ||
            isNaN(durMinutes) ||
            isNaN(durSeconds)
        )
            trackTime.classList.remove("active");
        else trackTime.classList.add("active");

        seekBar.style.width = playProgress + "%";

        if (playProgress === 100) {
            i.className = "fa fa-play";
            seekBar.style.width = "0";
            tProgress.textContent = "00:00";
            albumArt.classList.remove("buffering");
            clearInterval(buffInterval);
        }
    }

    function selectTrack(flag) {
        if (flag == 0 || flag == 1) ++currIndex;
        else --currIndex;

        if (currIndex > -1 && currIndex < albumArtworks.length) {

            albumArt.classList.remove("buffering");

            seekBar.style.width = "0";
            trackTime.classList.remove("active");
            tProgress.textContent = "00:00";
            tTime.textContent = "00:00";

            let currAlbum = albums[currIndex];
            let currTrackName = trackNames[currIndex];
            let currArtwork = albumArtworks[currIndex];

            audio.src = trackUrl[currIndex];

            nTime = 0;
            bTime = new Date();
            bTime = bTime.getTime();

            if (flag != 0) {
                clearInterval(buffInterval);
            }

            albumName.textContent = currAlbum;
            trackName.textContent = currTrackName;
            albumArt.querySelector("img.active").classList.remove("active");
            document.getElementById(currArtwork).classList.add("active");
        } else {
            if (flag == 0 || flag == 1) --currIndex;
            else ++currIndex;
        }
    }

    function changeVolume() {
        audio.volume = volumeInput.value / 100;

        // Update volume area
        volumeArea.style.width = `${volumeInput.value}%`;

        if(isVolumeOn === false) {
            isVolumeOn = true;
            volumeIcon.className = 'fas fa-volume-up';
        }

        if (audio.volume === 0) {
            volumeIcon.className = 'fas fa-volume-mute';
            isVolumeOn = false;
        }
    }

    function togglePlayerTrack() {
        if (hasBounceAnimation) {
            albumArt.classList.remove('bounce-animation');
        }
        isPlayerActive = !isPlayerActive;

        playerTrack.classList.toggle('active');
        albumArt.classList.toggle('active');
    }

    function onOffVolume() {

        isVolumeOn = ! isVolumeOn;

        if (isVolumeOn === true) {
            volumeIcon.className = 'fas fa-volume-up';
            audio.volume = rememberVolume / 100;
            // circle.style.strokeDasharray = `${rememberVolume} 100`;
            volumeArea.style.width = `${rememberVolume}%`;
        } else {
            volumeIcon.className = 'fas fa-volume-mute';
            rememberVolume = volumeInput.value;
            audio.volume = 0;
            // circle.style.strokeDasharray = `${0} 100`;
            volumeArea.style.width = `${0}%`;
        }
    }

    // Play one of the slider's podcast
    function playSliderPodcast() {
        let cardInfosContainerEl = document.querySelector(".info__wrapper"),
            albumArts = document.querySelectorAll('#album-art img'),
            currentInfoEl = cardInfosContainerEl.querySelector(".current--info"),
            currTitle = currentInfoEl.querySelector('h1').innerText,
            currAlbum = currentInfoEl.querySelector('p').innerText,
            currAudio = currentInfoEl.querySelector('audio').src,
            currentImg = document.querySelector(".app__bg .current--image img").src;

        // Update player album art
        albumArts.forEach(albumArt => {
            albumArt.classList.remove('active');
        });
        for (let i = 0; i < albumArts.length; i++) {
            if (albumArts[i].src === currentImg) {
                albumArts[i].classList.add('active');
            }
        }

        // Update playerTrack info
        document.getElementById('track-name').innerText = currTitle;
        document.getElementById('album-name').innerText = currAlbum;

        audio.src = currAudio;
        playPause();
    }

    function initApp() {

        new NavigateJs({
            animationType: 'slide',
            animationDuration: 500,
            navigateJsCss: {
                'position': 'relative',
                'width': '100%',
                'height': 'calc(100vh - 85px)',
                'display': 'block',
            }
        });

        scrollEvents(true);

        audio = new Audio();

        selectTrack(0);

        audio.loop = false;

        playPauseButton.addEventListener("click", playPause);

        sArea.addEventListener("mousemove", function (event) {
            showHover(event);
        });

        window.addEventListener("scroll", scrollEvents);

        sArea.addEventListener("mouseout", hideHover);

        sArea.addEventListener("click", playFromClickedPos);

        audio.addEventListener("timeupdate", updateCurrTime);

        albumArt.addEventListener('click', togglePlayerTrack);

        if (document.querySelector('.app .play-icon') !== null)
            document.querySelector('.app .play-icon').addEventListener('click', playSliderPodcast);

        playPreviousTrackButton.addEventListener("click", function () {
            selectTrack(-1);
        });
        playNextTrackButton.addEventListener("click", function () {
            selectTrack(1);
        });

        document.addEventListener('njs:start', function (event) {
            if (document.getElementById('menu').classList.contains('active')) {
                burgerTime();
            }
        });

        document.addEventListener('njs:animation-end', function (event) {
            scrollEvents(true);
        });

        // Mute / Unmute
        document.getElementById('volume').addEventListener("click", onOffVolume);
        // Change volume
        volumeInput.addEventListener("input", changeVolume);
        volumeInput.value = audio.volume * 100;
    }

    initApp();

    //-- [BEGIN] BURGER MENU ANIMATION
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

        if (isPlayerActive) {
            // Hide or show podcast player
            albumArt.classList.toggle('active');
            playerTrack.classList.toggle('active');
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
    //-- [END] BURGER MENU ANIMATION

    // [BEGIN] - Hello Asso Modal
    let modal = document.getElementById("hello-asso-modal");
    let btnFermer = document.querySelector(".close-hello-asso-modal");

    // Close modal btn
    btnFermer.onclick = function() {
        overlay.classList.toggle('active');
        modal.className = "";
        modal.querySelector('.modal-content').classList.toggle('active');
    }

    // Click outside ? close modal
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.className = "";
            overlay.classList.toggle('active');
            modal.querySelector('.modal-content').classList.toggle('active');
        }
    }

    // Open Modal
    document.querySelectorAll('.donate-wrapper').forEach(wrapper => {
        wrapper.addEventListener('click', () => {
            modal.className = 'active';
            overlay.classList.toggle('active');
            modal.querySelector('.modal-content').classList.toggle('active');
        });
    })

    // [END] - Hello Asso Modal

    // When Tablet
    if (window.innerWidth < 900) {
        albumArt.classList.add('bounce-animation');
        hasBounceAnimation = true;
    }

    // When mobile
    if (window.innerWidth < 650) {

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

    //-- [BEGIN] HEART ICON HOVER
    const heartIcons = document.querySelectorAll('.donate-wrapper i');
    window.fillHeart = () => {
        heartIcons.forEach(heartIcon => {
            heartIcon.classList.replace('far', 'fas');
        });
    }
    window.unFillHeart = () => {
        heartIcons.forEach(heartIcon => {
            heartIcon.classList.replace('fas', 'far');
        });
    }
//-- [END] HEART ICON HOVER
});
// -- [END] DOM CONTENT LOADED
