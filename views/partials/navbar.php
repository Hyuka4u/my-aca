<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <div
                style="width:42px;height:42px;border-radius:9px;background:linear-gradient(135deg,var(--accent-2),var(--accent));display:grid;place-items:center;font-family:'Dancing Script';color:var(--accent-contrast);">
                M</div>
            <div>
                <div style="font-weight:600;color:var(--accent-contrast)">Untukmu Caca</div>
                <small style="font-size:11px;color:var(--muted)">Sebuah pesan dari hatiku hanya untukmu</small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#kenangan">Kenangan</a></li>
                <li class="nav-item"><a class="nav-link" href="#pesan">Pesan (Proposal)</a></li>
                <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#musik">Musik</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link fw-bold" href="admin/dashboard.php">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>