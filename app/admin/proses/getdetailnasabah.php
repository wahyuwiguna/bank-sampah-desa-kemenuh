<?php
    include '../../koneksi.php';
    session_start();
    
    $p_id = $_POST['p_id'];
    
    //LOAD PRODUK
    $SQL = mysqli_query($koneksi, "SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar WHERE a.id_nasabah = '". $p_id ."' LIMIT 1");
    $dt = mysqli_fetch_array($SQL);

    $id = $dt['id_nasabah'];
    $norek = $dt['no_rekening'];
    $nik = $dt['NIK'];
    $nama = $dt['nama_nasabah'];
    $alamat = $dt['alamat'];
    $banjar = $dt['nama_banjar'];
    $no_telp = $dt['no_telp'];
    $saldo = $dt['saldo'];
    

    echo json_encode(array("norek"=>$norek,"nik"=>$nik, "banjar"=>$banjar, "notelp"=>$no_telp, "nama"=>$nama, "alamat"=>$alamat, "saldo"=>$saldo));
    
	mysqli_close($koneksi);
?>