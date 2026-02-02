<?php
// views/timeline.php
$events = getTimeline();
?>
<section id="timeline" class="py-5">
    <div class="container">
        <h4 class="mb-4 text-center dancing" style="color:var(--accent-contrast); font-size: 2rem;">Lini Masa Kita ⏳
        </h4>
        <div class="timeline-wrapper">
            <?php if (empty($events)): ?>
                <p class="text-center muted-small">Belum ada momen yang tercatat. Tambahkan di Panel Admin!</p>
            <?php else: ?>
                <?php foreach ($events as $index => $event): ?>
                    <div class="timeline-item <?= $index % 2 == 0 ? 'left' : 'right' ?>"
                        data-aos="<?= $index % 2 == 0 ? 'fade-right' : 'fade-left' ?>">
                        <div class="timeline-content card-rose" data-tilt>
                            <span class="event-date">
                                <?= formatDate($event['event_date'], 'd M Y') ?>
                            </span>
                            <h5>
                                <?= htmlspecialchars($event['title']) ?>
                            </h5>
                            <p>
                                <?= nl2br(htmlspecialchars($event['description'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .timeline-wrapper {
        position: relative;
        max-width: 800px;
        margin: 40px auto;
    }

    .timeline-wrapper::after {
        content: '';
        position: absolute;
        width: 4px;
        background-color: var(--accent);
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -2px;
        border-radius: 2px;
    }

    .timeline-item {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    .timeline-item::after {
        content: '💚';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -13px;
        background-color: white;
        border: 2px solid var(--accent);
        top: 20px;
        border-radius: 50%;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .timeline-item.left {
        left: 0;
    }

    .timeline-item.right {
        left: 50%;
    }

    .timeline-item.right::after {
        left: -12px;
    }

    .timeline-content {
        padding: 20px;
        position: relative;
        border-radius: 15px;
    }

    .event-date {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--accent-contrast);
        margin-bottom: 5px;
    }

    .timeline-content h5 {
        margin-top: 0;
        color: var(--accent-2);
    }

    @media screen and (max-width: 600px) {
        .timeline-wrapper::after {
            left: 31px;
        }

        .timeline-item {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        .timeline-item::after {
            left: 18px;
        }

        .timeline-item.right {
            left: 0;
        }
    }
</style>