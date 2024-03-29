<?php
	include '../../koneksi.php';

    $nama_user = $_POST['namauser'];
    $jenis_kelamin = $_POST['jeniskelamin'];
    $no_telp = $_POST['notelp'];
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $jabatan = $_POST['jabatan'];
    $password = md5($password1);

    $query = "INSERT INTO tb_user(nama_user, jenis_kelamin, no_telp,username, password, role) VALUES('".$nama_user."','".$jenis_kelamin."','".$no_telp."','".$username."','".$password."','".$jabatan."')";
    
	if (mysqli_query($koneksi, $query)) {
		echo json_encode(array("isError"=>false));
	} 
	else {
		echo json_encode(array("isError"=>true));
	}
	mysqli_close($koneksi);
?>