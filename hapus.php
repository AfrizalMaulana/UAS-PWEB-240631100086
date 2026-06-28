<?php
session_start();
require_once 'functions/functions.php';

$id = $_GET['id'] ?? 0;
if ($id > 0) {
    if (hapusBarang($id)) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data berhasil dihapus!'];
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal menghapus data.'];
    }
} else {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID tidak valid!'];
}

header('Location: daftar.php');
exit;
?>