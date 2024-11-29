<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Prodi</title>
</head>
<body>
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Prodi</h1>
    </div>

    <?php
    include 'koneksi.php'; 
    $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

    switch ($aksi) {
        case 'list':
            ?>
            <div class="row">
                <div class="col-2 mb-3">
                    <a href="index.php?p=prodi&aksi=input" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Prodi
                    </a>
                </div>

                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Prodi</th>
                                <th>Jenjang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = $db->query("SELECT * FROM prodi");
                        $no = 1;
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
                                <td><?= htmlspecialchars($data['jenjang_std']) ?></td> 
                                <td>
                                    <a href="index.php?p=prodi&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="proses_prodi.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            break;

        case 'input':
            ?>
            <div class="row">
                <div class="col-6 mx-auto">
                    <br>
                    <h2>Data Prodi</h2>
                    <form action="proses_prodi.php?proses=insert" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Prodi</label>
                            <input type="text" class="form-control" name="nama_prodi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenjang</label>
                            <select class="form-select" name="jenjang_std" required> 
                                <option selected>~ Pilih Jenjang ~</option>
                                <?php
                                $jenjang = ['D3', 'D4', 'S1', 'S2'];
                                foreach ($jenjang as $jenjangstudi) {
                                    echo "<option value=\"$jenjangstudi\">$jenjangstudi</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
            <?php
            break;

        case 'edit':
            $stmt = $db->prepare("SELECT * FROM prodi WHERE id = :id");
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $data_prodi = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <div class="row">
                <div class="col-6 mx-auto">
                    <br>
                    <h2>Edit Data Prodi</h2>
                    <form action="proses_prodi.php?proses=edit" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Prodi</label>
                            <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($data_prodi['id']) ?>">
                            <input type="text" class="form-control" name="nama_prodi" value="<?= htmlspecialchars($data_prodi['nama_prodi']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenjang</label>
                            <select class="form-select" name="jenjang_std" required> 
                                <?php
                                $jenjang = ['D3', 'D4', 'S1', 'S2'];
                                foreach ($jenjang as $jenjangstudi) {
                                    $selected = ($data_prodi['jenjang_std'] == $jenjangstudi) ? 'selected' : '';
                                    echo "<option value=\"$jenjangstudi\" $selected>$jenjangstudi</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
            <?php
            break;
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
