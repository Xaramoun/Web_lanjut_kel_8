<?php
include 'koneksi.php'; // Pastikan file koneksi.php sudah benar dengan $pdo terdefinisi

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Matakuliah</h1>
        </div>
        <div class="row">
            <div class="col-3 mb-3">
                <a href="index.php?p=matkul&aksi=input" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Matakuliah</a>
            </div>
            <div class="table-responsive small">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Kode Matakuliah</th>
                        <th>Nama Matakuliah</th>
                        <th>Semester</th>
                        <th>Jenis Matakuliah</th>
                        <th>SKS</th>
                        <th>JAM</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    try {
                        $query = $pdo->query("SELECT * FROM matakuliah");
                        $no = 1;
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['id'] ?></td>
                                <td><?= $data['kode_matakuliah'] ?></td>
                                <td><?= $data['nama_matakuliah'] ?></td>
                                <td><?= $data['semester'] ?></td>
                                <td><?= $data['jenis_matakuliah'] ?></td>
                                <td><?= $data['sks'] ?></td>
                                <td><?= $data['jam'] ?></td>
                                <td><?= $data['keterangan'] ?></td>
                                <td>
                                    <a href="index.php?p=matkul&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success"><i class="bi bi-pencil"></i> Edit</a>
                                    <a href="proses_matakuliah.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')"><i class="bi bi-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
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
            <h1 class="h2">Input Mata Kuliah</h1>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <form action="proses_matakuliah.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" name="kode_matkul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" name="nama_matkul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" name="semester" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Mata Kuliah</label>
                        <select class="form-select" name="jenis_matkul" required>
                            <option value="">Pilih Jenis Mata Kuliah</option>
                            <option value="teori">Teori</option>
                            <option value="praktek">Praktek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" class="form-control" name="sks" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" name="keterangan" required></textarea>
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
        try {
            $stmt = $pdo->prepare("SELECT * FROM matakuliah WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Mata Kuliah</h1>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <form action="proses_matakuliah.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" name="kode_matkul" value="<?= $data['kode_matakuliah'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" name="nama_matkul" value="<?= $data['nama_matakuliah'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" name="semester" value="<?= $data['semester'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Mata Kuliah</label>
                        <select class="form-select" name="jenis_matkul" required>
                            <option value="teori" <?= $data['jenis_matakuliah'] == 'teori' ? 'selected' : '' ?>>Teori</option>
                            <option value="praktek" <?= $data['jenis_matakuliah'] == 'praktek' ? 'selected' : '' ?>>Praktek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" class="form-control" name="sks" value="<?= $data['sks'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" value="<?= $data['jam'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" name="keterangan" required><?= $data['keterangan'] ?></textarea>
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
