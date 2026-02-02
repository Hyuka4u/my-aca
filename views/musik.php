<?php
// views/musik.php
$songs = getSongs();
?>
<section id="musik" class="py-5" data-aos="fade-up">
    <div class="container">
        <h4 class="mb-5 text-center dancing" style="font-size: 2.5rem; color:var(--accent-contrast)">Lagu Kita 🎵</h4>
        <div class="card-rose" data-aos="zoom-in" data-aos-delay="200">
            <p class="text-center muted-soft mb-4">Pilih lagu dari playlist di samping, atau tekan play untuk
                melanjutkan otomatis.</p>

            <div class="player-main" data-tilt>
                <div class="track-info" id="nowTitle">- Pilih lagu untuk mulai -</div>
                <div class="track-sub" id="nowArtist">Playlist personal</div>

                <div class="player-controls mt-3">
                    <button id="prevBtn" class="small-btn" title="Previous">Previous</button>
                    <button id="playPauseBtn" class="play-btn" title="Play / Pause">Play</button>
                    <button id="nextBtn" class="small-btn" title="Next">Next</button>
                    <div style="flex:1"></div>
                    <button id="loopBtn" class="small-btn" title="Loop: Off">Loop</button>
                    <button id="shuffleBtn" class="small-btn" title="Shuffle: Off">Shuffle</button>
                    <div class="vol-wrap" style="margin-left:6px;">
                        <button id="muteBtn" class="small-btn" title="Mute">Speaker</button>
                        <input id="volume" type="range" min="0" max="100" value="80" aria-label="volume">
                    </div>
                </div>

                <div class="progress-wrap">
                    <div class="progress-time" id="curTime">0:00</div>
                    <input id="progress" class="progress-bar" type="range" min="0" max="100" value="0">
                    <div class="progress-time" id="durTime">0:00</div>
                </div>

                <div style="margin-top:12px;">
                    <audio id="player" preload="metadata"></audio>
                </div>
            </div>

            <div class="playlist" id="playlist" data-tilt>
                <h6>Playlist</h6>
                <!-- Song list will be injected via JS or rendered here -->
            </div>
        </div>
    </div>
    </div>
</section>

<script>
    // Pass dynamic song list to JS
    const PLAYLIST_DATA = <?= json_encode($songs) ?>;
</script>