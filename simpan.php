<?php
include "database.php"; 

$nomor = time();
$tanggal = date('Y-m-d H:i:s');

$sql = "select * from keranjang";
$query = mysqli_query($db, $sql);

$jum = mysqli_num_rows($query);
if($jum < 1){
    echo "<script>window.location.replace('transaksi.php');</script>";
}

while($row = mysqli_fetch_assoc($query)){
    $id_barang = $row['id_barang'];
    $harga = $row['harga'];
    $jumlah = $row['jumlah'];

    // pengurangan stok barang
    $a = mysqli_query($db, "select * from barang where id='$id_barang'");
    $ra = mysqli_fetch_assoc($a);
    $jml = $ra['jumlah'] - $jumlah;
    mysqli_query($db, "update barang set jumlah='$jml' where id='$id_barang'");

    $s = "insert into transaksi (nomor, tanggal, id_barang, harga, jumlah) values ";
    $s .= "('$nomor', '$tanggal', '$id_barang', '$harga', '$jumlah')";
    $q = mysqli_query($db, $s);
}
mysqli_query($db, 'truncate keranjang');
echo "<script>window.location.replace('transaksi.php');</script>";
?>