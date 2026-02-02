<?php
// admin/dashboard.php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/functions.php';
requireLogin();

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_settings'])) {
        $startDate = $_POST['relationship_start_date'];
        $lockPw = $_POST['admin_lock_password'];

        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'relationship_start_date'");
        $stmt->execute([$startDate]);

        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'admin_lock_password'");
        $stmt->execute([$lockPw]);

        $success = "Pengaturan berhasil diperbarui!";
    }
}

$startDate = getSetting('relationship_start_date');
$lockPw = getSetting('admin_lock_password');

// Get message count
$msgCount = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$galleryCount = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();

?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard - Untukmu Sayang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body style="background:#f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="../index.php" target="_blank">Lihat Situs</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                    <a href="gallery.php" class="list-group-item list-group-item-action">Kelola Galeri</a>
                    <a href="songs.php" class="list-group-item list-group-item-action">Kelola Lagu</a>
                    <a href="bucket_list.php" class="list-group-item list-group-item-action">Kelola Bucket List</a>
                    <a href="timeline.php" class="list-group-item list-group-item-action">Kelola Timeline</a>
                    <a href="messages.php" class="list-group-item list-group-item-action">
                        Pesan Masuk (<?= $msgCount ?>)
                    </a>
                    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Dashboard</h2>
                <hr>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card p-3 shadow-sm">
                            <h5>Total Foto</h5>
                            <p class="display-6">
                                <?= $galleryCount ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 shadow-sm">
                            <h5>Total Pesan</h5>
                            <p class="display-6">
                                <?= $msgCount ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm p-4">
                    <h4>Pengaturan Situs</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Jadian (YYYY-MM-DD)</label>
                            <input type="date" name="relationship_start_date" class="form-control"
                                value="<?= $startDate ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Overlay (Login Awal)</label>
                            <input type="text" name="admin_lock_password" class="form-control" value="<?= $lockPw ?>"
                                required>
                            <small class="text-muted">Password yang harus dimasukkan pengunjung saat pertama kali buka
                                web.</small>
                        </div>
                        <button type="submit" name="update_settings" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>