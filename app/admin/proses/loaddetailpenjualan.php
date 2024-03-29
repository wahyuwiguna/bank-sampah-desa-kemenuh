<?php
    include '../../koneksi.php';
    session_start();
    
    $id = $_POST['id'];
    
    //LOAD PRODUK
    $query = mysqli_query($koneksi, 'SELECT a.*, b.keterangan, b.stok FROM tb_penjualan_detail a INNER JOIN tb_jenis_sampah b ON a.id_jenis_sampah = b.id_jenis_sampah WHERE a.id_penjualan_detail = '. $id.' LIMIT 1');
    $row = mysqli_fetch_array($query);

    $data[] = array(
        "id" => $row['id_penjualan_detail'],
        "jenissampah" => $row['jenis_sampah'],
        "keterangan" => $row['keterangan'],
        "stok" => $row['stok'] + $row['berat'],
        "harga" => $row['harga'],
        "jumlah" => $row['berat'],
        "subtotal" => $row['subtotal']
    );


    echo json_encode($data);
    
	mysqli_close($koneksi);
?>