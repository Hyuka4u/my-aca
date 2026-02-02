<?php
// admin/songs.php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/functions.php';
requireLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_song'])) {
        $title = $_POST['title'] ?? '';
        $artist = $_POST['artist'] ?? '';

        $target_musik_dir = "../musik/";
        $target_foto_dir = "../foto/";

        if (!is_dir($target_musik_dir))
            mkdir($target_musik_dir, 0777, true);
        if (!is_dir($target_foto_dir))
            mkdir($target_foto_dir, 0777, true);

        $song_file = "musik/" . time() . '_' . basename($_FILES["song_file"]["name"]);
        $cover_file = "foto/" . time() . '_' . basename($_FILES["cover_file"]["name"]);

        if (
            move_uploaded_file($_FILES["song_file"]["tmp_name"], "../" . $song_file) &&
            move_uploaded_file($_FILES["cover_file"]["tmp_name"], "../" . $cover_file)
        ) {

            $stmt = $pdo->prepare("INSERT INTO songs (title, artist, file_path, cover_path) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $artist, $song_file, $cover_file]);
            $success = "Lagu berhasil ditambahkan!";
        } else {
            $error = "Gagal mengunggah file. Pastikan file lagu dan cover sudah dipilih.";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT file_path, cover_path FROM songs WHERE id = ?");
    $stmt->execute([$id]);
    $song = $stmt->fetch();
    if ($song) {
        if (file_exists("../" . $song['file_path']))
            unlink("../" . $song['file_path']);
        if (file_exists("../" . $song['cover_path']))
            unlink("../" . $song['cover_path']);

        $stmt = $pdo->prepare("DELETE FROM songs WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: songs.php");
    exit();
}

$songs = getSongs();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Lagu - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body style="background:#f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="gallery.php" class="list-group-item list-group-item-action">Kelola Galeri</a>
                    <a href="songs.php" class="list-group-item list-group-item-action active">Kelola Lagu</a>
                    <a href="bucket_list.php" class="list-group-item list-group-item-action">Kelola Bucket List</a>
                    <a href="timeline.php" class="list-group-item list-group-item-action">Kelola Timeline</a>
                    <a href="messages.php" class="list-group-item list-group-item-action">Pesan Masuk</a>
                    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Kelola Lagu</h2>
                <hr>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <div class="card p-4 shadow-sm mb-4">
                    <h4>Tambah Lagu Baru</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul Lagu</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Artis</label>
                                <input type="text" name="artist" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">File Audio (.mp3)</label>
                                <input type="file" name="song_file" class="form-control" accept="audio/*" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cover Foto</label>
                                <input type="file" name="cover_file" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                        <button type="submit" name="add_song" class="btn btn-success">Upload Lagu</button>
                    </form>
                </div>

                <div class="row g-3">
                    <?php foreach ($songs as $s): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="../<?= $s['cover_path'] ?>" class="card-img-top"
                                    style="height:150px; object-fit:cover;">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <?= htmlspecialchars($s['title']) ?>
                                    </h6>
                                    <p class="card-text small text-muted">
                                        <?= htmlspecialchars($s['artist']) ?>
                                    </p>
                                    <a href="?delete=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger w-100"
                                        onclick="return confirm('Hapus lagu ini?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($songs)): ?>
                        <div class="col-12 text-center text-muted">Belum ada lagu yang diunggah.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>