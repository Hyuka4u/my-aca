<?php
// views/bucket_list.php
$buckets = getBucketList();
?>
<section id="bucket-list" class="py-5">
    <div class="container">
        <div class="card-rose p-4">
            <h4 class="mb-4 text-center dancing" style="color:var(--accent-contrast); font-size: 2rem;">Bucket List Kita
                📝</h4>
            <p class="text-center muted-small mb-4">Hal-hal seru yang ingin kita lakukan bareng di masa depan.</p>

            <div class="row row-cols-1 row-cols-md-2 g-3">
                <?php if (empty($buckets)): ?>
                    <p class="w-100 text-center muted-small">Belum ada wishlist tercatat. Yuk tambahin di Panel Admin!</p>
                <?php else: ?>
                    <?php foreach ($buckets as $index => $item): ?>
                        <div class="col" data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
                            <div class="bucket-item <?= $item['is_done'] ? 'done' : '' ?>" data-tilt>
                                <div class="bucket-check">
                                    <?= $item['is_done'] ? '✓' : '○' ?>
                                </div>
                                <div class="bucket-text">
                                    <?= htmlspecialchars($item['title']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="text-center mt-4">
                <small class="muted-small">"Semoga semua wishlist ini tercapai ya caa! Aminn 💚"</small>
            </div>
        </div>
    </div>
</section>

<style>
    .bucket-item {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.4);
        padding: 15px 20px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        height: 100%;
    }

    .bucket-item:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.6);
    }

    .bucket-check {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--accent);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
        font-weight: bold;
    }

    .bucket-item.done .bucket-check {
        background: #0f5132;
    }

    .bucket-item.done .bucket-text {
        text-decoration: line-through;
        opacity: 0.6;
    }

    .bucket-text {
        font-size: 1.05rem;
        color: var(--accent-contrast);
    }
</style>