<?php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']);

// menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($koneksi,"select * from tb_nasabah where NIK = '$username' AND password='$password' AND status='Aktif'");

// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);

$isi = mysqli_fetch_array($data);


if($cek > 0){
    $_SESSION['nik'] = $username;
    $_SESSION['id_nasabah'] = $isi['id_nasabah'];
    $_SESSION['nama_nasabah'] = $isi['nama_nasabah'];
    $_SESSION['no_rekening'] = $isi['no_rekening'];
    $_SESSION['status_session'] = "login_nasabah";
    header("location:nasabah/index.php?ref=dashboard.php");
    
}else{

    echo "<script>alert('Login Gagal !! Periksa Kembali NIK atau Password Anda');window.location.href='nasabah.php'</script>";
}
?>
