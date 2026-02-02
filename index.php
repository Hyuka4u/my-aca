<?php
// index.php
require_once 'lib/auth.php';
require_once 'lib/functions.php';

// Fetch settings for JS
$startDate = getSetting('relationship_start_date') ?: '2025-11-17';
$lockPassword = getSetting('admin_lock_password') ?: 'Matcha';

include 'views/partials/header.php';
?>

<script>
    // Master key and start date from DB with hardcoded fallback
    const SETTINGS = {
        startDate: '<?= $startDate ?>',
        lockPassword: '<?= $lockPassword ?: "Matcha" ?>'
    };

    function showLoginMsg(txt, color = 'red') {
        const msg = document.getElementById('loginMsg');
        if (msg) {
            msg.style.color = color;
            msg.textContent = txt;
        }
    }

    function doLogin() {
        const pw = document.getElementById('passwordInput').value.trim();
        if (!pw) {
            showLoginMsg('Isi dulu woyyy');
            return;
        }
        if (pw.toLowerCase() === SETTINGS.lockPassword.toLowerCase()) {
            const overlay = document.getElementById('loginOverlay');
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.style.display = 'none';
                if (typeof calculateDays === 'function') calculateDays();
                if (typeof celebrate === 'function') celebrate();
            }, 500);
        } else {
            showLoginMsg('Duh, kuncinya salah nih — coba ingat-ingat lagi :)');
            const card = document.querySelector('.login-card');
            if (card) {
                card.animate([
                    { transform: 'translateX(0)' },
                    { transform: 'translateX(-10px)' },
                    { transform: 'translateX(10px)' },
                    { transform: 'translateX(0)' }
                ], { duration: 400 });
            }
        }
    }
</script>

<div id="loginOverlay" class="login-overlay" style="transition: opacity .5s ease;">
    <div class="login-card" data-tilt data-aos="zoom-in">
        <div class="logo-heart">😲</div>
        <h4 style="margin-bottom:6px;">Halooooo</h4>
        <p class="muted-small">Masukin sesuatu yang paling kita suka — jangan lupa ya :)</p>

        <div class="mt-3">
            <div class="input-group mb-2">
                <span class="input-group-text">Lock</span>
                <input id="passwordInput" type="password" class="form-control"
                    placeholder="Codenya apa yahh" onkeypress="if(event.key==='Enter') doLogin()">
            </div>
            <div>
                <button onclick="doLogin()" class="btn btn-primary w-100">Masuk</button>
            </div>
            <div id="loginMsg" class="mt-3 muted-small" style="min-height:20px"></div>
        </div>

        <div class="mt-3 muted-small">Tip: kata kunci defaultnya adalah <strong>"kepo banget sihh"</strong></div>
    </div>
</div>

<?php
include 'views/partials/navbar.php';
include 'views/home.php';
include 'views/about.php';
include 'views/timeline.php';
include 'views/bucket_list.php';
include 'views/message.php';
include 'views/gallery.php';
include 'views/musik.php';
?>

<section id="pelukan" class="py-5 text-center" data-aos="fade-up">
    <div class="container">
        <h4 class="mb-5 dancing" style="font-size: 2.5rem; color:var(--accent-contrast)">Tombol Iseng (Anggap Peluk) 🤗
        </h4>
        <div class="card-rose p-5 d-inline-block" data-tilt data-aos="zoom-in" data-aos-delay="200">
            <p class="muted-small mb-3">Klik tombol ini berkali-kali — tapi jangan keseringan yaaa malu gweh :3</p>
            <button class="btn btn-warning btn-lg" id="hugBtn">Tombol peluk iseng hehe</button>
            <div id="hugMsg" class="mt-3" style="min-height:20px;"></div>
        </div>
    </div>
</section>

<div class="floating-heart" id="floatingHeart" title="Klik untuk beri hadiah kecil">
    <div class="dancing">💚</div>
</div>

<?php include 'views/partials/footer.php'; ?>