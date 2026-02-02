<?php
// admin/bucket_list.php
require_once '../lib/auth.php';
require_once '../lib/functions.php';
requireLogin();

$error = '';
$success = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $title = $_POST['title'] ?? '';
        if ($title) {
            $stmt = $pdo->prepare("INSERT INTO bucket_list (title) VALUES (?)");
            $stmt->execute([$title]);
            $success = "Wishlist berhasil ditambahkan!";
        }
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $title = $_POST['title'] ?? '';
        if ($id && $title) {
            $stmt = $pdo->prepare("UPDATE bucket_list SET title = ? WHERE id = ?");
            $stmt->execute([$title, $id]);
            $success = "Wishlist berhasil diperbarui!";
        }
    } elseif (isset($_POST['toggle'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $newStatus = $status ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE bucket_list SET is_done = ? WHERE id = ?");
        $stmt->execute([$newStatus, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM bucket_list WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Terhapus!";
    }
}

$buckets = getBucketList();
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
                    <a href="bucket_list.php" class="list-group-item list-group-item-action active">Kelola Bucket
                        List</a>
                    <a href="timeline.php" class="list-group-item list-group-item-action">Kelola Timeline</a>
                    <a href="messages.php" class="list-group-item list-group-item-action">Pesan Masuk</a>
                    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card-rose p-4">
                <h4 class="mb-4">Kelola Bucket List Kita 📝</h4>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="mb-5">
                    <div class="input-group">
                        <input type="text" name="title" class="form-control"
                            placeholder="Tulis rencana baru bareng caa..." required>
                        <button type="submit" name="add" class="btn btn-primary">Tambah Wishlist</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Wishlist</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($buckets as $b): ?>
                                <tr>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                            <input type="hidden" name="status" value="<?= $b['is_done'] ?>">
                                            <button type="submit" name="toggle"
                                                class="btn btn-sm <?= $b['is_done'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                                <?= $b['is_done'] ? 'Selesai' : 'Belum' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="<?= $b['is_done'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                        <?= htmlspecialchars($b['title']) ?>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal<?= $b['id'] ?>">
                                            Ubah
                                        </button>

                                        <form method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?= $b['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Wishlist</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label">Judul Wishlist</label>
                                                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($b['title']) ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
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