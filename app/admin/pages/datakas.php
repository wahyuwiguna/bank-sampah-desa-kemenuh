<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Data Kas</a></li>
        </ol>
    </nav>
    <div class="float-right">
        <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="btnAdd">
            <i data-feather="plus"></i>
            Baru
        </button>
    </div>
</div>

<div class="row layout-top-spacing" id="cancel-row">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table style-3 table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align:center;" width="30px;">No</th>
                        <th style="text-align:center;">Tanggal</th>
                        <th style="text-align:center;">Kode</th>
                        <th style="text-align:center;">Keterangan</th>
                        <th style="text-align:center;">Debit</th>
                        <th style="text-align:center;">Kredit</th>
                        
                        <th class="text-center dt-no-sorting">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM tb_arus_kas WHERE status='kas' ORDER BY tanggal DESC, debit DESC"; 
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        $saldo = 0;
                        while($data = mysqli_fetch_array($sql)){
                            
                            echo "<tr>";
                            echo "<td style='text-align:center;'>".$no++."</td>";
                            echo "<td style='text-align:center;'>".date('d M Y', strtotime($data['tanggal']))."</td>";
                            echo "<td style='text-align:center;'>".$data['kode_transaksi']."</td>";
                            echo "<td>".$data['keterangan']."</td>";
                            echo "<td style='text-align:right;'>".number_format($data['debit'])."</td>";
                            echo "<td style='text-align:right;'>".number_format($data['kredit'])."</td>";
                            
                           if($data['status'] == "Kas"){                            
                        ?>
                        <td class="text-center">
                            <a href="#" id="<?php echo $data['id_arus_kas']; ?>" class="open_modal bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah"><i data-feather="edit-3"></i></a>
                        </td>
                        <?php 
                            }else{
                                echo "<td></td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL ADD -->
<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Kas Baru</h5>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Tanggal</label>
                        <div class="col-sm-8">
                            <input id="tanggal" class="form-control form-control-sm flatpickr flatpickr-input active" type="text" placeholder="Select Date.." style="color:black;">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Keterangan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="keterangan">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Debit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="debit" value="0" onClick="this.select();">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Kredit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="kredit" value="0" onClick="this.select();">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="addRowButton" class="btn btn-success btn-rounded">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL ADD -->

<!-- MODAL EDIT -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-hidden="true"></div>
<!-- MODAL EDIT -->

<script>
    Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
            (mm>9 ? '' : '0') + mm,
            (dd>9 ? '' : '0') + dd
            ].join('-');
    };


    $(document).ready(function() {

        $('#btnAdd').on('click', function() {
            $('#addRowModal').modal('show');
            document.getElementById("formTambah").reset();

            var f2 = flatpickr(document.getElementById('tanggal'), {
                enableTime: false,
                dateFormat: "Y-m-d",
                defaultDate: "today",
                static : true,
            });

        });
        
        $('#addRowButton').on('click', function() {
            var to1 = new Date($('#tanggal').val());
            var tg = to1.yyyymmdd();


            var keterangan = $('#keterangan').val();
            var debit = $('#debit').val();
            var debitangka = parseInt(debit.replace(/,.*|[^0-9]/g, ''), 10);
            var kredit = $('#kredit').val();
            var kreditangka = parseInt(kredit.replace(/,.*|[^0-9]/g, ''), 10);

            //VALIDASI
            if(debitangka == 0 && kreditangka == 0){
                swal({
                    title: 'Peringatan!',
                    text: "Debit atau Kredit Harus Diisi",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                return false;
            }else if(debitangka != 0 && kreditangka != 0){
                
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

            if(keterangan == ""){
                swal({
                    title: 'Peringatan!',
                    text: "Masukan keterangan kas",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                return false;
            }


            var form_data = new FormData();   
            form_data.append('tanggal', tg);               
            form_data.append('keterangan', keterangan);
            form_data.append('debit', debitangka);
            form_data.append('kredit', kreditangka);
            


            if(keterangan !=""){
                $.ajax({
                    url: "proses/addkas.php",
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: form_data,
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(!dataResult.isError){
                            $('#addRowModal').modal('hide');
                            
                            swal({
                                title: 'Berhasil!',
                                text: "Data kas tersimpan",
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

        $(".open_modal").click(function(e) {
            var m = $(this).attr("id");
            $.ajax({
            url: "Pages/ubahkas.php",
            type: "GET",
            data : {id: m,},
            success: function (ajaxData){
                    $("#ModalEdit").html(ajaxData);
                    $("#ModalEdit").modal('show',{backdrop: 'true'});
                }
            });
        });
    });
</script>

<script>
  $(function () {
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('debit');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, '');

        var kr = document.getElementById('kredit');
        kr.value = 0;
    });

    var dengan_rupiah2 = document.getElementById('kredit');
    dengan_rupiah2.addEventListener('keyup', function(e)
    {
        dengan_rupiah2.value = formatRupiah(this.value, '');

        var kr = document.getElementById('debit');
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