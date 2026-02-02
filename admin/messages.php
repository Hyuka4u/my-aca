<?php
// admin/messages.php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/functions.php';
requireLogin();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: messages.php");
    exit();
}

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesan Masuk - Admin Panel</title>
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
                    <a href="songs.php" class="list-group-item list-group-item-action">Kelola Lagu</a>
                    <a href="bucket_list.php" class="list-group-item list-group-item-action">Kelola Bucket List</a>
                    <a href="timeline.php" class="list-group-item list-group-item-action">Kelola Timeline</a>
                    <a href="messages.php" class="list-group-item list-group-item-action active">Pesan Masuk</a>
                    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Pesan Proposal</h2>
                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Respon</th>
                                <th>Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td>
                                        <?= formatDate($msg['created_at'], 'd M Y H:i') ?>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-<?= $msg['response'] === 'accept' ? 'success' : 'secondary' ?>">
                                            <?= strtoupper($msg['response']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($msg['message']) ?>
                                    </td>
                                    <td>
                                        <a href="?delete=<?= $msg['id'] ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus pesan ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($messages)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada pesan masuk.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>