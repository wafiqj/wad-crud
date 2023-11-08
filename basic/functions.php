<?php 

$conn = mysqli_connect("localhost", "root", "", "tokoabc");

function query($query) {
    global $conn;

    $result = mysqli_query($conn, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows [] = $row;
    }

    return $rows;
}

function tambah($data) {
    global $conn;

    $kodebarang = $data["kodebarang"];
    $namabarang = $data["namabarang"];
    $hargajual = $data["hargajual"];
    $stokbarang = $data["stokbarang"];
    $gambarbarang = $data["gambarbarang"];

    $query = "INSERT INTO barang VALUES ('$kodebarang', '$namabarang', '$hargajual', '$stokbarang', '$gambarbarang')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($kode) {
    global $conn;
    
    $query = "DELETE FROM barang WHERE kode = '$kode'";
    mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $kodebarang = $data["kodebarang"];
    $namabarang = $data["namabarang"];
    $hargajual = $data["hargajual"];
    $stokbarang = $data["stokbarang"];
    $gambarbarang = $data["gambarbarang"];

    $query = "UPDATE barang SET kode = '$kodebarang', nama = '$namabarang', harga = '$hargajual', stok = '$stokbarang', gambar = '$gambarbarang' WHERE kode = '$kodebarang'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

?>