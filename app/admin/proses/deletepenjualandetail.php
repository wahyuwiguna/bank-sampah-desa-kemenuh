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

        //TB ARUS KAS
        $query2 = "UPDATE tb_arus_kas SET debit = ". $subtotal ." WHERE kode_transaksi = '". $kd ."'";
        $save2 = mysqli_query($koneksi, $query2);
    }

	include '../../koneksi.php';

    session_start();

    $id = $_POST['id'];
    $kd = $_POST['kd'];
    
    $SQL2 = mysqli_query($koneksi, "SELECT * FROM tb_penjualan_detail WHERE id_penjualan_detail = '". $id ."' LIMIT 1");
    $data = mysqli_fetch_array($SQL2);

    //CEK TOTAL DETAIL
    $querytd = "SELECT * FROM tb_penjualan_detail WHERE kode_penjualan = '". $kd ."'"; 
    $sqltd = mysqli_query($koneksi, $querytd);
    $rowcount = mysqli_num_rows($sqltd);


    if($rowcount > 1){
        $sql_produk = mysqli_query($koneksi, "SELECT stok FROM tb_jenis_sampah WHERE id_jenis_sampah = ". $data['id_jenis_sampah'] ." LIMIT 1");
        $dt = mysqli_fetch_array($sql_produk);

        $stok_baru = $dt['stok'] + $data['berat'];

        $queryup = mysqli_query($koneksi, "UPDATE tb_jenis_sampah SET stok=".$stok_baru." WHERE id_jenis_sampah ='".$data['id_jenis_sampah']."'");
        
        $query = "DELETE FROM tb_penjualan_detail WHERE id_penjualan_detail = ". $id."";

        if (mysqli_query($koneksi, $query)) {
            updateMaster($kd);
            
            echo json_encode(array("isError"=>false, "message"=>"OK"));
        } 
        else {
            echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan"));
        }
    }else{
        echo json_encode(array("isError"=>true, "message"=>"Detail Jenis Sampah Tidak Boleh Kosong"));
    }

	mysqli_close($koneksi);
?>