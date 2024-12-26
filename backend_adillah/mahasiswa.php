<?php 
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Mahasiswa</h1>
        </div>
        <div class="row">
            <div class="col-3 mb-3">
                <a href="index.php?p=mhs&aksi=input" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Mahasiswa</a>
            </div>
            <div class="table-responsive small">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Tanggal Lahir</th>
                        <th>Email</th>
                        <th>Prodi</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    include 'koneksi.php';
                    $stmt = $pdo->query("SELECT mahasiswa.*, prodi.nama_prodi FROM mahasiswa INNER JOIN prodi ON mahasiswa.prodi_id = prodi.id");
                    $no = 1;
                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nama_mhs'] ?></td>
                            <td><?= $data['tgl_lahir'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['nama_prodi'] ?></td>
                            <td><?= $data['notelp'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td>
                                <a href="index.php?p=mhs&aksi=edit&nim=<?= $data['nim'] ?>" class="btn btn-success"><i class="bi bi-pencil"></i> Edit</a>
                                <a href="proses_mahasiswa.php?proses=delete&nim=<?= $data['nim'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="bi bi-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
        break;

    case 'input':
        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Input Mahasiswa</h1>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <br>
                <h2>Form Registrasi Mahasiswa</h2>
                <form action="proses_mahasiswa.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="number" class="form-control" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="" selected>--pilihan prodi--</option>
                            <?php
                            include 'koneksi.php';
                            $stmt = $pdo->query("SELECT * FROM prodi");
                            while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='".$data_prodi['id']."'>".$data_prodi['nama_prodi']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" class="form-control" name="notelp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="3" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        break;

    case 'edit':
        include 'koneksi.php';
        $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE nim = :nim");
        $stmt->execute(['nim' => $_GET['nim']]);
        $data_mhs = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data_mhs) {
            echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";
            exit;
        }

        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Mahasiswa</h1>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <br>
                <h2>Edit Data Mahasiswa</h2>
                <form action="proses_mahasiswa.php?proses=edit" method="post">
                    <input type="hidden" name="nim" value="<?= $data_mhs['nim'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data_mhs['nama_mhs'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="" disabled>--pilihan prodi--</option>
                            <?php
                            $stmt_prodi = $pdo->query("SELECT * FROM prodi");
                            while ($data_prodi = $stmt_prodi->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($data_prodi['id'] == $data_mhs['prodi_id']) ? 'selected' : '';
                                echo "<option value='".$data_prodi['id']."' $selected>".$data_prodi['nama_prodi']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" value="<?= $data_mhs['tgl_lahir'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $data_mhs['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" class="form-control" name="notelp" value="<?= $data_mhs['notelp'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="3" name="alamat" required><?= $data_mhs['alamat'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                        <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        break;
}
?>
