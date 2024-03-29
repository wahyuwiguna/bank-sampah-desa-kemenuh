<?php
	include '../../koneksi.php';

    session_start();

    $id = $_POST['id'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];
    
    $SQL2 = mysqli_query($koneksi, "SELECT * FROM tb_penjualan_detail_temp WHERE id_penjualan_detail_temp = '". $id ."' LIMIT 1");
    $row = mysqli_num_rows($SQL2);

    if($row > 0){
        //UPDATE
        while($data = mysqli_fetch_array($SQL2)){
            
            $query = "UPDATE tb_penjualan_detail_temp SET jumlah = ". $jumlah .", harga = ". $harga .", subtotal = ". $subtotal ." WHERE id_penjualan_detail_temp = ". $id ."";

            if (mysqli_query($koneksi, $query)) {
                echo json_encode(array("isError"=>false, "message"=>"OKE"));
            } 
            else {
                echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan"));
            }
        }

    }else{
        echo json_encode(array("isError"=>true, "message"=>"Detail Jenis Sampah Tidak Ditemukan"));
    }

	mysqli_close($koneksi);
?>