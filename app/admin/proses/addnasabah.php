<?php
    function GetAutoKode(){
        include '../../koneksi.php';
        // mencari kode barang dengan nilai paling besar
        $query = "SELECT max(no_rekening) as maxKode FROM tb_nasabah";
        $hasil = mysqli_query($koneksi,$query);
        $data = mysqli_fetch_array($hasil);
        $kodeBarang = $data['maxKode'];

        $noUrut = (int) substr($kodeBarang, 4, 5);
        
        $noUrut++;

        // membentuk kode anggota baru
        // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
        // misal sprintf("%03s", 12); maka akan dihasilkan '012'
        // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
       
        $tahun = date('Y');
        $kodeBarang = "REK-".sprintf("%05s", $noUrut);
        return $kodeBarang;
    }


	include '../../koneksi.php';

    $tgl_register = date('Y-m-d');
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $banjar = $_POST['banjar'];
    $notelp = $_POST['notelp'];
    $password1 = $_POST['password'];
    $password = md5($password1);

    $norek = GetAutoKode();

    //CEK NIK
    $modal = mysqli_query($koneksi,"SELECT * FROM tb_nasabah WHERE NIK = '". $nik ."' LIMIT 1");
    $d_nik = mysqli_num_rows($modal);

    if($d_nik > 0){
        echo json_encode(array("isError"=>true, "message"=>"NIK sudah terdaftar."));
    }else{
        $query = "INSERT INTO tb_nasabah(tanggal_register, no_rekening, NIK, nama_nasabah, alamat, id_banjar,no_telp, status, password) VALUES('".$tgl_register."','".$norek."','".$nik."','".$nama."','".$alamat."',".$banjar.",'".$notelp."','Aktif','".$password."')";
    
        if (mysqli_query($koneksi, $query)) {
            echo json_encode(array("isError"=>false));
        } 
        else {
            echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan."));
        }
    }

    

    
	mysqli_close($koneksi);
?>