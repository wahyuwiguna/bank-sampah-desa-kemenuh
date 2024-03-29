<?php
	include '../../koneksi.php';

    session_start();

    $id_jenis_sampah = $_POST['id_jenis_sampah'];
    $kode_sampah = $_POST['kode_sampah'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];
    
    $SQL2 = mysqli_query($koneksi, "SELECT * FROM tb_penjualan_detail_temp WHERE id_jenis_sampah='". $id_jenis_sampah ."' AND id_user=". $_SESSION['id_user']." AND id_session = '". session_id() ."' LIMIT 1");
    $row = mysqli_num_rows($SQL2);

    if($row > 0){
        echo json_encode(array("isError"=>true, "message"=>"Jenis Sampah Sudah Ditambahkan"));
    }else{
        //NEW
        $query = "INSERT INTO tb_penjualan_detail_temp(id_user, id_session,id_jenis_sampah, kode_sampah, jenis_sampah, jumlah ,harga, subtotal) VALUES(".$_SESSION['id_user'].",'".session_id()."',".$id_jenis_sampah.",'".$kode_sampah."','".$jenis_sampah."',".$jumlah.",".$harga.",".$subtotal.")";

        if (mysqli_query($koneksi, $query)) {
            echo json_encode(array("isError"=>false, "message"=>"OK"));
        } 
        else {
            echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan"));
        }
    }

	mysqli_close($koneksi);
?>