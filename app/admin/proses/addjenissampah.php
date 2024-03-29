<?php
    function GetAutoKode(){
        include '../../koneksi.php';
        // mencari kode barang dengan nilai paling besar
        $query = "SELECT max(kode_sampah) as maxKode FROM tb_jenis_sampah";
        $hasil = mysqli_query($koneksi,$query);
        $data = mysqli_fetch_array($hasil);
        $kodeBarang = $data['maxKode'];

        $noUrut = (int) substr($kodeBarang, 3, 4);
        
        $noUrut++;

        $char = "JS";
        $kodeBarang = $char ."-".sprintf("%04s", $noUrut);
        return $kodeBarang;
    }

    include '../../koneksi.php';
    
    $jenissampah = $_POST['jenissampah'];
    $keterangan = $_POST['keterangan'];
    $hargabeli = $_POST['hargabeli'];
    $hargajual = $_POST['hargajual'];

    $kode = GetAutoKode();

    $query = "INSERT INTO tb_jenis_sampah(kode_sampah, jenis_sampah, keterangan, harga_beli, harga_jual) VALUES('".$kode."','".$jenissampah."','".$keterangan."',".$hargabeli.",".$hargajual.")";

    if (mysqli_query($koneksi, $query)) {
        echo json_encode(array("isError"=>false, "message"=>"Jenis Sampah Berhasil Tersimpan" ));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Kesalahan Penyimpanan"));
    }

?>