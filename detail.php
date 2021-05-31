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
            <td style="width: 200px;"><a href="transaksi.php">Input Transaksi</a></td>
            <td><a href="laporan.php">Laporan</a></td>
        </tr>
    </table>

    <?php
    $nomor = $_GET['nomor'];
    $sql = "select * from transaksi where nomor='$nomor'";
    $query = mysqli_query($db, $sql);
    $i = 1;
    $total = 0;
    $row = mysqli_fetch_assoc($query);

    $old_date_timestamp = strtotime($row['tanggal']);
    $new_date = date('d F Y, H:i', $old_date_timestamp);  
    ?>

    <p><strong>Laporan Detail Barang</strong></p>
    <table  id="customers">
        <tr>
            <td colspan="2">No. Transaksi</td>
            <td colspan="5"><?=$row['nomor'];?></td>
        </tr>
        <tr>
            <td colspan="2">Tanggal Transaksi</td>
            <td colspan="5"><?=$new_date;?></td>
        </tr>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
        <?php
        $sql = "select barang.kode, barang.nama, transaksi.jumlah, transaksi.harga, transaksi.id from transaksi join barang on barang.id=transaksi.id_barang where transaksi.nomor='$nomor'";
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
        </tr>
        <?php $total += $row['harga']*$row['jumlah']; ?>
        <?php endwhile; ?>
        <tr>
            <td colspan="5" align="right">Total</td>
            <td><?=number_format($total, 0, ',', '.');?></td>
        </tr>
    </table>
</body>
</html>