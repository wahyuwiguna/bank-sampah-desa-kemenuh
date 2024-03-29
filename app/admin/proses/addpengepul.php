<?php
    function GetAutoKode(){
        include '../../koneksi.php';
        // mencari kode barang dengan nilai paling besar
        $query = "SELECT max(kode_pengepul) as maxKode FROM tb_pengepul";
        $hasil = mysqli_query($koneksi,$query);
        $data = mysqli_fetch_array($hasil);
        $kodeBarang = $data['maxKode'];

        $noUrut = (int) substr($kodeBarang, 3, 4);
        
        $noUrut++;

        $char = "PN";
        $kodeBarang = $char ."-".sprintf("%04s", $noUrut);
        return $kodeBarang;
    }
	include '../../koneksi.php';

    $nama = $_POST['nama'];
    $no_telp = $_POST['notelp'];
    $kode = GetAutoKode();
    

    $query = "INSERT INTO tb_pengepul(kode_pengepul, nama_pengepul, no_telp) VALUES('".$kode."','".$nama."','".$no_telp."')";
    
	if (mysqli_query($koneksi, $query)) {
		echo json_encode(array("isError"=>false));
	} 
	else {
		echo json_encode(array("isError"=>true));
	}
	mysqli_close($koneksi);
?>