<?php
	include '../../koneksi.php';

    session_start();
    // $nasabah = $_POST['nasabah'];

    $query = mysqli_query($koneksi, "SELECT a.* FROM tb_tabungan_sampah_detail_temp a INNER JOIN tb_jenis_sampah b ON a.id_jenis_sampah = b.id_jenis_sampah WHERE a.id_user = ".$_SESSION['id_user']." AND a.id_session = '". session_id() ."'");
    
    if(mysqli_num_rows($query) > 0){
        while ($row = mysqli_fetch_assoc($query)) {

            $updateButton = "<center><button class='btn btn-info updateUser' data-id='".$row['id_tabungan_sampah_detail_temp']."' data-toggle='modal' data-target='#updateModal'>Ubah</button>";
    
            $deleteButton = "<button class='btn btn-danger deleteUser' data-id='".$row['id_tabungan_sampah_detail_temp']."'>Hapus</button></center>";
    
            $action = $updateButton." ".$deleteButton;
    
            //$gambar = "<center><img src='../gambar/".$row['gambar']."' alt='' width='120' height='120'></center>";
    
            $data[] = array(
                //"gambar" => $gambar,
                "kode_sampah" => $row['kode_sampah'],
                "jenis_sampah" => $row['jenis_sampah'],
                "harga" => $row['harga'],
                "jumlah" => $row['jumlah'],
                "subtotal" => $row['subtotal'],
                "action" => $action
            );
        }
        
        // echo json_encode($data);
        echo json_encode(array("noData"=>false, "data"=>$data));
    }else{
       
        echo json_encode(array("noData"=>true, "data"=>""));
    }
    
    

    
	mysqli_close($koneksi);
?>
