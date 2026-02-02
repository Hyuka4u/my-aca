<?php
// admin/timeline.php
require_once '../lib/auth.php';
require_once '../lib/functions.php';
requireLogin();

$error = '';
$success = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $desc = $_POST['description'] ?? '';
        if ($title && $date) {
            $stmt = $pdo->prepare("INSERT INTO timeline (title, event_date, description) VALUES (?, ?, ?)");
            $stmt->execute([$title, $date, $desc]);
            $success = "Momen berhasil ditambahkan!";
        }
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $desc = $_POST['description'] ?? '';
        if ($id && $title && $date) {
            $stmt = $pdo->prepare("UPDATE timeline SET title = ?, event_date = ?, description = ? WHERE id = ?");
            $stmt->execute([$title, $date, $desc, $id]);
            $success = "Momen berhasil diperbarui!";
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM timeline WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Momen dihapus!";
    }
}

$events = getTimeline();
include '../views/partials/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card-rose p-3">
                <h5 class="mb-3">Navigasi Admin</h5>
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="gallery.php" class="list-group-item list-group-item-action">Kelola Galeri</a>
                    <a href="songs.php" class="list-group-item list-group-item-action">Kelola Lagu</a>
                    <a href="bucket_list.php" class="list-group-item list-group-item-action">Kelola Bucket List</a>
                    <a href="timeline.php" class="list-group-item list-group-item-action active">Kelola Timeline</a>
                    <a href="messages.php" class="list-group-item list-group-item-action">Pesan Masuk</a>
                    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card-rose p-4">
                <h4 class="mb-4">Kelola Lini Masa Kita ⏳</h4>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <div class="card mb-4 bg-light border-0">
                    <div class="card-body">
                        <h6 class="mb-3">Tambah Momen Baru</h6>
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="title" class="form-control"
                                        placeholder="Judul Momen (Misal: Pertama Ketemu)" required>
                                </div>
                                <div class="col-12">
                                    <textarea name="description" class="form-control" rows="2"
                                        placeholder="Cerita singkat tentang momen ini..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="add" class="btn btn-primary">Simpan Momen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kejadian</th>
                                <th>Keterangan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $ev): ?>
                                <tr>
                                    <td>
                                        <?= formatDate($ev['event_date']) ?>
                                    </td>
                                    <td><strong>
                                            <?= htmlspecialchars($ev['title']) ?>
                                        </strong></td>
                                    <td class="small">
                                        <?= htmlspecialchars($ev['description']) ?>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $ev['id'] ?>">
                                            Ubah
                                        </button>

                                        <form method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            <input type="hidden" name="id" value="<?= $ev['id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?= $ev['id'] ?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Momen</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <input type="hidden" name="id" value="<?= $ev['id'] ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal</label>
                                                                <input type="date" name="date" class="form-control"
                                                                    value="<?= $ev['event_date'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Judul Momen</label>
                                                                <input type="text" name="title" class="form-control"
                                                                    value="<?= htmlspecialchars($ev['title']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Keterangan</label>
                                                                <textarea name="description" class="form-control"
                                                                    rows="3"><?= htmlspecialchars($ev['description']) ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" name="edit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>