<?php
	include '../../koneksi.php';

    $id = $_POST['idjenissampah'];
    $jenissampah = $_POST['jenissampah'];
    $keterangan = $_POST['keterangan'];
    $hargabeli = preg_replace('/\D/','',$_POST['hargabeli']);
    $hargajual = preg_replace('/\D/','',$_POST['hargajual']);
    $status = $_POST['status'];


	$query = "UPDATE tb_jenis_sampah SET jenis_sampah ='".$jenissampah."', keterangan ='".$keterangan."', harga_beli =".$hargabeli.", harga_jual =".$hargajual.", status='".$status."' WHERE id_jenis_sampah ='".$id."'";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(array("isError"=>false, "message"=>"Barang Berhasil Diubah"));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Kesalahan Penyimpanan"));
    }
    
    
	mysqli_close($koneksi);
?>
