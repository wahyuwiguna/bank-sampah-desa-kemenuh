<?php
	include '../../koneksi.php';

    $id = $_POST['id'];
    $password0 = $_POST['passwordlama'];
    $passwordlama = md5($password0);

    $password1 = $_POST['password'];
    $password = md5($password1);
    

    $q_kar = mysqli_query($koneksi, "SELECT * FROM tb_nasabah WHERE id_nasabah = '". $id ."' LIMIT 1");
    $d_kar = mysqli_fetch_array($q_kar);

    if($passwordlama == $d_kar['password']){
        $query = "UPDATE tb_nasabah SET password ='".$password."' WHERE id_nasabah='".$id."'";
    
        if (mysqli_query($koneksi, $query)) {
            echo json_encode(array("isError"=>false, "message"=> "Password Berhasil Diubah"));
        } 
        else {
            echo json_encode(array("isError"=>true, "message"=> "Terjadi Keesalahan Penyimpanan"));
        }    
    }else{
        echo json_encode(array("isError"=>true, "message"=> "Password Lama Anda Salah"));
    }

    
	mysqli_close($koneksi);
?>