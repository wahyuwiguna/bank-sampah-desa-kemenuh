<?php
    include "../../koneksi.php";
    $id=$_GET['id'];
    $modal=mysqli_query($koneksi,"SELECT * FROM tb_pengepul WHERE id_pengepul='$id' LIMIT 1");
    $data = mysqli_fetch_array($modal);
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Pengepul</h5>
        </div>
        <div class="modal-body">
            <form id="formUbah">
                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Jenis Sampah</label>
                    <div class="col-sm-8">
                    <input type="hidden" id="idpengepul2"  class="form-control" value="<?php echo $data['id_pengepul']; ?>" />
                        <input type="text" class="form-control form-control-sm" id="nama2" value="<?php echo $data['nama_pengepul']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">No Telp</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="nohp2" value="<?php echo $data['no_telp']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Status</label>
                    <div class="col-sm-8">
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
        
            var id = $('#idpengepul2').val();
            var nama = $('#nama2').val();
            var notelp = $('#nohp2').val();

            var radios2 = document.getElementsByName('status2');
            var status = "";
            for (var x = 0, length = radios2.length; x < length; x++) {
                if (radios2[x].checked) {
                    status = radios2[x].value;
                    break;
                }
            }
            
            if(nama !="" && notelp !=""){
                $.ajax({
                    url: "Proses/editpengepul.php",
                    type: "POST",
                    data: {
                        id: id,
                        nama: nama,
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
                                text: "Data sudah diubah",
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

