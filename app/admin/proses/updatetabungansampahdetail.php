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

    $kd = $_POST['kd'];
    $id_nasabah = $_POST['id_nasabah'];
    $id = $_POST['id'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];
    
    $SQL2 = mysqli_query($koneksi, "SELECT * FROM tb_tabungan_sampah_detail WHERE id_tabungan_sampah_detail = '". $id ."' LIMIT 1");
    $row = mysqli_num_rows($SQL2);

    if($row > 0){
        //UPDATE
        while($data = mysqli_fetch_array($SQL2)){
            //KEMBALI KAN STOK
            $sql_produk = mysqli_query($koneksi, "SELECT stok FROM tb_jenis_sampah WHERE id_jenis_sampah = ". $data['id_jenis_sampah'] ." LIMIT 1");
            $dt = mysqli_fetch_array($sql_produk);
    
            $stok_baru = $dt['stok'] - $data['berat'];
    
            $queryup = mysqli_query($koneksi, "UPDATE tb_jenis_sampah SET stok=".$stok_baru." WHERE id_jenis_sampah ='".$data['id_jenis_sampah']."'");

            $jumlah_new = $jumlah;
            $subtotal_new = $subtotal;

            $query = "UPDATE tb_tabungan_sampah_detail SET berat = ". $jumlah_new .", harga = ". $harga .", subtotal = ". $subtotal_new ." WHERE id_tabungan_sampah_detail = ". $data['id_tabungan_sampah_detail'] ."";

            if (mysqli_query($koneksi, $query)) {
                
                //UPDATE STOK
                $sql_produk = mysqli_query($koneksi, "SELECT stok FROM tb_jenis_sampah WHERE id_jenis_sampah = ". $data['id_jenis_sampah'] ." LIMIT 1");
                $dt = mysqli_fetch_array($sql_produk);
        
                $stok_baru = $dt['stok'] + $jumlah;
        
                $queryup = mysqli_query($koneksi, "UPDATE tb_jenis_sampah SET stok=".$stok_baru." WHERE id_jenis_sampah ='".$data['id_jenis_sampah']."'");

                // UPDATE MASTER
                updateMaster($kd, $id_nasabah);

                echo json_encode(array("isError"=>false, "message"=>"OKE"));
            } 
            else {
                echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan"));
            }
        }

    }else{
        echo json_encode(array("isError"=>true, "message"=>"Detail Tabungan Sampah Tidak Ditemukan"));
    }

	mysqli_close($koneksi);
?>