<?php
    function GetAutoKode($tgl){
        include '../../koneksi.php';
        // mencari kode barang dengan nilai paling besar
        $query = "SELECT max(kode_transaksi) as maxKode FROM tb_arus_kas WHERE MONTH(tanggal) = '". date('m', strtotime($tgl)) ."' AND YEAR(tanggal) = '". date('Y', strtotime($tgl)) ."' AND status = 'Kas'";
        $hasil = mysqli_query($koneksi,$query);
        $data = mysqli_fetch_array($hasil);
        $kodeBarang = $data['maxKode'];

        $noUrut = (int) substr($kodeBarang, 11, 4);
        
        $noUrut++;

        // membentuk kode anggota baru
        // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
        // misal sprintf("%03s", 12); maka akan dihasilkan '012'
        // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
        $char = "KAS";
        $bln = date('Y', strtotime($tgl))."".date('m', strtotime($tgl));
        $kodeBarang = $char ."-".$bln."-".sprintf("%04s", $noUrut);
        return $kodeBarang;
    }

    include '../../koneksi.php';
    
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $debit = $_POST['debit'];
    $kredit = $_POST['kredit'];

    $kode = GetAutoKode($tanggal);

    $query = "INSERT INTO tb_arus_kas(tanggal, kode_transaksi, keterangan, status, debit, kredit) VALUES('".$tanggal."','".$kode."','".$keterangan."','Kas',".$debit.",".$kredit.")";

    if (mysqli_query($koneksi, $query)) {
        echo json_encode(array("isError"=>false, "message"=>"Kas Berhasil Tersimpan" ));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Kesalahan Penyimpanan"));
    }

?>