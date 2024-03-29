<?php
	
    function updateMaster($kd){
        include '../../koneksi.php';

        $query = "SELECT * FROM tb_penjualan_detail WHERE kode_penjualan = '". $kd ."'"; 
        $sql = mysqli_query($koneksi, $query); 
        $jumlah = 0;
        $subtotal = 0;

        while($data = mysqli_fetch_array($sql)){
            $jumlah += $data['berat'];
            $subtotal += $data['subtotal'];
        }

        //TB TABUNGAN SAMPAH
        $query = "UPDATE tb_penjualan SET total_berat = ". $jumlah .", total_harga = ". $subtotal ." WHERE kode = '". $kd ."'";
        $save = mysqli_query($koneksi, $query);
    }


    include '../../koneksi.php';
    session_start();

    $kd = $_POST['kd'];
    $id_jenis_sampah = $_POST['id_jenis_sampah'];
    $kode_sampah = $_POST['kode_sampah'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];
    
    $SQL2 = mysqli_query($koneksi, "SELECT * FROM tb_penjualan_detail WHERE kode_penjualan = '". $kd ."' AND id_jenis_sampah =". $id_jenis_sampah." LIMIT 1");
    $row = mysqli_num_rows($SQL2);

    if($row == 0){
        $query = "INSERT INTO tb_penjualan_detail(kode_penjualan, id_jenis_sampah, jenis_sampah, berat, harga, subtotal) VALUES('".$kd."',".$id_jenis_sampah.",'". $jenis_sampah ."',".$jumlah.",".$harga.",".$subtotal.")";
 
        if (mysqli_query($koneksi, $query)) {
            //UPDATE STOK
            $sql_produk = mysqli_query($koneksi, "SELECT stok FROM tb_jenis_sampah WHERE id_jenis_sampah = ". $id_jenis_sampah ." LIMIT 1");
            $dt = mysqli_fetch_array($sql_produk);
    
            $stok_baru = $dt['stok'] - $jumlah;
    
            $queryup = mysqli_query($koneksi, "UPDATE tb_jenis_sampah SET stok=".$stok_baru." WHERE id_jenis_sampah ='".$id_jenis_sampah."'");

            // UPDATE MASTER
            updateMaster($kd);

            echo json_encode(array("isError"=>false, "message"=>"OK"));
        } 
        else {
            echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan"));
        }

    }else{
        echo json_encode(array("isError"=>true, "message"=>"Jenis sampah sudah ditambahkan"));
    }

	mysqli_close($koneksi);
?>