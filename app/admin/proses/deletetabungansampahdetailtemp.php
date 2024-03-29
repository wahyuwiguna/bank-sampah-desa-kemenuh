<?php
	include '../../koneksi.php';

    session_start();

    $id = $_POST['id'];
    // $nasabah = $_POST['nasabah'];
    
    //VALIDASI STOK
    $query = "DELETE FROM tb_tabungan_sampah_detail_temp WHERE id_tabungan_sampah_detail_temp = ". $id."";

    if (mysqli_query($koneksi, $query)) {

        $query2 = mysqli_query($koneksi, 'SELECT * FROM tb_tabungan_sampah_detail_temp WHERE id_user = '. $_SESSION['id_user'] .' AND id_session = "'. session_id() .'"');

        $rowcount = mysqli_num_rows($query2);
        echo json_encode(array("isError"=>false, "message"=>"OK", "baris"=>$rowcount));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan"));
    }

	mysqli_close($koneksi);
?>