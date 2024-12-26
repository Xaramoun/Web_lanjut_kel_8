<?php
try {
    $host = 'localhost';
    $dbname = 'db_tekom2a';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Mengambil data jumlah mahasiswa
$query = $pdo->query("SELECT COUNT(*) as total FROM mahasiswa");
$total_mahasiswa = $query->fetch(PDO::FETCH_ASSOC)['total'];

// Mengambil data jumlah dosen
$query = $pdo->query("SELECT COUNT(*) as total FROM dosen");
$total_dosen = $query->fetch(PDO::FETCH_ASSOC)['total'];

// Mengambil data jumlah kategori
$query = $pdo->query("SELECT COUNT(*) as total FROM kategori");
$total_kategori = $query->fetch(PDO::FETCH_ASSOC)['total'];

// Mengambil data jumlah berita
$query = $pdo->query("SELECT COUNT(*) as total FROM berita");
$total_berita = $query->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="container-fluid">
    <div class="row">
        <!-- Mahasiswa -->
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo $total_mahasiswa; ?></h3>
                    <p>Jumlah Mahasiswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="index.php?p=mhs" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Dosen -->
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?php echo $total_dosen; ?></h3>
                    <p>Jumlah Dosen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="index.php?p=dsn" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Kategori -->
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?php echo $total_kategori; ?></h3>
                    <p>Jumlah Kategori</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
                <a href="index.php?p=kategori" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Berita Section -->
    <h1>Berita</h1>

    <div class="row">
        <?php
        $query = $pdo->query("SELECT * FROM berita ORDER BY id DESC");
        while ($berita = $query->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="upload/<?= $berita['file_upload'] ?>" class="card-img-top" alt="..." style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $berita['judul'] ?></h5>
                        <p class="card-text"><?= substr($berita['isi_berita'], 0, 100) . '...' ?></p>
                        <a href="berita_detail.php?id=<?= $berita['id'] ?>" class="btn btn-primary mt-auto">Read More</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Chart -->
    <canvas id="beritaChart" style="height: 400px; width: 100%;"></canvas>

    <script>
        // ChartJS setup untuk statistik
        var ctx = document.getElementById('beritaChart').getContext('2d');
        var beritaChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mahasiswa', 'Dosen', 'Kategori', 'Berita'],
                datasets: [{
                    label: 'Jumlah',
                    data: [<?php echo $total_mahasiswa; ?>, <?php echo $total_dosen; ?>, <?php echo $total_kategori; ?>, <?php echo $total_berita; ?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>

<!-- Berita Detail Page -->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($berita) {
?>
    <div class="container mt-5">
        <div class="card shadow">
            <img src="upload/<?= $berita['file_upload'] ?>" class="card-img-top" alt="..." style="height: 300px; object-fit: cover;">
            <div class="card-body">
                <h2 class="card-title"><?= $berita['judul'] ?></h2>
                <p class="card-text"><?= $berita['isi_berita'] ?></p>
                <a href="dashboard.php" class="btn btn-secondary">Exit</a>
            </div>
        </div>
    </div>
<?php
    } else {
        echo "<p>Berita tidak ditemukan.</p>";
    }
}
?>
