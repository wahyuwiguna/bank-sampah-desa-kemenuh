<?php
	include '../../koneksi.php';

    $id_user = $_POST['iduser'];
    $nama_user = $_POST['namauser'];
    $jenis_kelamin = $_POST['jeniskelamin'];
    $no_telp = $_POST['notelp'];
    $jabatan = $_POST['jabatan'];
    $status = $_POST['status'];

    $query = "UPDATE tb_user SET nama_user='".$nama_user."', jenis_kelamin='".$jenis_kelamin."', no_telp='".$no_telp."', role='".$jabatan."', status='".$status."' WHERE id_user='".$id_user."'";
    
	if (mysqli_query($koneksi, $query)) {
		echo json_encode(array("isError"=>false));
	} 
	else {
		echo json_encode(array("isError"=>true));
	}
	mysqli_close($koneksi);
?>