<?php
    include "../../koneksi.php";
    $id=$_GET['id'];
    $modal=mysqli_query($koneksi,"SELECT * FROM tb_nasabah WHERE id_nasabah='$id' LIMIT 1");
    $data = mysqli_fetch_array($modal);
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Nasabah [<?php echo $data['no_rekening']; ?>]</h5>
        </div>
        <div class="modal-body">
            <form id="formUbah">
                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">No Rekening</label>
                    <div class="col-sm-9">
                        <input type="hidden" id="idnasabah2"  class="form-control" value="<?php echo $data['id_nasabah']; ?>" />
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

                

                <div class="form-group row  mb-4">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Status</label>
                    <div class="col-sm-9">
                        <div class="custom-control custom-radio custom-control-inline" style="padding-top:20px;">
                            <input type="radio" id="customRadioInline5" name="status2" class="custom-control-input" value="Aktif" <?php if($data['status'] == "Aktif"){ echo "checked"; } ?>>
                            <label class="custom-control-label" for="customRadioInline5">Aktif</label>
                            </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline6" name="status2" class="custom-control-input" value="TidakAktif" <?php if($data['status'] == "TidakAktif"){ echo "checked"; } ?>>
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
        
            var id = $('#idnasabah2').val();
            var nik = $('#nik2').val();
            var nama = $('#nama2').val();
            var alamat = $('#alamat2').val();
            var jb = document.getElementById("banjar2");
            var banjar = jb.value;
            var notelp = $('#nohp2').val();

            var radios2 = document.getElementsByName('status2');
            var status = "";
            for (var x = 0, length = radios2.length; x < length; x++) {
                if (radios2[x].checked) {
                    status = radios2[x].value;
                    break;
                }
            }

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
                        notelp: notelp,
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

    });
</script>