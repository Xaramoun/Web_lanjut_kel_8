<?php
include 'koneksi.php'; 

// Mengambil ID berita dari URL
$id = $_GET['id'];

try {
    // Mengambil data berita berdasarkan ID
    $sql = "SELECT * FROM berita WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika berita tidak ditemukan
    if (!$berita) {
        echo "<div class='alert alert-danger'>Berita tidak ditemukan.</div>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="container my-5">
    <div class="card shadow-lg">
        <img src="upload/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top img-fluid" alt="Gambar Berita" style="max-height: 400px; object-fit: cover;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4"><?= htmlspecialchars($berita['judul']) ?></h2>
            <p class="card-text text-justify" style="line-height: 1.6;"><?= nl2br(htmlspecialchars($berita['isi_berita'])) ?></p>
            <a href="http://localhost/web_lanjut_kel_8/admin/index.php?p=dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<style>
    .card-text {
        font-size: 16px;
    }
</style>
