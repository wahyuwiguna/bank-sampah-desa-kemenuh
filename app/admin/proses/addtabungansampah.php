<?php
    date_default_timezone_set("Asia/Makassar");

	include '../../koneksi.php';

    session_start();

    function GetAutoKode($tgl){
        include '../../koneksi.php';
        // mencari kode barang dengan nilai paling besar

        // $tgl = date('d M y');

        $query = "SELECT max(kode) as maxKode FROM tb_tabungan_sampah WHERE MONTH(tanggal) = '". date('m', strtotime($tgl)) ."' AND YEAR(tanggal) = '". date('Y', strtotime($tgl)) ."'";
        $hasil = mysqli_query($koneksi,$query);
        $data = mysqli_fetch_array($hasil);
        $kodeBarang = $data['maxKode'];

        $noUrut = (int) substr($kodeBarang, 11, 4);
        
        $noUrut++;

        // membentuk kode anggota baru
        // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
        // misal sprintf("%03s", 12); maka akan dihasilkan '012'
        // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
        $char = "TBS";
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

        $ket = "Setoran tabungan sampah - ".$kodetrx."";
        $sts = "Penambahan Saldo";

        //INSERT ARUS KAS
        $query = "INSERT INTO tb_arus_kas(tanggal, kode_transaksi, keterangan, status, debit, kredit) VALUES ('". $tanggal ."', '". $kodetrx ."', '". $ket ."', '". $sts."', ". $debit.", ". $kredit .")";
        $ad = mysqli_query($koneksi, $query);
    
    }

    
    $tanggal = $_POST['tanggal'];
    $nasabah = $_POST['nasabah'];

    
    $id_session = session_id();
    $id_user = $_SESSION['id_user'];
  
    $kode = GetAutoKode($tanggal);

    
    $query = "SELECT * FROM tb_tabungan_sampah_detail_temp WHERE id_user = ". $_SESSION['id_user'] ." AND id_session = '". session_id() ."'"; 
    $sql = mysqli_query($koneksi, $query); 
    $berat = 0;
    $subtotal = 0;

    while($data = mysqli_fetch_array($sql)){
        $berat += $data['jumlah'];
        $subtotal += $data['subtotal'];
    }

    $query = "INSERT INTO tb_tabungan_sampah(kode, tanggal, id_nasabah, id_user, total_berat, total_harga) VALUES('".$kode."','".$tanggal."',". $nasabah.",".$_SESSION['id_user'].",". $berat.", ". $subtotal .")";
    
    if (mysqli_query($koneksi, $query)) {

        //INSERT DETAIL
        $query2 = "SELECT * FROM tb_tabungan_sampah_detail_temp WHERE id_user = ". $_SESSION['id_user'] ." AND id_session = '". session_id() ."' ORDER BY id_jenis_sampah DESC"; 
        $sql2 = mysqli_query($koneksi, $query2); 
        while($data2 = mysqli_fetch_array($sql2)){
            $q_d = "INSERT INTO tb_tabungan_sampah_detail(kode_tabungan_sampah, id_jenis_sampah, jenis_sampah, berat, harga, subtotal) VALUES('". $kode ."', ". $data2['id_jenis_sampah'] .", '". $data2['jenis_sampah'] ."' ,". $data2['jumlah'] .", ". $data2['harga'] .", ". $data2['subtotal'] .")";

            if(mysqli_query($koneksi, $q_d)){
                //UPDATE STOK
                $sql_produk = mysqli_query($koneksi, "SELECT stok FROM tb_jenis_sampah where id_jenis_sampah = ". $data2['id_jenis_sampah'] ." LIMIT 1");
                $dt = mysqli_fetch_array($sql_produk);
        
                $stok_baru = $dt['stok'] + $data2['jumlah'];
        
                $queryup = mysqli_query($koneksi, "UPDATE tb_jenis_sampah SET stok=".$stok_baru." WHERE id_jenis_sampah ='".$data2['id_jenis_sampah']."'");
            }

        }

        $del_temp = mysqli_query($koneksi, "DELETE FROM tb_tabungan_sampah_detail_temp WHERE id_session = '". session_id() ."' AND id_user = ". $id_user ."");


        //Add TABUNGAN
        AddTabungan($nasabah, $id_user, $kode, $tanggal, $subtotal, 0);

        //add arus kas
        // AddArusKas($kode, $tanggal, 0 ,$subtotal);
        
        echo json_encode(array("isError"=>false, "message"=>"Tabungan Sampah Berhasil Tersimpan", "kode"=> $kode));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Terjadi Kesalahan Penyimpanan"));
    }
    
	mysqli_close($koneksi);
?>