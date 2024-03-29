<?php
	include '../../koneksi.php';

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $no_telp = $_POST['notelp'];
    $status = $_POST['status'];

    $query = "UPDATE tb_pengepul SET nama_pengepul='".$nama."', no_telp='".$no_telp."', status='".$status."' WHERE id_pengepul='".$id."'";
    
	if (mysqli_query($koneksi, $query)) {
		echo json_encode(array("isError"=>false));
	} 
	else {
		echo json_encode(array("isError"=>true));
	}
	mysqli_close($koneksi);
?>