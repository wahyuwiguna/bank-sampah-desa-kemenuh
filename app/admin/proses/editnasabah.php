<?php
	include '../../koneksi.php';

    $id = $_POST['id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $banjar = $_POST['banjar'];
    $notelp = $_POST['notelp'];
    $status = $_POST['status'];


    //CEK NIK
    $modal = mysqli_query($koneksi,"SELECT * FROM tb_nasabah WHERE NIK = '". $nik ."' AND id_nasabah != '". $id ."' LIMIT 1");
    $d_nik = mysqli_num_rows($modal);


    if($d_nik > 0){
        echo json_encode(array("isError"=>true, "message"=>"NIK sudah terdaftar."));

    }else{
        $query = "UPDATE tb_nasabah SET nik ='".$nik."', nama_nasabah='".$nama."', alamat='".$alamat."',id_banjar=".$banjar.", no_telp='".$notelp."', status='".$status."' WHERE id_nasabah='".$id."'";
    
        if (mysqli_query($koneksi, $query)) {
            echo json_encode(array("isError"=>false));
        } 
        else {
            echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan."));
        }
    }


   
	mysqli_close($koneksi);
?>