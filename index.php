<?php
// Include database connection
require_once 'config/database.php';

// Fetch all students ordered by ID descending
$query = "SELECT * FROM siswa ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Sistem Informasi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Data Siswa</h1>
                <div class="subtitle">Sistem Informasi Manajemen Data Siswa</div>
            </div>
            <a href="tambah.php" class="btn">+ Tambah Siswa</a>
        </div>

        <!-- Alert Notification -->
        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'added'): ?>
                <div class="alert alert-success">Data siswa berhasil ditambahkan.</div>
            <?php elseif ($_GET['msg'] === 'updated'): ?>
                <div class="alert alert-success">Data siswa berhasil diperbarui.</div>
            <?php elseif ($_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-success">Data siswa berhasil dihapus.</div>
            <?php elseif ($_GET['msg'] === 'notfound'): ?>
                <div class="alert alert-danger">Data siswa tidak ditemukan.</div>
            <?php elseif ($_GET['msg'] === 'invalid_id'): ?>
                <div class="alert alert-danger">ID Siswa tidak valid.</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Table or Empty State -->
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)): 
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['kelas']); ?></td>
                                <td><?= htmlspecialchars($row['alamat'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['no_hp'] ?? '-'); ?></td>
                                <td>
                                    <div class="action-links">
                                        <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?');">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Belum ada data siswa.</p>
                <a href="tambah.php" class="btn btn-secondary">Tambah Siswa Pertama</a>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="footer">
            &copy; <?= date('Y'); ?> Project Kelompok - Sistem Informasi Siswa
        </div>
    </div>
</body>
</html>
