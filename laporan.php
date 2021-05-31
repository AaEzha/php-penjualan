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
        width: 75%;
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
            <td><a>Laporan</a></td>
        </tr>
    </table>

    <p><strong>Laporan Transaksi</strong></p>
    <table  id="customers">
        <tr>
            <th>No.</th>
            <th>No. Transaksi</th>
            <th>Tanggal Transaksi</th>
            <th>Total Transaksi</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "select nomor, tanggal, sum(harga*jumlah) jumlah from transaksi group by nomor";
        $query = mysqli_query($db, $sql);
        $i = 1;
        while($row = mysqli_fetch_assoc($query)) :
        ?>
        <tr>
            <td><?=$i++;?></td>
            <td><?=$row['nomor'];?></td>
            <td><?=$row['tanggal'];?></td>
            <td>Rp <?=number_format($row['jumlah'], 0, ',', '.');?></td>
            <td><a href="detail.php?nomor=<?=$row['nomor'];?>">Detail Barang</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>