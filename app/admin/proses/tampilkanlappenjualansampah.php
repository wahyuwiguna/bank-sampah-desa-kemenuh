<?php 
    $mulai = $_POST['TglMulai'];
    $akhir = $_POST['TglSelesai'];
    // $banjar = $_POST['banjar'];
    
    echo "<script>window.location.href='../index.php?ref=lappenjualansampah.php&mulai=$mulai&akhir=$akhir';</script>";

 ?>