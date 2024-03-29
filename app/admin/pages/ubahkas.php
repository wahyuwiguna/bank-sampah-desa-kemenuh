<?php
    include "../../koneksi.php";
    $id=$_GET['id'];
    $modal=mysqli_query($koneksi,"SELECT * FROM tb_arus_kas WHERE id_arus_kas='$id' LIMIT 1");
    $data = mysqli_fetch_array($modal);
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Kas</h5>
        </div>
        <div class="modal-body">
            <form id="formUbah">
                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Tanggal</label>
                    <div class="col-sm-8">
                        <input type="hidden" id="idkas2"  class="form-control" value="<?php echo $data['id_arus_kas']; ?>" />
                        <input id="tanggal2" value="<?php echo date('Y-m-d', strtotime($data['tanggal'])); ?>" class="form-control form-control-sm flatpickr flatpickr-input active" type="text" placeholder="Select Date.." style="color:black;">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Keterangan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="keterangan2" value="<?php echo $data['keterangan']; ?>">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Debit</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="debit2" value="<?php echo number_format($data['debit']); ?>" onClick="this.select();">
                    </div>
                </div>

                <div class="form-group row  mb-4">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Kredit</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="kredit2" value="<?php echo number_format($data['kredit']); ?>" onClick="this.select();">
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
    Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
            (mm>9 ? '' : '0') + mm,
            (dd>9 ? '' : '0') + dd
            ].join('-');
    };

    var f3 = flatpickr(document.getElementById('tanggal2'), {
        enableTime: false,
        dateFormat: "Y-m-d",
        static : true,
    });

    $(document).ready(function() {
        $('#editRowButton').on('click', function() {
        
        var idkas = $('#idkas2').val();
        var to1 = new Date($('#tanggal2').val());
        var tg = to1.yyyymmdd();
        var keterangan = $('#keterangan2').val();
        var debit = $('#debit2').val();
        var kredit = $('#kredit2').val();
        

        var form_data = new FormData();   
        form_data.append('idkas', idkas);
        form_data.append('tanggal', tg);               
        form_data.append('keterangan', keterangan);
        form_data.append('debit', debit);
        form_data.append('kredit', kredit);
        
        if(debit == 0 && kredit == 0){
            swal({
                title: 'Peringatan!',
                text: "Debit atau Kredit Harus Diisi",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });

            return false;
        }else if(debit != 0 && kredit != 0){
            
            swal({
                title: 'Peringatan!',
                text: "Debit atau Kredit Harus Salah Satu 0",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });
            return false;
        }   

        if(keterangan == "" || keterangan == null){
            swal({
                title: 'Peringatan!',
                text: "Masukan keterangan kas",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });
        }
        
        if(keterangan !=""){
            $.ajax({
                url: "proses/editkas.php",
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
                            text: "Data kas diubah",
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
    var dengan_rupiah = document.getElementById('debit2');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, '');
        var kr = document.getElementById('kredit2');
        kr.value = 0;
    });

    var dengan_rupiah2 = document.getElementById('kredit2');
    dengan_rupiah2.addEventListener('keyup', function(e)
    {
        dengan_rupiah2.value = formatRupiah(this.value, '');
        var kr = document.getElementById('debit2');
        kr.value = 0;
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