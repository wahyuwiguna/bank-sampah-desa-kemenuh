<?php
$koneksi = mysqli_connect("localhost","root","","db_bank_sampah_desa_kemenuh");

// Check connection
if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>