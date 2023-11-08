<?php

require 'functions.php';

if(isset($_POST["tambah_barang"])) {
    if(tambah_barang($_POST)) {
        echo "<script>
            alert('Berhasil menambahkan barang');
            </script>";
    } else {
        echo "<script>
            alert('Gagal menambahkan barang');
            </script>";
    }
}

if(isset($_POST["hapus_barang"])) {
    if(hapus_barang($_POST)) {
        echo "<script>
            alert('Berhasil menghapus barang');
            </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus barang');
            </script>";
    }
}

if(isset($_POST["ubah_barang"])) {
    if(ubah_barang($_POST)) {
        echo "<script>
            alert('Berhasil mengubah barang');
            </script>";
    } else {
        echo "<script>
            alert('Gagal mengubah barang');
            </script>";
    }
}

$barangs = ambil_barang("SELECT * FROM barang");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko ABC</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

</head>
<body>
    <div class="container">
        <h3 class="my-5">Daftar Barang Toko ABC</h3>

        <table class="table table-hover table-bordered">
            <thead>
                <tr class="text-center">
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col" style="width: 15%;">Gambar</th>
                    <th scope="col" style="width: 25%;">Nama Barang</th>
                    <th scope="col" style="width: 10%;">Kode Barang</th>
                    <th scope="col" style="width: 20%;">Harga Barang</th>
                    <th scope="col" style="width: 10%;">Stok Barang</th>
                    <th scope="col" style="width: 15%;"></th>
                </tr>
                <tr class="text-center">
                    <th colspan="7">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                            <i class="fa fa-plus text-light"></i>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($barangs)) : ?>
                    <?php $i=1 ?>
                    <?php foreach($barangs as $barang) : ?>
                        <tr class="text-center">
                            <th scope="row"><?= $i ?></th>
                            <td>
                                <img src="img/<?= $barang["gambar"]  ?>" class="gambar_barang" alt="">
                            </td>
                            <td><?= $barang["nama"]  ?></td>
                            <td><?= $barang["kode"]  ?></td>
                            <td>Rp<?= number_format($barang["harga"], 2, ",", ".") ?></td>
                            <td><?= $barang["stok"]  ?></td>
                            <td>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="text" class="form-control" name="kode" id="kode" required hidden value="<?= $barang["kode"] ?>">
                                    
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubahBarangModal<?= $barang["kode"] ?>">
                                        <i class="fa fa-pencil text-light"></i>
                                    </button>
                                    <button type="submit" name="hapus_barang" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data?')">
                                        <i class="fa fa-trash text-light"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="ubahBarangModal<?= $barang["kode"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fs-5" id="exampleModalLabel">Ubah Barang Baru</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mx-3">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="kode" value="<?= $barang["kode"] ?>">
                                            <div class="d-flex flex-column mb-3">
                                                <label for="gambar">Gambar Barang</label>
                                                <img src="img/<?= $barang["gambar"] ?>" alt="" class="mb-3">
                                                <input type="hidden" name="gambar_lama" value="<?= $barang["gambar"] ?>">
                                                <input type="file" class="form-control" id="gambar" name="gambar">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama">Nama Barang</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $barang["nama"] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga">Harga Barang</label>
                                                <input type="number" class="form-control" id="harga" name="harga" value="<?= $barang["harga"] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="stok">Stok Barang</label>
                                                <input type="number" class="form-control" id="stok" name="stok" value="<?= $barang["stok"] ?>" required>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" name="ubah_barang" class="btn btn-primary">Ubah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <?php $i++ ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="text-center">
                        <td colspan="7">Barang belum tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama">Nama Barang</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga">Harga Barang</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok">Stok Barang</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Gambar Barang</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="tambah_barang" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>