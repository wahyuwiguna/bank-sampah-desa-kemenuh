<?php
// mengaktifkan session
session_start();

// menghapus semua session
unset($_SESSION['status_session']);
session_destroy();

// mengalihkan halaman sambil mengirim pesan logout
header("location:nasabah.php");
?>
