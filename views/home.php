<section class="hero">
    <div class="container">
        <h1 data-aos="fade-down">Untukmu, sayang...</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="300">We can go somewhere, just you and I. We could watch the
            waves roll by. But I'm too shy to ask
            you if you'd want to. But I guess that i could try to tell you how I'm feeling.</p>

        <div id="countdownTimer" class="mt-4" data-aos="zoom-in" data-aos-delay="600">
            <div class="card-rose p-3 d-inline-block"
                style="background:var(--card); color:var(--accent-contrast); font-weight:600; font-size:18px;"
                data-tilt>
                Kita sudah bersama selama: <span id="daysTogether" class="dancing"
                    style="font-size:34px; color:var(--accent-contrast);">...</span> Hari!
            </div>
        </div>

        <div class="row justify-content-center mt-4" data-aos="fade-up" data-aos-delay="800">
            <div class="col-md-8">
                <div class="card-rose" data-tilt>
                    <p style="font-size:16px; color:var(--muted)">
                        Kalau kau sudah masuk ke sini, itu artinya aku berani membuka hati. Selamat datang, semoga tiap
                        kata membuatmu tersenyum.
                    </p>
                    <div class="mt-3 d-flex gap-2 justify-content-center">
                        <a href="#pesan" class="btn btn-outline-primary">Baca Pesanku</a>
                        <a href="#kenangan" class="btn btn-primary">Lihat Kenangan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="profiles" class="py-4">
    <div class="container">
        <div class="heartbeat-container text-center my-4 position-relative">
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                <div class="profile-circle">
                    <img src="foto/ndre.jpg" alt="Andre" class="profile-img">
                    <p class="profile-name mt-2 mb-0">Andre</p>
                </div>

                <div class="heartbeat-line-wrapper">
                    <svg class="heartbeat-svg" viewBox="0 0 400 100" preserveAspectRatio="xMidYMid meet">
                        <path
                            d="M 20 50 L 50 50 L 55 48 L 60 45 L 65 52 L 70 70 L 75 45 L 80 48 L 85 50 L 315 50 L 320 52 L 325 48 L 330 50 L 335 52 L 340 48 L 345 50 L 380 50"
                            fill="none" stroke="#b4dc87" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path class="pulse-path"
                            d="M 20 50 L 50 50 L 55 48 L 60 45 L 65 52 L 70 70 L 75 45 L 80 48 L 85 50 L 315 50 L 320 52 L 325 48 L 330 50 L 335 52 L 340 48 L 345 50 L 380 50"
                            fill="none" stroke="#4caf50" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            style="filter: drop-shadow(0 0 4px #4caf50);" />
                    </svg>
                    <div class="heartbeat-text">
                        <div class="days-text">This is Our Lovely days</div>
                        <div class="date-text">
                            <?= formatDate(getSetting('relationship_start_date')) ?>
                        </div>
                    </div>
                    <div class="pulse-hearts">
                        <span class="pulse-heart">💚</span>
                        <span class="pulse-heart">💚</span>
                        <span class="pulse-heart">💚</span>
                    </div>
                </div>

                <div class="profile-circle">
                    <img src="foto/aca2.png" alt="Caca" class="profile-img">
                    <p class="profile-name mt-2 mb-0">Caca</p>
                </div>
            </div>
        </div>

        <div class="profiles-grid">
            <div class="flip-card" id="flip-1" tabindex="0" role="button" aria-pressed="false" data-aos="fade-right">
                <div class="flip-card-inner" data-tilt>
                    <div class="flip-card-face flip-card-front">
                        <img id="avatar-1" src="foto/ndre.jpg" alt="Foto Aku" class="profile-avatar" />
                        <div style="flex:1;">
                            <h5 class="profile-name" id="name-1">Andre Maulana J</h5>
                            <p class="profile-desc" id="desc-1">Orang yang tadinya ingin hidup sendiri — Matcha •
                                Penyayang • Suka Musik</p>
                            <div class="profile-meta" id="meta-1"><small class="text-muted">Kesayangan Aca</small></div>
                        </div>
                    </div>
                    <div class="flip-card-face flip-card-back">
                        <div class="back-message" id="back-1">Halo acaaa terimakasih karena udah masuk ke dalam hidupku,
                            bukti dari kamu masuk ke dalam hidupku ya sesimple kamu yang kepo dan membalikkan kartu ini
                            heheh.</div>
                    </div>
                </div>
            </div>

            <div class="flip-card" id="flip-2" tabindex="0" role="button" aria-pressed="false" data-aos="fade-left">
                <div class="flip-card-inner" data-tilt>
                    <div class="flip-card-face flip-card-front">
                        <img id="avatar-2" src="foto/aca2.png" alt="Foto Dia" class="profile-avatar" />
                        <div style="flex:1;">
                            <h5 class="profile-name" id="name-2">Tasya Nurmaliya</h5>
                            <p class="profile-desc" id="desc-2">Orang yang suka Matcha tapi kenapa jadi suka sama Andre
                                MJ — Matcha • Senyum yang menenangkan • Si Ngambek </p>
                            <div class="profile-meta" id="meta-2"><small class="text-muted">Manusia berharga untuk Andre
                                    MJ</small></div>
                        </div>
                    </div>
                    <div class="flip-card-face flip-card-back">
                        <div class="back-message" id="back-2">Ini pesan dari Andre MJ... Acaaa kenapa kamu bisa
                            sesempurna itu buat aku deh? walaupun kamu sering gak percaya diri dan takut kalo aku
                            bakalan pergi, tapi asal kamu tau yaa aku tuh sayang banget sama kamu lohhh, masa iya mau
                            ninggalin kamu tch.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>