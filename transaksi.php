<?php include "database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjualan</title>
    <style>
    /**
        Sumber
        https://www.w3schools.com/css/css_link.asp
     */
    /* unvisited link */
    a:link {
    color: blue;
    }

    /* visited link */
    a:visited {
    color: blue;
    }

    /* mouse over link */
    a:hover {
    color: blue;
    }

    /* selected link */
    a:active {
    color: blue;
    }

    /**
        Sumber
        https://www.w3schools.com/css/tryit.asp?filename=trycss_table_fancy
     */
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: black;
    }
    </style>
</head>
<body>
    <p><strong>Penjualan</strong></p>
    <p>Programmer : Vierera Dewi Ayulia</p>

    <table>
        <tr>
            <td style="width: 200px;"><a href="index.php">Master Barang</a></td>
            <td style="width: 200px;"><a>Input Transaksi</a></td>
            <td><a href="laporan.php">Laporan</a></td>
        </tr>
    </table>

    <p><strong>Form <?php if(isset($_GET['edit'])){ echo "Edit"; }else{ echo "Input"; } ?> Belanja</strong></p>
    <?php
    if(isset($_POST['submit'])){
        $id_barang = $_POST['id_barang'];
        $jumlah = $_POST['jumlah'];

        // cari harga barang
        $s = "select harga,jumlah from barang where id='$id_barang'";
        $q = mysqli_query($db, $s);
        $r = mysqli_fetch_assoc($q);
        $harga = $r['harga'];
        $jml = $r['jumlah'];

        if($jumlah > $jml){
            echo "Error: Stok barang tidak mencukupi";
        }else{
            $sql = "insert into keranjang (id_barang, jumlah, harga) values('$id_barang', '$jumlah', '$harga')";
            $query = mysqli_query($db, $sql);
            if($query){
                echo "<em>Data berhasil disimpan.</em>";
            }else{
                echo "<em>Data gagal disimpan.</em>";
            }
        }

    }

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $sql = "delete from keranjang where id='$id'";
        $query = mysqli_query($db, $sql);
        if($query){
            echo "<em>Data berhasil dihapus.</em>";
        }else{
            echo "<em>Data gagal dihapus.</em>";
        }
        echo "<script>window.location.replace('transaksi.php');</script>";
    }
    ?>
    <form action="" method="POST">
        <table>
        <tr>
                <td style="width: 150px;">Nama Barang</td>
                <td>
                    <select name="id_barang" id="id_barang" required>
                    <?php
                    $sql = "select * from barang where jumlah > 0";
                    $query = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($query)) : ?>
                        <option value="<?=$row['id'];?>">
                        <?=$row['nama'];?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>
                    <input type="number" name="jumlah" id="jumlah" min="1" value="1" required>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <?php if(isset($_GET['edit'])){ ?>
                    <input type="submit" name="edit" id="edit" value="Simpan">
                    <?php }else{ ?>
                    <input type="submit" name="submit" id="submit" value="Simpan">
                    <?php } ?>
                </td>
            </tr>
        </table>
    </form>

    <p><strong>Data Belanja</strong></p>
    <table  id="customers">
        <tr>
            <td colspan="2">No. Transaksi</td>
            <td colspan="5"><?=time();?></td>
        </tr>
        <tr>
            <td colspan="2">Tanggal Transaksi</td>
            <td colspan="5"><?=date('d F Y, H:i');?></td>
        </tr>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "select barang.kode, barang.nama, keranjang.jumlah, keranjang.harga, keranjang.id from keranjang join barang on barang.id=keranjang.id_barang";
        $query = mysqli_query($db, $sql);
        $i = 1;
        $total = 0;
        while($row = mysqli_fetch_assoc($query)) :
        ?>
        <tr>
            <td><?=$i++;?></td>
            <td><?=$row['kode'];?></td>
            <td><?=$row['nama'];?></td>
            <td><?=number_format($row['jumlah'], 0, ',', '.');?></td>
            <td><?=number_format($row['harga'], 0, ',', '.');?></td>
            <td><?=number_format($row['harga']*$row['jumlah'], 0, ',', '.');?></td>
            <td><a href="transaksi.php?delete=<?=$row['id'];?>" onclick="return confirm('Anda yakin ingin menghapus ini?')">hapus</a></td>
        </tr>
        <?php $total += $row['harga']*$row['jumlah']; ?>
        <?php endwhile; ?>
        <tr>
            <td colspan="5" align="right">Total</td>
            <td><?=number_format($total, 0, ',', '.');?></td>
            <td>
                <form action="simpan.php" method="POST">
                <input type="submit" name="checkout" value="Checkout">
                </form>
            </td>
        </tr>
    </table>
</body>
</html>