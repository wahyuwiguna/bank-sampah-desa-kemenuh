<?php
	include '../../koneksi.php';

    $id = $_POST['idkas'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $debit = preg_replace('/\D/','',$_POST['debit']);
    $kredit = preg_replace('/\D/','',$_POST['kredit']);
    

	$query = "UPDATE tb_arus_kas SET tanggal ='".$tanggal."', keterangan ='".$keterangan."', debit =".$debit.", kredit =".$kredit." WHERE id_arus_kas ='".$id."'";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(array("isError"=>false, "message"=>"Kas Berhasil Diubah"));
    } 
    else {
        echo json_encode(array("isError"=>true, "message"=>"Kesalahan Penyimpanan"));
    }
    
    
	mysqli_close($koneksi);
?>
