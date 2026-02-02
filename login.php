<?php
// login.php
require_once 'lib/auth.php';

if (isLoggedIn()) {
    header("Location: admin/dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $master_key = $_POST['master_key'] ?? '';
    
    // Get master key from settings (fallback to 'Matcha')
    require_once 'lib/functions.php';
    $correct_key = getSetting('admin_lock_password') ?: 'Matcha';

    if (strtolower($master_key) === strtolower($correct_key)) {
        $_SESSION['user_id'] = 1; // Dummy ID for admin
        $_SESSION['username'] = 'Admin';
        header("Location: admin/dashboard.php");
        exit();
    } else {
        $error = "Kata kunci salah!";
    }
}

include 'views/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card-rose p-4">
                <h4 class="text-center mb-4">Login Admin</h4>
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Master Key</label>
                        <input type="password" name="master_key" class="form-control"
                            placeholder="Masukkan kata kunci (Matcha)" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Unlock Dashboard</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="index.php" class="muted-small">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>