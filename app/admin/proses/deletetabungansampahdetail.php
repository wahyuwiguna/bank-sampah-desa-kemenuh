<?php
    function updateMaster($kd, $nasabah){
        include '../../koneksi.php';

        $query = "SELECT * FROM tb_tabungan_sampah_detail WHERE kode_tabungan_sampah = '". $kd ."'"; 
        $sql = mysqli_query($koneksi, $query); 
        $jumlah = 0;
        $subtotal = 0;

        while($data = mysqli_fetch_array($sql)){
            $jumlah += $data['berat'];
            $subtotal += $data['subtotal'];
        }

        //TB TABUNGAN SAMPAH
        $query = "UPDATE tb_tabungan_sampah SET total_berat = ". $jumlah .", total_harga = ". $subtotal ." WHERE kode = '". $kd ."'";
        $save = mysqli_query($koneksi, $query);


        //UPDATE TABUNGAN
        $query2 = "UPDATE tb_tabungan SET debit = ". $subtotal ." WHERE kode_transaksi = '". $kd ."'";
        $save2 = mysqli_query($koneksi, $query2);

        //UPDATE SALDO NASABAH
        $querys = "SELECT * FROM tb_tabungan WHERE id_nasabah = ". $nasabah ." ORDER BY tanggal ASC"; 
        $sqls = mysqli_query($koneksi, $querys); 
        $saldoakhir = 0;
        
        while($datas = mysqli_fetch_array($sqls)){
            $saldoakhir = $saldoakhir + $datas['debit'] - $datas['kredit'];
        }

        $query3 = "UPDATE tb_nasabah SET saldo = ". $saldoakhir ." WHERE id_nasabah= ". $nasabah ."";
        $save3 = mysqli_query($koneksi, $query3);

    }

	include '../../koneksi.php';

    session_start();

    $id = $_POST['id'];
    $nasabah = $_POST['nasabah'];
    $kd = $_POST['kd'];
    
    $SQL2 = mysqli_query($koneksi, "SELECT * FROM tb_tabungan_sampah_detail WHERE id_tabungan_sampah_detail = '". $id ."' LIMIT 1");
    $data = mysqli_fetch_array($SQL2);

    //CEK TOTAL DETAIL
    $querytd = "SELECT * FROM tb_tabungan_sampah_detail WHERE kode_tabungan_sampah = '". $kd ."'"; 
    $sqltd = mysqli_query($koneksi, $querytd);
    $rowcount = mysqli_num_rows($sqltd);


    if($rowcount > 1){
        $sql_produk = mysqli_query($koneksi, "SELECT stok FROM tb_jenis_sampah WHERE id_jenis_sampah = ". $data['id_jenis_sampah'] ." LIMIT 1");
        $dt = mysqli_fetch_array($sql_produk);

        $stok_baru = $dt['stok'] - $data['berat'];

        $queryup = mysqli_query($koneksi, "UPDATE tb_jenis_sampah SET stok=".$stok_baru." WHERE id_jenis_sampah ='".$data['id_jenis_sampah']."'");
        
        $query = "DELETE FROM tb_tabungan_sampah_detail WHERE id_tabungan_sampah_detail = ". $id."";

        if (mysqli_query($koneksi, $query)) {
            updateMaster($kd, $nasabah);
            
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