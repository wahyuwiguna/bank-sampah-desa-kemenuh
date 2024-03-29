<?php
    $nasabah = $_SESSION['id_nasabah'];
    $tahun = date('Y');

    $modal=mysqli_query($koneksi,"SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar WHERE a.id_nasabah='$nasabah' LIMIT 1");
    $data = mysqli_fetch_array($modal);

?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Profile Nasabah</a></li>
        </ol>
    </nav>
</div>

<div class="row layout-top-spacing">
    
    <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

        <div class="user-profile layout-spacing">
            <div class="widget-content widget-content-area">
                <div class="text-center user-info">
                    <img src="../../assets/assets/img/user.png" alt="avatar" width="150px" height="150px">
                    <p class=""><?php echo $data['nama_nasabah']; ?></p>
                    <button type="button" class="btn btn-info btn-rounded btn-icon-text" id="btnAdd">
                        <i data-feather="edit-2"></i>
                        Ubah Profile
                    </button>
                    <button type="button" class="btn btn-warning btn-rounded btn-icon-text" id="btnAdd2">
                        <i data-feather="lock"></i>
                        Ganti Password
                    </button>

                    
                </div>
                <div class="user-info-list">

                    <div class="">
                        <ul class="contacts-block list-unstyled">
                            <li class="contacts-block__item">
                                <i data-feather="user"></i> <?php echo $data['NIK']; ?>
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="credit-card"></i> <?php echo $data['no_rekening']; ?>
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="map-pin"></i> <?php echo $data['alamat']; ?>
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="home"></i> <?php echo $data['nama_banjar']; ?>
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather="phone"></i> <?php echo $data['no_telp']; ?>
                            </li>
                            <li class="contacts-block__item">
                                <i data-feather='info'></i>
                                <?php 
                                    if ($data['status']=='Aktif') {
                                        echo "<span class='badge bg-success'> Aktif</span>";
                                    }elseif ($data['status']=='TidakAktif') {
                                        echo "<span class='badge bg-danger'> Non-Aktif</span>";
                                    }elseif ($data['status']=='Validasi') {
                                        echo "<span class='badge bg-warning'> Validasi</span>";
                                    }
                                ?>
                            </li>
                            
                        </ul>
                    </div>                                    
                </div>
            </div>
        </div>

    </div>

</div>


<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Profile</h5>
            </div>
            <div class="modal-body">
                <form id="formUbah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">No Rekening</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="idnasabah2"  class="form-control" value="<?php echo $nasabah; ?>" />
                            <input type="text" class="form-control form-control-sm" id="norek2" value="<?php echo $data['no_rekening']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">NIK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="nik2" value="<?php echo $data['NIK']; ?>">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="nama2" value="<?php echo $data['nama_nasabah']; ?>">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="alamat2" value="<?php echo $data['alamat']; ?>">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Banjar</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="banjar2">
                            <?php 
                                $query2 = "SELECT * FROM tb_banjar ORDER BY nama_banjar ASC";
                                $sql2 = mysqli_query($koneksi, $query2); 
                                
                                while($data_anggota = mysqli_fetch_array($sql2)){
                                ?>
                                    <option value="<?php echo $data_anggota['id_banjar']; ?>" <?php if ($data_anggota['id_banjar'] == $data['id_banjar'] ) { echo "selected"; } ?>> <?php  echo $data_anggota['nama_banjar']; ?> </option>;
                                <?php
                                }

                            ?>
                            </select>
                        </div>
                    </div>
                    

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">No Telp</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="nohp2" value="<?php echo $data['no_telp']; ?>">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="editRowButton" class="btn btn-success btn-rounded">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addRowModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
            </div>
            <div class="modal-body">
                <form id="formUbah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Password Lama</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="idnasabah0"  class="form-control" value="<?php echo $nasabah; ?>" />
                            <input type="password" class="form-control form-control-sm" id="passwordlama0" value="">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm" id="passwordbaru0" value="">
                        </div>
                    </div>
                    

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="editRowButton0" class="btn btn-success btn-rounded">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#btnAdd').on('click', function() {
            $('#addRowModal').modal('show');
        });

        $('#btnAdd2').on('click', function() {
            $('#addRowModal2').modal('show');
        });
        
        $('#editRowButton').on('click', function() {
            
            var id = $('#idnasabah2').val();
            var nik = $('#nik2').val();
            var nama = $('#nama2').val();
            var alamat = $('#alamat2').val();
            var jb = document.getElementById("banjar2");
            var banjar = jb.value;
            var notelp = $('#nohp2').val();


            //VALIDASI
            if(nik == ""){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan NIK",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                
                return false;
            }else if(nama == ""){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan Nama Nasabah",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                return false;
            }else if(alamat == ""){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan Alamat Nasabah",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                return false;
            }else if(banjar == ""){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan Banjar Nasabah",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                
                return false;
            }else if(notelp == ""){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan No Telp",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
                
                return false;
            }


            if(nik !="" && nama !=""){
                $.ajax({
                    url: "Proses/editnasabah.php",
                    type: "POST",
                    data: {
                        id: id,
                        nik: nik,
                        nama: nama,
                        alamat: alamat,
                        banjar: banjar,
                        notelp: notelp	
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(!dataResult.isError){
                            $('#addRowModal').modal('hide');
                            
                            swal({
                                title: 'Berhasil!',
                                text: "Data diubah",
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
                    text: "Masukan data dengan lengkap",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
            }
        });

        $('#editRowButton0').on('click', function() {
        
        var id = $('#idnasabah0').val();
        var passwordlama = $('#passwordlama0').val();
        var password = $('#passwordbaru0').val();

        
            if(password !="" && passwordlama !=""){
                $.ajax({
                    url: "Proses/updatepassword.php",
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
                            $('#addRowModal2').modal('hide');
                            
                            swal({
                                title: 'Berhasil!',
                                text: "Password berhasil diubah",
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
                            
                            return false;
                                
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
                    
                    return false;
            }
        });
        
    });

</script>