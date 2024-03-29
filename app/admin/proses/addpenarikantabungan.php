<?php
    date_default_timezone_set("Asia/Makassar");

	include '../../koneksi.php';

    session_start();

    function GetAutoKode($tgl){
        include '../../koneksi.php';
        // mencari kode barang dengan nilai paling besar

        // $tgl = date('d M y');

        $query = "SELECT max(kode) as maxKode FROM tb_penarikan_tabungan WHERE MONTH(tanggal) = '". date('m', strtotime($tgl)) ."' AND YEAR(tanggal) = '". date('Y', strtotime($tgl)) ."'";
        $hasil = mysqli_query($koneksi,$query);
        $data = mysqli_fetch_array($hasil);
        $kodeBarang = $data['maxKode'];

        $noUrut = (int) substr($kodeBarang, 11, 4);
        
        $noUrut++;

        // membentuk kode anggota baru
        // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
        // misal sprintf("%03s", 12); maka akan dihasilkan '012'
        // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
        $char = "TRS";
        $bln = date('Y', strtotime($tgl))."".date('m', strtotime($tgl));
        $kodeBarang = $char ."-".$bln."-".sprintf("%04s", $noUrut);
        return $kodeBarang;
    }

    function AddTabungan($nasabah, $iduser, $kodetrx, $tanggal, $debit, $kredit){
        include '../../koneksi.php';

        //DATA NASABAH
        $modal = mysqli_query($koneksi,"SELECT * FROM tb_nasabah WHERE id_nasabah='$nasabah' LIMIT 1");
        $nb = mysqli_fetch_array($modal);

        $saldo = $nb['saldo'];
        $saldo = $saldo + $debit - $kredit;

        //INSERT TABUNGAN
        $query = "INSERT INTO tb_tabungan(id_nasabah, id_user, kode_transaksi, tanggal, debit, kredit) VALUES (". $nasabah .", ". $iduser .", '". $kodetrx ."', '". $tanggal ."', ". $debit.", ". $kredit .")";
        if(mysqli_query($koneksi, $query)){
            //UPDATE SALDO NASABAH
            $queryup = mysqli_query($koneksi, "UPDATE tb_nasabah SET saldo=".$saldo." WHERE id_nasabah ='".$nasabah."'");
        }
    
    }

    function AddArusKas($kodetrx, $tanggal, $debit, $kredit){
        include '../../koneksi.php';

        $ket = "Penarikan tabungan sampah - ".$kodetrx."";
        $sts = "Penarikan Kas";

        //INSERT ARUS KAS
        $query = "INSERT INTO tb_arus_kas(tanggal, kode_transaksi, keterangan, status, debit, kredit) VALUES ('". $tanggal ."', '". $kodetrx ."', '". $ket ."', '". $sts."', ". $debit.", ". $kredit .")";
        $ad = mysqli_query($koneksi, $query);
    
    }
    
    $tanggal = $_POST['tanggal'];
    $nasabah = $_POST['nasabah'];
    $jumlah = $_POST['jumlah'];

    $id_user = $_SESSION['id_user'];
  
    $kode = GetAutoKode($tanggal);

    $query = "INSERT INTO tb_penarikan_tabungan(id_user, id_nasabah, tanggal, kode, jumlah, status) VALUES(". $id_user .",". $nasabah .",'".$tanggal."','".$kode."',". $jumlah.", 'Selesai')";
    
    if (mysqli_query($koneksi, $query)) {

        //Add TABUNGAN
        AddTabungan($nasabah, $id_user, $kode, $tanggal, 0, $jumlah);

        //add arus kas
        AddArusKas($kode, $tanggal, 0 ,$jumlah);
        
        echo json_encode(array("isError"=>false, "message"=>"Penarikan Tabungan Berhasil Tersimpan", "kode"=> $kode));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan"));
    }
    
	mysqli_close($koneksi);
?>