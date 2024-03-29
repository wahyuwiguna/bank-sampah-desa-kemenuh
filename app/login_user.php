<?php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']);

// menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($koneksi,"select * from tb_user where username='$username' AND password='$password' AND status=1");

// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);

$isi = mysqli_fetch_array($data);


if($cek > 0){
    if ($isi['role']=='admin' || $isi['role']=='ketua' || $isi['role']=='pegawai') {
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $isi['id_user'];
        $_SESSION['nama_user'] = $isi['nama_user'];
        $_SESSION['jenis_kelamin'] = $isi['jenis_kelamin'];
        $_SESSION['no_telp'] = $isi['no_telp'];
        $_SESSION['role'] = $isi['role'];
        $_SESSION['status_session'] = "login_admin";

        mysqli_close($koneksi);
        echo json_encode(array("isError"=>false, "role" => "admin"));

    //  header("location:admin/index.php?ref=dashboard.php");
    
    }elseif($isi['role']=='LPD'){
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $isi['id_user'];
        $_SESSION['nama_user'] = $isi['nama_user'];
        $_SESSION['jenis_kelamin'] = $isi['jenis_kelamin'];
        $_SESSION['no_telp'] = $isi['no_telp'];
        $_SESSION['role'] = $isi['role'];
        $_SESSION['status_session'] = "login_admin";
        // header("location:admin/index.php?ref=dashboardLPD.php");

        mysqli_close($koneksi);
        echo json_encode(array("isError"=>false, "role" => "lpd"));
    }
    
}else{
    mysqli_close($koneksi);

    echo json_encode(array("isError"=>true, "message" => "Login Gagal !! Periksa Kembali Username atau Password Anda"));
}
?>
