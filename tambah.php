<?php
require_once 'config/database.php';

$error = '';
$nama = '';
$kelas = '';
$alamat = '';
$no_hp = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $kelas  = trim($_POST['kelas'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $no_hp  = trim($_POST['no_hp'] ?? '');


    if (empty($nama) || empty($kelas)) {
        $error = 'Nama dan Kelas wajib diisi!';
    } else {
  
        $stmt = mysqli_prepare($conn, "INSERT INTO siswa (nama, kelas, alamat, no_hp) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $kelas, $alamat, $no_hp);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: index.php?msg=added");
                exit();
            } else {
                $error = 'Gagal menyimpan data: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = 'Gagal menyiapkan query: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - Sistem Informasi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Tambah Siswa</h1>
                <div class="subtitle">Masukkan data siswa baru ke dalam sistem</div>
            </div>
            <a href="index.php" class="btn btn-secondary">&larr; Kembali</a>
        </div>

        <!-- Alert Error -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Form -->
        <div class="form-card">
            <form action="tambah.php" method="POST">
                <div class="form-group">
                    <label for="nama">Nama Siswa <span class="required">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($nama); ?>" required>
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas <span class="required">*</span></label>
                    <input type="text" id="kelas" name="kelas" class="form-control" value="<?= htmlspecialchars($kelas); ?>" placeholder="Contoh: XII RPL 1" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat lengkap siswa"><?= htmlspecialchars($alamat); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="number" id="no_hp" name="no_hp" class="form-control" value="<?= htmlspecialchars($no_hp); ?>" placeholder="Contoh: 081234567890">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan Data</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>

        <div class="footer">
            &copy; <?= date('Y'); ?> Project Kelompok - Sistem Informasi Siswa
        </div>
    </div>
</body>
</html>
