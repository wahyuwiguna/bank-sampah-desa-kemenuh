<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Bank Sampah Desa Kemenuh - Login Admin</title>
   
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../assets/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="../assets/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../assets/assets/css/forms/switches.css">
    <script src="../assets/plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="../assets/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
</head>
<body class="form">
    
    <script src="../assets/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../assets/plugins/sweetalerts/sweetalert2.min.js"></script>
    <!-- <script src="../assets/plugins/sweetalerts/custom-sweetalert.js"></script> -->

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class=""><b>BANK SAMPAH <br> DESA ADAT KEMENUH</b></h1>
                        <p class="">Silakan login terlebih dahulu.</p>
                        
                        <form class="text-left">
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">USERNAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username" required>
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="button" id="addRowButton" class="btn btn-primary" value="">Login</button>
                                    </div>
                                </div>
                                
                                <p class="signup-link">Nasabah ? <a href="nasabah.php">Login disini</a></p>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
 
        $('#addRowButton').on('click', function() {
            var username = $('#username').val();
            var password = $('#password').val();
            

            if(username == "" || username == null){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan Username",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                return false;
            }

            if(password == "" || password == null){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan Password",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                return false;
            }

            if(username !="" && password !=""){
                $.ajax({
                    url: "login_user.php",
                    type: "POST",
                    data: {
                        username: username,
                        password: password
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(!dataResult.isError){
                            

                            swal({
                                title: 'Berhasil!',
                                text: "Login Berhasil",
                                type: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                                padding: '2em'
                            });

                            if(dataResult.role == "admin"){
                                setTimeout(function () {
                                    window.location.href = "admin/index.php?ref=dashboard.php";
                                }, 3000);
                            }else if(dataResult.role == "lpd"){
                                setTimeout(function () {
                                    window.location.href = "admin/index.php?ref=dashboardLPD.php";
                                }, 3000);
                            }
 
                            
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
                    text: "Masukan Username dan Password",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
            }
        });

        
    });
</script>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../assets/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../assets/bootstrap/js/popper.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="../assets/assets/js/authentication/form-2.js"></script>
    


</body>
</html>