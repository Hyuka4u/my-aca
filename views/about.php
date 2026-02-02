<section id="about" class="py-5" data-aos="fade-up">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="about-img-wrapper" data-tilt>
                    <img src="foto/aca1.png" class="about-img" alt="loving moment">
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="400">
                <h3 class="dancing" style="font-size: 2.5rem; color:var(--accent-contrast)">Kenapa aku sayang kamu
                </h3>
                <p class="muted-small">Karena sabarmu, senyummu, dan caramu membuat hari-hariku lebih ringan. Kamu bukan
                    cuma pelipur lelah — kamu alasan aku mau jadi lebih baik.</p>
                <ul class="list-unstyled mt-3">
                    <li>• Selalu sabar denganku</li>
                    <li>• Cerita kecil yang berarti</li>
                    <li>• Setiap jawaban yang kau beri</li>
                    <li>• Ajakan yang selalu ada tiap hari</li>
                    <li>• Muka lucumu di setiap vidio call kita</li>
                    <li>• Selalu jadi yang pertama kuingat tiap pagi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="kenangan" class="py-5 overflow-hidden">
    <div class="container">
        <h4 class="mb-5 text-center dancing" style="font-size: 2.5rem; color: var(--accent-contrast);"
            data-aos="fade-up">Kenangan Kita ✨</h4>
        <div id="memoriesCarousel" class="carousel slide" data-bs-ride="carousel" data-aos="zoom-in"
            data-aos-delay="200">
            <div class="carousel-inner rounded-4 overflow-hidden shadow-premium">
                <?php
                $kenangan = getGallery('kenangan');
                if (empty($kenangan)) {
                    // Default if DB is empty
                    $default_kenangan = ['foto/kita1.png', 'foto/kita2.png', 'foto/kita3.png', 'foto/kita4.png'];
                    foreach ($default_kenangan as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= $img ?>" class="d-block w-100" style="height:420px; object-fit:cover;">
                        </div>
                    <?php endforeach;
                } else {
                    foreach ($kenangan as $index => $item): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= $item['image_path'] ?>" class="d-block w-100" style="height:420px; object-fit:cover;">
                        </div>
                    <?php endforeach;
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#memoriesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#memoriesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>