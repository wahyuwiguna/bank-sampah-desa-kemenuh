<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Bank Sampah Desa Kemenuh - Admin Panel</title>
    
    <link href="../../assets/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="../../assets/assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" type="text/css" href="../../assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="../../assets/plugins/table/datatable/dt-global_style.css">
    <script src="../../assets/plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="../../assets/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../assets/plugins/bootstrap-select/bootstrap-select.min.css">
    <link href="../../assets/plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
    <link href="../../assets/plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
    <link href="../../assets/assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../assets/assets/css/widgets/modules-widgets.css"> 
    <link rel="stylesheet" href="../../assets/plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="../../assets/plugins/font-icons/fontawesome/css/fontawesome.css">
    <link href="../../assets/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <style>
        .apexcharts-canvas {
            margin: 0 auto;
        }
    </style>

</head>

<?php
    $today = date('Y-m-d');
    $firstofmonth = date('Y-m-01');
    $urlactive = $_GET['ref'];

    session_start();
    if($_SESSION['status_session']!="login_admin"){
      echo "<script>alert('Silakan Login Terlebih dahulu');window.location.href='../index.php'</script>";
    }

    include "../koneksi.php";

    $q_data_master = mysqli_query($koneksi, "SELECT * FROM tb_pengaturan LIMIT 1");
    $data_index = mysqli_fetch_array($q_data_master);
?>

<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <div class="nav-logo align-self-center">
                <a class="navbar-brand" href="#"><span class="navbar-brand-name" style="text-transform: uppercase;"><?php echo $data_index['nama_perusahaan']; ?></span></a>
            </div>

            <ul class="navbar-item flex-row mr-auto">
                <!-- <li class="nav-item align-self-center search-animated">
                    <form class="form-inline search-full form-inline search" role="search">
                        <div class="search-bar">
                            <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                        </div>
                    </form>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </li> -->
            </ul>

            <ul class="navbar-item flex-row nav-dropdowns">
                <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-body align-self-center">
                                <h6><?php echo $_SESSION['nama_user']; ?></h6>
                                <p style="text-transform: uppercase;"><?php echo $_SESSION['role']; ?></p>
                            </div>
                            <img src="../../assets/assets/img/user2.jpg" class="img-fluid" alt="admin-profile">
                            <span class="badge badge-success"></span>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="dropdown-item">
                            <a data-target="#ModalUbahPassword" data-toggle="modal" id="MainNavHelp" href="#ModalUbahPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Ganti Password</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="../logout.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
        <div class="topbar-nav header navbar" role="banner">
            <nav id="topbar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    
                    <li class="nav-item theme-text">
                        <a href="#" class="nav-link"> BANK SAMPAH </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="topAccordion">
                    <!-- DASHBOARD -->
                    <?php 
                        if($_SESSION['role'] == "pegawai" || $_SESSION['role'] == "ketua" || $_SESSION['role'] == "admin"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "dashboard.php"){ echo "active";} ?>">
                            <a href="index.php?ref=dashboard.php">
                                <div class="">
                                    <i data-feather="home"></i>
                                    <span>Dashboard</span>
                                </div>
                            </a>
                        
                        </li>

                    <?php
                        }elseif($_SESSION['role'] == "LPD"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "dashboardLPD.php"){ echo "active";} ?>">
                            <a href="index.php?ref=dashboardLPD.php">
                                <div class="">
                                    <i data-feather="home"></i>
                                    <span>Dashboard LPD</span>
                                </div>
                            </a>
                        
                        </li>
                    <?php
                        }
                    ?>

                    <!-- DASHBOARD -->

                    <!-- DATA MASTER -->
                    <?php 
                        if($_SESSION['role'] == "pegawai" || $_SESSION['role'] == "admin"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "datauser.php" || $urlactive == "datajenissampah.php" || $urlactive == "datanasabah.php" || $urlactive == "datapengepul.php"){ echo "active";} ?>">
                            <a href="#menudatamaster" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle autodroprown">
                                <div class="">
                                    <i data-feather="hard-drive"></i>
                                    <span>Data Master</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="menudatamaster" data-parent="#topAccordion">
                                <?php
                                    if($_SESSION['role'] == "admin"){
                                ?>
                                    <li class="<?php if($urlactive == "datauser.php"){ echo "active";} ?>">
                                        <a href="index.php?ref=datauser.php">Data User </a>
                                    </li>
                                <?php
                                    }
                                ?>
                                <li class="<?php if($urlactive == "datajenissampah.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=datajenissampah.php">Data Jenis Sampah </a>
                                </li>
                                <li class="<?php if($urlactive == "datanasabah.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=datanasabah.php">Data Nasabah</a>
                                </li>
                                <li class="<?php if($urlactive == "datapengepul.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=datapengepul.php">Data Pengepul</a>
                                </li>
                            </ul>
                        </li>
                        
                    <?php
                        }
                    
                    ?>

                    <!-- DATA MASTER -->
                    
                    
                    <!-- TABUNGAN SAMPAH -->
                    <?php 
                        if($_SESSION['role'] == "pegawai" || $_SESSION['role'] == "admin"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "transaksitabungansampah.php" || $urlactive == "tambahtabungansampah.php" || $urlactive == "ubahtabungansampah.php"){ echo "active";} ?>">
                            <a href="index.php?ref=transaksitabungansampah.php&mulai=<?php echo $today; ?>&akhir=<?php echo $today; ?>">
                                <div class="">
                                    <i data-feather="trash-2"></i>
                                    <span>Tabungan Sampah</span>
                                </div>
                            </a>
                        </li>
                        
                    <?php
                        }
                    
                    ?>
                    <!-- TABUNGAN SAMPAH -->
                    

                    <!-- TABUNGAN NASABAH -->
                    <?php 
                        if($_SESSION['role'] == "LPD" || $_SESSION['role'] == "admin"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "tabungannasabah.php" || $urlactive == "detailtabungannasabah.php"){ echo "active";} ?>">
                            <a href="index.php?ref=tabungannasabah.php&banjar=all">
                                <div class="">
                                    <i data-feather="book"></i>
                                    <span>Tabungan Nasabah</span>
                                </div>
                            </a>
                        </li>
                        
                    <?php
                        }
                    
                    ?>
                    <!-- TABUNGAN NASABAH -->

                    
                    <!-- PENJUALAN SAMPAH -->
                    <?php 
                        if($_SESSION['role'] == "pegawai" || $_SESSION['role'] == "admin"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "datapenjualansampah.php" || $urlactive == "tambahpenjualansampah.php" || $urlactive == "ubahpenjualansampah"){ echo "active";} ?>">
                            <a href="index.php?ref=datapenjualansampah.php">
                                <div class="">
                                    <i data-feather="shopping-cart"></i>
                                    <span>Penjualan Sampah</span>
                                </div>
                            </a>
                        </li>
                        
                    <?php
                        }
                    ?>
                    <!-- PENJUALAN SAMPAH -->

                    <!-- KAS -->
                    <?php 
                        if($_SESSION['role'] == "pegawai" || $_SESSION['role'] == "admin"){
                    ?>
                         <li class="menu single-menu <?php if($urlactive == "datakas.php"){ echo "active";} ?>">
                            <a href="index.php?ref=datakas.php">
                                <div class="">
                                    <i data-feather="credit-card"></i>
                                    <span>Kas</span>
                                </div>
                            </a>
                        </li>
                        
                    <?php
                        }
                    ?>
                    <!-- KAS -->


                    <!-- LAPORAN -->
                    <?php 
                        if($_SESSION['role'] == "ketua" || $_SESSION['role'] == "admin"){
                    ?>
                        <li class="menu single-menu <?php if($urlactive == "lapdatasampah.php" || $urlactive == "lapkas.php" || $urlactive == "laptabungansampah.php" || $urlactive == "lapnasabah.php" || $urlactive == "lappenjualansampah.php" || $urlactive == "laplabarugi.php"){ echo "active";} ?>">
                            <a href="#menulaporan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle autodroprown">
                                <div class="">
                                    <i data-feather="file"></i>
                                    <span>Laporan</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="menulaporan" data-parent="#topAccordion">
                                <li class="<?php if($urlactive == "lapdatasampah.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=lapdatasampah.php&mulai=<?php echo $firstofmonth; ?>&akhir=<?php echo $today; ?>">Lap. Data Sampah</a>
                                </li>
                                <li class="<?php if($urlactive == "lapkas.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=lapkas.php&mulai=<?php echo $firstofmonth; ?>&akhir=<?php echo $today; ?>">Lap. Kas </a>
                                </li>
                                <li class="<?php if($urlactive == "laptabungansampah.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=laptabungansampah.php&mulai=<?php echo $firstofmonth; ?>&akhir=<?php echo $today; ?>">Lap. Tabungan Sampah</a>
                                </li>
                                <li class="<?php if($urlactive == "lapnasabah.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=lapnasabah.php&banjar=all">Lap. Nasabah</a>
                                </li>
                                <li class="<?php if($urlactive == "lappenjualansampah.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=lappenjualansampah.php&mulai=<?php echo $firstofmonth; ?>&akhir=<?php echo $today; ?>">Lap. Penjualan Sampah</a>
                                </li>
                                <li class="<?php if($urlactive == "laplabarugi.php"){ echo "active";} ?>">
                                    <a href="index.php?ref=laplabarugi.php&bulan=<?php echo date('m'); ?>&tahun=<?php echo date('Y'); ?>">Lap. Laba Rugi</a>
                                </li>
                            </ul>
                        </li>
                        
                    <?php
                        }
                    ?>
                    <!-- LAPORAN -->

                   

                    

                    
                </ul>
            </nav>
        </div>
        <!--  END TOPBAR  -->

        <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
        <script src="../../assets/assets/js/libs/jquery-3.1.1.min.js"></script>
        <script src="../../assets/bootstrap/js/popper.min.js"></script>
        <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="../../assets/assets/js/custom.js"></script>
        <!-- END GLOBAL MANDATORY SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
        <script src="../../assets/plugins/table/datatable/datatables.js"></script>
        <script src="../../assets/plugins/sweetalerts/sweetalert2.min.js"></script>
        <script src="../../assets/plugins/sweetalerts/custom-sweetalert.js"></script>
        <script src="../../assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="../../assets/plugins/flatpickr/flatpickr.js"></script>
        <script src="../../assets/plugins/apex/apexcharts.min.js"></script>
        <script src="../../assets/plugins/apex/custom-apexcharts.js"></script>
        <script src="../../assets/assets/js/widgets/modules-widgets.js"></script>
        <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

        
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">                
                <?php include("content.php"); ?>

                <div class="footer-wrapper">
                    <div class="footer-section f-section-1">
                        <p class="">Copyright © INSTIKI <?php echo date('Y') ?>.</p>
                    </div>
                    <div class="footer-section f-section-2">
                    <p class=""><i data-feather="map-pin"></i> <?php echo $data_index['alamat'] ?></p>
                    </div>
                </div>

            </div>
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

<!-- MODAL UBAH PASS -->
<div class="modal fade" id="ModalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
            </div>
            <div class="modal-body">
                <form >
                    <input type="hidden" id="iduser0" value="<?php echo $_SESSION['id_user']; ?>">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Password Lama</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control form-control-sm" id="passwordlama0">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Password Baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control form-control-sm" id="passwordbaru0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="editRowButton0" class="btn btn-success btn-rounded">Ubah Password</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL UBAH PASS -->

    <script>
        feather.replace();
        $(document).ready(function() {
            // App.init();

            $('#btnUbahPwd').on('click', function() {
                $('#ModalUbahPassword').modal('show');
            });

            $('#editRowButton0').on('click', function() {
       
                var id = $('#iduser0').val();
                var passwordlama = $('#passwordlama0').val();
                var password = $('#passwordbaru0').val();

                
                if(password !="" && passwordlama !=""){
                    $.ajax({
                        url: "updatepassword.php",
                        type: "POST",
                        data: {
                            id: id,
                            passwordlama: passwordlama,
                            password: password,			
                                        
                        },
                        cache: false,
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(!dataResult.isError){
                                $('#ModalUbahPassword').modal('hide');
                                
                                swal({
                                    title: 'Berhasil!',
                                    text: dataResult.message,
                                    type: 'success',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    padding: '2em'
                                });

                                setTimeout(function(){ 
                                    location.reload();
                                }, 3000);
                                
                                
                            }
                            else if(dataResult.isError){
                                swal({
                                    title: 'Peringatan!',
                                    text: dataResult.message,
                                    type: 'warning',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    padding: '2em'
                                });
                            }
                            
                        }
                    });
                }
                else{
                   
                    swal({
                        title: 'Peringatan!',
                        text: "Masukan Password Baru dan Password Lama",
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 3000,
                        padding: '2em'
                    });
                }
            });

        });
    </script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10 
        });
    </script>

    
</body>
</html>