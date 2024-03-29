<?php 
    $mulai = $_POST['TglMulai'];
    $akhir = $_POST['TglSelesai'];
    // $banjar = $_POST['banjar'];

    if($akhir == ""){
        $akhir = date('Y-m-d');
    }
    
    
    echo "<script>window.location.href='../index.php?ref=transaksitabungansampah.php&mulai=$mulai&akhir=$akhir';</script>";

 ?>