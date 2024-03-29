<?php
    include "../../koneksi.php";
    $id_user=$_GET['id_user'];
    $modal=mysqli_query($koneksi,"SELECT * FROM tb_user WHERE id_user='$id_user' LIMIT 1");
    $data = mysqli_fetch_array($modal);
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data User</h5>
        </div>
        <div class="modal-body">
            <form id="formUbah">
                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Nama</label>
                    <div class="col-sm-9">
                    <input type="hidden" id="iduser2"  class="form-control" value="<?php echo $data['id_user']; ?>" />
                        <input type="text" class="form-control form-control-sm" id="nama2" value="<?php echo $data['nama_user']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Jenis Kelamin</label>
                    <div class="col-sm-9">
                        <div class="custom-control custom-radio custom-control-inline" style="padding-top:20px;">
                            <input type="radio" id="customRadioInline3" name="jeniskelamin2" class="custom-control-input" value="Pria" <?php if($data['jenis_kelamin'] == "Pria"){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadioInline3">Pria</label>
                            </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline4" name="jeniskelamin2" class="custom-control-input" value="Wanita" <?php if($data['jenis_kelamin'] == "Wanita"){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadioInline4">Wanita</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">No Telp</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="nohp2" value="<?php echo $data['no_telp']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="username2" value="<?php echo $data['username']; ?>" readonly>
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Role</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="role2">
                            <option value="admin" <?php if($data['role'] == "admin"){ echo "selected"; } ?>>Admin</option>
                            <option value="ketua" <?php if($data['role'] == "ketua"){ echo "selected"; } ?>>Ketua</option>
                            <option value="pegawai" <?php if($data['role'] == "pegawai"){ echo "selected"; } ?>>Pegawai Bank Sampah</option>
                            <option value="LPD" <?php if($data['role'] == "LPD"){ echo "selected"; } ?>>Pegawai LPD</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Status</label>
                    <div class="col-sm-9">
                        <div class="custom-control custom-radio custom-control-inline" style="padding-top:20px;">
                            <input type="radio" id="customRadioInline5" name="status2" class="custom-control-input" value="1" <?php if($data['status'] == "1"){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadioInline5">Aktif</label>
                            </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline6" name="status2" class="custom-control-input" value="0" <?php if($data['status'] == "0"){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadioInline6">Tidak Aktif</label>
                        </div>
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

<script>
    $(document).ready(function() {
        $('#editRowButton').on('click', function() {
        
        var iduser = $('#iduser2').val();
        var namauser = $('#nama2').val();
        var radios = document.getElementsByName('jeniskelamin2');
        var jeniskelamin = "";
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                jeniskelamin = radios[i].value;
                break;
            }
        }

        var notelp = $('#nohp2').val();
        var jb = document.getElementById("role2");
        var jabatan = jb.value;

        var radios2 = document.getElementsByName('status2');
        var status = "";
        for (var x = 0, length = radios2.length; x < length; x++) {
            if (radios2[x].checked) {
                status = radios2[x].value;
                break;
            }
        }

        if(namauser !=""){
            $.ajax({
                url: "Proses/edituser.php",
                type: "POST",
                data: {
                    iduser: iduser,
                    namauser: namauser,
                    jeniskelamin: jeniskelamin,
                    notelp: notelp,
                    jabatan: jabatan,
                    status : status				
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(!dataResult.isError){
                        $('#ModalEdit').modal('hide');
                        
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
                            text: "Data tidak tersimpan",
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

    });
</script>