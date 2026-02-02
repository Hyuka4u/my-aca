<?php
// admin/gallery.php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/functions.php';
requireLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_photo'])) {
        $title = $_POST['title'] ?? '';
        $type = $_POST['type'] ?? 'galeri';

        $target_dir = "../assets/img/uploads/";
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);

        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $db_path = "assets/img/uploads/" . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, image_path, type) VALUES (?, ?, ?)");
            $stmt->execute([$title, $db_path, $type]);
            $success = "Foto berhasil ditambahkan!";
        } else {
            $error = "Gagal mengunggah foto.";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Delete file first
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetch();
    if ($photo) {
        $file_path = __DIR__ . "/../" . $photo['image_path'];
        if (file_exists($file_path))
            unlink($file_path);

        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: gallery.php");
    exit();
}

$photos = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Galeri - Admin Panel</title>
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
                    <a href="gallery.php" class="list-group-item list-group-item-action active">Kelola Galeri</a>
                    <a href="songs.php" class="list-group-item list-group-item-action">Kelola Lagu</a>
                    <a href="bucket_list.php" class="list-group-item list-group-item-action">Kelola Bucket List</a>
                    <a href="timeline.php" class="list-group-item list-group-item-action">Kelola Timeline</a>
                    <a href="messages.php" class="list-group-item list-group-item-action">Pesan Masuk</a>
                    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Kelola Galeri</h2>
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
                    <h4>Tambah Foto Baru</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul/Deskripsi (Opsional)</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="type" class="form-select">
                                    <option value="galeri">Galeri Biasa</option>
                                    <option value="kenangan">Kenangan (Carousel)</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">File Foto</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" name="add_photo" class="btn btn-success">Upload Foto</button>
                    </form>
                </div>

                <div class="row g-3">
                    <?php foreach ($photos as $p): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="../<?= $p['image_path'] ?>" class="card-img-top"
                                    style="height:150px; object-fit:cover;">
                                <div class="card-body">
                                    <span class="badge bg-info mb-2">
                                        <?= strtoupper($p['type']) ?>
                                    </span>
                                    <h6 class="card-title">
                                        <?= htmlspecialchars($p['title']) ?>
                                    </h6>
                                    <a href="?delete=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger w-100"
                                        onclick="return confirm('Hapus foto ini?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($photos)): ?>
                        <div class="col-12 text-center text-muted">Belum ada foto yang diunggah.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>