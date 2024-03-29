<?php
    include '../../koneksi.php';
    session_start();
    
    $p_id = $_POST['p_id'];
    
    //LOAD PRODUK
    $SQL = mysqli_query($koneksi, "SELECT a.* FROM tb_jenis_sampah a WHERE a.id_jenis_sampah = '". $p_id ."' LIMIT 1");
    $dt = mysqli_fetch_array($SQL);

    $kode_sampah = $dt['kode_sampah'];
    $jenis_sampah = $dt['jenis_sampah'];
    $keterangan = $dt['keterangan'];
    $harga_beli = $dt['harga_beli'];
    $harga_jual = $dt['harga_jual'];
    $stok = $dt['stok'];
    // $gambar= $dt['gambar'];

    echo json_encode(array("keterangan"=>$keterangan,"harga_beli"=>$harga_beli, "harga_jual"=>$harga_jual, "stok"=>$stok, "kode_sampah"=>$kode_sampah));
    
	mysqli_close($koneksi);
?>