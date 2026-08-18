<?php
// Include database connection
require_once 'config/database.php';

$error = '';

// Validate student ID from query parameter or post body
$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php?msg=invalid_id");
    exit();
}

$id = (int)$id;

// Handle Form Submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $kelas  = trim($_POST['kelas'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $no_hp  = trim($_POST['no_hp'] ?? '');

    // Validate required fields
    if (empty($nama) || empty($kelas)) {
        $error = 'Nama dan Kelas wajib diisi!';
    } else {
        // Prepared statement for UPDATE
        $stmt = mysqli_prepare($conn, "UPDATE siswa SET nama = ?, kelas = ?, alamat = ?, no_hp = ? WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $kelas, $alamat, $no_hp, $id);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: index.php?msg=updated");
                exit();
            } else {
                $error = 'Gagal memperbarui data: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = 'Gagal menyiapkan query: ' . mysqli_error($conn);
        }
    }
} else {
    // Fetch existing student record (GET)
    $stmt = mysqli_prepare($conn, "SELECT * FROM siswa WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) === 1) {
            $student = mysqli_fetch_assoc($result);
            $nama   = $student['nama'];
            $kelas  = $student['kelas'];
            $alamat = $student['alamat'];
            $no_hp  = $student['no_hp'];
        } else {
            mysqli_stmt_close($stmt);
            header("Location: index.php?msg=notfound");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa - Sistem Informasi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Edit Data Siswa</h1>
                <div class="subtitle">Perbarui data siswa dalam sistem</div>
            </div>
            <a href="index.php" class="btn btn-secondary">&larr; Kembali</a>
        </div>

        <!-- Alert Error -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Form -->
        <div class="form-card">
            <form action="edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $id; ?>">

                <div class="form-group">
                    <label for="nama">Nama Siswa <span class="required">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($nama ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas <span class="required">*</span></label>
                    <input type="text" id="kelas" name="kelas" class="form-control" value="<?= htmlspecialchars($kelas ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control"><?= htmlspecialchars($alamat ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" value="<?= htmlspecialchars($no_hp ?? ''); ?>">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; <?= date('Y'); ?> Project Kelompok - Sistem Informasi Siswa
        </div>
    </div>
</body>
</html>
