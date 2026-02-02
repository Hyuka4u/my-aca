<?php
// views/gallery.php
?>
<section id="galeri" class="py-5 overflow-hidden">
    <div class="container">
        <h4 class="mb-5 text-center dancing" style="font-size: 2.5rem; color: var(--accent-contrast);"
            data-aos="fade-up">Galeri Kenangan 📸</h4>

        <div class="polaroid-container" data-aos="zoom-in-up">
            <?php
            $galeri = getGallery('galeri');
            $images = !empty($galeri) ? $galeri : [
                ['image_path' => 'foto/hal1.png', 'title' => 'Senyummu'],
                ['image_path' => 'foto/hal2.png', 'title' => 'Momen Kita'],
                ['image_path' => 'foto/hal3.png', 'title' => 'Kenangan'],
                ['image_path' => 'foto/hal4.png', 'title' => 'Bahagia']
            ];

            foreach ($images as $index => $item):
                $rot = (rand(-10, 10)) . 'deg';
                ?>
                <div class="polaroid-item" style="--rot: <?= $rot ?>;" data-aos="fade-up"
                    data-aos-delay="<?= $index * 100 ?>" data-tilt>
                    <img class="polaroid-img" src="<?= $item['image_path'] ?>" alt="Kenangan" onclick="viewImage(this.src)">
                    <div class="polaroid-caption"><?= htmlspecialchars($item['title'] ?? 'Our Moment') ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    function viewImage(src) {
        const modalImg = document.getElementById('modalImage');
        if (modalImg) {
            modalImg.setAttribute('src', src);
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    }
</script>