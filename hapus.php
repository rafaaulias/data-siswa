<?php
// Include database connection
require_once 'config/database.php';

// Validate student ID parameter
$id = $_GET['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php?msg=invalid_id");
    exit();
}

$id = (int)$id;

// Prepared statement for DELETE
$stmt = mysqli_prepare($conn, "DELETE FROM siswa WHERE id = ?");

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        header("Location: index.php?msg=error");
        exit();
    }
} else {
    header("Location: index.php?msg=error");
    exit();
}
?>
