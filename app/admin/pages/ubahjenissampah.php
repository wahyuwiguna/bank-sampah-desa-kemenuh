<?php
    include "../../koneksi.php";
    $id=$_GET['id'];
    $modal=mysqli_query($koneksi,"SELECT * FROM tb_jenis_sampah WHERE id_jenis_sampah='$id' LIMIT 1");
    $data = mysqli_fetch_array($modal);
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Jenis Sampah</h5>
        </div>
        <div class="modal-body">
            <form id="formUbah">
                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Jenis Sampah</label>
                    <div class="col-sm-8">
                    <input type="hidden" id="idjenissampah2"  class="form-control" value="<?php echo $data['id_jenis_sampah']; ?>" />
                        <input type="text" class="form-control form-control-sm" id="jenissampah2" value="<?php echo $data['jenis_sampah']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Keterangan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="keterangan2" value="<?php echo $data['keterangan']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Harga Beli /Kg</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="hargabeli2" value="<?php echo number_format($data['harga_beli']); ?>" onClick="this.select();">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Harga Jual /Kg</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="hargajual2" value="<?php echo number_format($data['harga_jual']); ?>" onClick="this.select();">
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
    function  readURL2(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e){
          $('#scan2')
            .attr('src', e.target.result)
            .width(270)
            .height(270)
        };

        reader.readAsDataURL(input.files[0]);
      }
    }

    $(document).ready(function() {
        $('#editRowButton').on('click', function() {
        
        var idjenissampah = $('#idjenissampah2').val();
        var jenissampah = $('#jenissampah2').val();
        var keterangan = $('#keterangan2').val();
        var hargabeli = $('#hargabeli2').val();
        var hargajual = $('#hargajual2').val();
        var radios = document.getElementsByName('status2');
        var status = "";
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                status = radios[i].value;
                break;
            }
        }


        var form_data = new FormData();   
        form_data.append('idjenissampah', idjenissampah);
        form_data.append('jenissampah', jenissampah);               
        form_data.append('keterangan', keterangan);
        form_data.append('hargabeli', hargabeli);
        form_data.append('hargajual', hargajual);
        form_data.append('status', status);
        
        if(jenissampah !=""){
            $.ajax({
                url: "Proses/editjenissampah.php",
                type: "POST",
                contentType: false,
                processData: false,
				data: form_data,
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

<script>
  $(function () {
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('hargabeli2');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, '');
    });

    var dengan_rupiah2 = document.getElementById('hargajual2');
    dengan_rupiah2.addEventListener('keyup', function(e)
    {
        dengan_rupiah2.value = formatRupiah(this.value, '');
    });
  
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa  = split[0].length % 3,
        rupiah  = split[0].substr(0, sisa),
        ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
        
        if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    
  });
</script>