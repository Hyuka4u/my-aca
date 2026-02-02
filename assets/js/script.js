// assets/js/script.js

/**
 * UTILITY FUNCTIONS (Global scope)
 */

function createHeart(distance, scale) {
    try {
        const el = document.createElement('div');
        el.textContent = '💚';
        el.style.position = 'fixed';
        el.style.left = (window.innerWidth / 2 + (Math.random() - 0.5) * 180) + 'px';
        el.style.top = (window.innerHeight / 2 + 20 + (Math.random() - 0.8) * 60) + 'px';
        el.style.fontSize = (12 + Math.random() * 18) + 'px';
        el.style.opacity = '0.95';
        el.style.transform = `scale(${scale})`;
        el.style.pointerEvents = 'none';
        el.style.zIndex = 9999;
        document.body.appendChild(el);
        const dx = (Math.random() - 0.5) * distance;
        const dy = - (80 + Math.random() * 180);
        el.animate([
            { transform: `translate(0,0) scale(${scale})`, opacity: 1 },
            { transform: `translate(${dx}px, ${dy}px) scale(${scale * 0.8})`, opacity: 0 }
        ], { duration: 1400 + Math.random() * 600, easing: 'cubic-bezier(.2,.8,.2,1)' });
        setTimeout(() => el.remove(), 2200);
    } catch (e) {
        console.error("Error creating heart:", e);
    }
}

function littleHeartsBurst() {
    for (let i = 0; i < 12; i++) {
        createHeart(12 + Math.random() * 40, 0.6 + Math.random() * 0.8);
    }
}

function celebrate() {
    if (typeof confetti === 'function') {
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 }
        });
    }
    for (let i = 0; i < 18; i++) {
        setTimeout(() => createHeart(60 + Math.random() * 80, 0.6 + Math.random() * 1.2), i * 60);
    }
}

/**
 * CLICK-TO-HEART SYSTEM
 */
document.addEventListener('mousedown', (e) => {
    const heart = document.createElement('div');
    heart.className = 'heart-particle';
    heart.textContent = ['❤️', '💖', '✨', '🌸', '💚'][Math.floor(Math.random() * 5)];
    heart.style.left = e.clientX + 'px';
    heart.style.top = e.clientY + 'px';

    // Random destination for animation
    const tx = (Math.random() - 0.5) * 300;
    const ty = (Math.random() - 0.5) * 300;
    const tr = (Math.random() - 0.5) * 45;

    heart.style.setProperty('--tx', `${tx}px`);
    heart.style.setProperty('--ty', `${ty}px`);
    heart.style.setProperty('--tr', `${tr}deg`);

    document.body.appendChild(heart);
    setTimeout(() => heart.remove(), 1000);
});

/**
 * PETAL RAIN SYSTEM
 */
class PetalRain {
    constructor() {
        this.petals = ['🌸', '🍃', '✨', '💕'];
        this.maxPetals = 20;
        this.container = document.body;
        if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
            this.init();
        }
    }

    init() {
        setInterval(() => {
            if (document.querySelectorAll('.petal').length < this.maxPetals) {
                this.createPetal();
            }
        }, 1200);
    }

    createPetal() {
        const petal = document.createElement('div');
        petal.className = 'petal';
        petal.textContent = this.petals[Math.floor(Math.random() * this.petals.length)];

        const left = Math.random() * 100;
        const duration = 6 + Math.random() * 8;
        const delay = Math.random() * 5;
        const size = 0.8 + Math.random() * 1.5;

        petal.style.left = left + 'vw';
        petal.style.animationDuration = duration + 's';
        petal.style.animationDelay = delay + 's';
        petal.style.fontSize = size + 'rem';
        petal.style.opacity = 0.4 + Math.random() * 0.4;

        petal.style.setProperty('--side-move', `${(Math.random() - 0.5) * 200}px`);
        petal.style.setProperty('--rot-end', `${(Math.random() - 0.5) * 720}deg`);

        this.container.appendChild(petal);
        setTimeout(() => petal.remove(), (duration + delay) * 1000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("Antigravity: Initializing Premium UI...");

    // Start Petal Rain
    new PetalRain();

    // Init AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-out-back'
        });
    }

    // Init Tilt
    if (typeof VanillaTilt !== 'undefined') {
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 15,
            speed: 400,
            glare: true,
            "max-glare": 0.3,
        });
    }

    /**
     * 1. SETTINGS INITIALIZATION
     */
    const SETTINGS = (typeof SITE_SETTINGS !== 'undefined') ? SITE_SETTINGS : {
        startDate: '2025-11-17',
        lockPassword: 'Matcha'
    };

    /**
     * 2. LOGIN OVERLAY (Handled in index.php for robustness)
     */

    /**
     * 3. PELUKAN BUTTON
     */
    const hugBtn = document.getElementById('hugBtn');
    const hugMsg = document.getElementById('hugMsg');
    let hugCount = 0;
    if (hugBtn) {
        hugBtn.addEventListener('click', () => {
            hugCount++;
            let msg = '';
            if (hugCount === 1) msg = 'Masih malu-malu, klik lagi atuhh';
            else if (hugCount === 2) msg = 'Duhaii jadi malu wkwkw';
            else if (hugCount === 3) {
                msg = 'Oke, ini pelukan terbaik dari kamuww! cihuyyy';
                hugBtn.classList.remove('btn-warning');
                hugBtn.classList.add('btn-success');
                hugBtn.disabled = true;
                littleHeartsBurst();
            } else return;

            if (hugMsg) hugMsg.textContent = msg;
            hugBtn.animate([{ transform: 'scale(1)' }, { transform: 'scale(0.95)' }, { transform: 'scale(1.05)' }, { transform: 'scale(1)' }], { duration: 300 });
        });
    }

    /**
     * 4. DAYS TOGETHER
     */
    const daysEl = document.getElementById('daysTogether');
    if (daysEl) {
        const start = new Date(SETTINGS.startDate);
        const today = new Date();
        const diffDays = Math.ceil(Math.abs(today - start) / (1000 * 60 * 60 * 24));
        daysEl.textContent = diffDays;
    }

    /**
     * 5. PROPOSAL SECTION
     */
    const openProposalBtn = document.getElementById('openProposalBtn');
    const proposalContentEl = document.getElementById('proposalContent');
    const closeProposalBtn = document.getElementById('closeProposalBtn');
    const acceptBtn = document.getElementById('acceptBtn');
    const maybeBtn = document.getElementById('maybeBtn');
    const resp = document.getElementById('respMsg');
    let proposalOpen = false;

    if (openProposalBtn && proposalContentEl) {
        openProposalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openProposalBtn.style.display = 'none';
            document.querySelectorAll('.flip-card').forEach(c => c.classList.remove('show-back'));
            proposalContentEl.classList.add('show');
            proposalOpen = true;
            if (acceptBtn) acceptBtn.focus();
        });

        if (closeProposalBtn) {
            closeProposalBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openProposalBtn.style.display = '';
                proposalContentEl.classList.remove('show');
                proposalOpen = false;
            });
        }
    }

    if (acceptBtn && resp) {
        acceptBtn.addEventListener('click', () => {
            resp.style.color = '#0f5132';
            resp.textContent = 'Hehehe, Makasih sayanggg karena sudah ingin selalu bersamakuuu cihuyy :3';
            if (maybeBtn) maybeBtn.disabled = true;
            acceptBtn.disabled = true;
            littleHeartsBurst();
            fetch('api/save_response.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ response: 'accept', message: 'Ayoo sayangg 💍' })
            });
        });

        if (maybeBtn) {
            maybeBtn.addEventListener('click', () => {
                resp.style.color = '#6b6b6b';
                resp.textContent = 'Baiklahh...';
                acceptBtn.disabled = true;
                maybeBtn.disabled = true;
                fetch('api/save_response.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ response: 'maybe', message: 'Beri aku waktu 😊' })
                });
            });
        }
    }

    /**
     * 6. FLIP CARDS
     */
    function toggleCard(card) {
        if (proposalOpen) return;
        card.classList.toggle('show-back');
    }

    document.querySelectorAll('.flip-card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('a, button, input')) return;
            toggleCard(card);
        });
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleCard(card);
            }
        });
    });

    /**
     * 7. GALLERY MODAL
     */
    document.querySelectorAll('.img-thumb').forEach(img => {
        img.addEventListener('click', function () {
            const src = this.getAttribute('src');
            const modalImg = document.getElementById('modalImage');
            if (modalImg) {
                modalImg.setAttribute('src', src);
                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                imageModal.show();
            }
        });
    });

    /**
     * 8. MUSIC PLAYER
     */
    const playlistEl = document.getElementById('playlist');
    const player = document.getElementById('player');

    if (playlistEl && player) {
        const playlistData = (typeof PLAYLIST_DATA !== 'undefined') ? PLAYLIST_DATA : [];
        const formattedPlaylist = playlistData.map(item => ({
            title: item.title,
            artist: item.artist,
            src: item.file_path,
            cover: item.cover_path
        }));

        const playPauseBtn = document.getElementById('playPauseBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const progress = document.getElementById('progress');
        const curTime = document.getElementById('curTime');
        const durTime = document.getElementById('durTime');
        const volumeEl = document.getElementById('volume');
        const muteBtn = document.getElementById('muteBtn');

        let currentIndex = 0;
        let isPlaying = false;

        function renderPlaylist() {
            playlistEl.innerHTML = '<h6>Playlist</h6>';
            formattedPlaylist.forEach((t, i) => {
                const item = document.createElement('div');
                item.className = 'track-item';
                item.dataset.index = i;
                item.innerHTML = `
                    <img class="track-thumb" src="${t.cover || ''}" alt="${t.title}">
                    <div class="track-meta">
                        <div class="track-title">${t.title}</div>
                        <div class="track-artist">${t.artist}</div>
                    </div>
                `;
                item.addEventListener('click', () => {
                    loadTrack(i);
                    playTrack();
                });
                playlistEl.appendChild(item);
            });
            highlightActive();
        }

        function highlightActive() {
            document.querySelectorAll('.track-item').forEach(el => el.classList.remove('active'));
            const el = document.querySelector(`.track-item[data-index="${currentIndex}"]`);
            if (el) el.classList.add('active');
        }

        function loadTrack(index) {
            if (index < 0 || index >= formattedPlaylist.length) return;
            currentIndex = index;
            const t = formattedPlaylist[index];
            player.src = t.src;
            const titleEl = document.getElementById('nowTitle');
            const artistEl = document.getElementById('nowArtist');
            if (titleEl) titleEl.textContent = t.title;
            if (artistEl) artistEl.textContent = t.artist;
            highlightActive();
            if (playPauseBtn) playPauseBtn.textContent = 'Pause';
            isPlaying = false;
        }

        function playTrack() {
            if (!player.src && formattedPlaylist.length) loadTrack(0);
            player.play().then(() => {
                isPlaying = true;
                if (playPauseBtn) playPauseBtn.textContent = 'Pause';
            }).catch(e => console.warn("Player error:", e));
        }

        function pauseTrack() {
            player.pause();
            isPlaying = false;
            if (playPauseBtn) playPauseBtn.textContent = 'Play';
        }

        if (playPauseBtn) {
            playPauseBtn.addEventListener('click', () => {
                if (isPlaying) pauseTrack(); else playTrack();
            });
        }

        if (nextBtn) nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % formattedPlaylist.length;
            loadTrack(currentIndex);
            playTrack();
        });

        if (prevBtn) prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + formattedPlaylist.length) % formattedPlaylist.length;
            loadTrack(currentIndex);
            playTrack();
        });

        player.addEventListener('timeupdate', () => {
            if (progress) progress.value = Math.floor(player.currentTime);
            if (curTime) curTime.textContent = formatTime(player.currentTime);
        });

        player.addEventListener('loadedmetadata', () => {
            if (progress) progress.max = Math.floor(player.duration);
            if (durTime) durTime.textContent = formatTime(player.duration);
        });

        if (progress) {
            progress.addEventListener('input', () => {
                player.currentTime = progress.value;
            });
        }

        player.addEventListener('ended', () => {
            if (nextBtn) nextBtn.click();
        });

        if (volumeEl) {
            volumeEl.addEventListener('input', () => {
                player.volume = volumeEl.value / 100;
            });
        }

        function formatTime(sec) {
            sec = Math.floor(sec || 0);
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            return `${m}:${s.toString().padStart(2, '0')}`;
        }

        renderPlaylist();
        if (formattedPlaylist.length) loadTrack(0);
    }

    /**
     * 9. MISC
     */
    const floatingHeart = document.getElementById('floatingHeart');
    if (floatingHeart) {
        floatingHeart.addEventListener('click', () => {
            alert('Kau memberi hatiku hadiah kecil 💚');
            celebrate();
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (overlay && overlay.style.opacity !== '0') {
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
            }
            if (proposalOpen && typeof closeProposal === 'function') closeProposal();
        }
    });

});
