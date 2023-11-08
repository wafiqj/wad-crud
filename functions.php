<?php

$conn = mysqli_connect("localhost", "root", "", "tokoabc");

function ambil_barang($command) {
    global $conn;
    $result = mysqli_query($conn, $command);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[] = $row; 
    }
    return $rows;
}

function tambah_barang($data) {
    global $conn;
    $nama = $data["nama"];
    $harga = $data["harga"];
    $stok = $data["stok"];

    $query = "SELECT kode FROM barang ORDER BY kode DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $kode_terbaru = $row['kode'];
        $angka_terbaru = (int)substr($kode_terbaru, 3);
        $angka_baru = $angka_terbaru + 1;
        $angka_baru_format = str_pad($angka_baru, 3, '0', STR_PAD_LEFT);

        $kode = 'ABC' . $angka_baru_format;
    } else {
        $kode = 'ABC001';
    }

    $gambar = upload();
    if(!$gambar) {
        return false;
    } 

    $query = "INSERT INTO barang (kode, nama, harga, stok, gambar) VALUES ('$kode', '$nama', '$harga', '$stok', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if($error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu');
        </script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION);
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('File harus berupa gambar');
        </script>";
        return false;
    }

    if($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar');
        </script>";
        return false;
    }

    move_uploaded_file($tmpName, 'img/'.$namaFile);
    return $namaFile;
}

function hapus_barang($data) {
    global $conn;
    $kode = $data["kode"];

    $query = "DELETE FROM barang WHERE kode = '$kode'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubah_barang($data) {
    global $conn;
    $kode = $data["kode"];
    $nama = $data["nama"];
    $harga = $data["harga"];
    $stok = $data["stok"];
    $gambarLama = $data["gambar_lama"];
    
    $error = $_FILES["gambar"]["error"];

    if($error === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE barang SET nama = '$nama', harga = '$harga', stok = '$stok', gambar = '$gambar' WHERE kode = '$kode'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

?>