<?php
    include '../../koneksi.php';
    session_start();
    
    $id = $_POST['id'];
    
    //LOAD PRODUK
    $query = mysqli_query($koneksi, 'SELECT a.*, b.keterangan FROM tb_tabungan_sampah_detail a INNER JOIN tb_jenis_sampah b ON a.id_jenis_sampah = b.id_jenis_sampah WHERE a.id_tabungan_sampah_detail = '. $id.' LIMIT 1');
    $row = mysqli_fetch_array($query);

    $data[] = array(
        "id" => $row['id_tabungan_sampah_detail'],
        "jenissampah" => $row['jenis_sampah'],
        "keterangan" => $row['keterangan'],
        "harga" => $row['harga'],
        "jumlah" => $row['berat'],
        "subtotal" => $row['subtotal']
    );


    echo json_encode($data);
    
	mysqli_close($koneksi);
?>