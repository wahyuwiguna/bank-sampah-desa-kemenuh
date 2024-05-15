<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Data Master</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Data Pengepul</a></li>
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
                        <th style="text-align:center;">Kode</th>
                        <th style="text-align:center;">Nama</th>
                        <th style="text-align:center;">No Telp</th>
                        <th style="text-align:center;">Status</th> 
                        <th class="text-center dt-no-sorting">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM tb_pengepul ORDER BY `id_pengepul` DESC"; 
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        while($data = mysqli_fetch_array($sql)){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>".$no++."</td>";
                        echo "<td>".$data['kode_pengepul']."</td>";
                        echo "<td>".$data['nama_pengepul']."</td>";
                        echo "<td>".$data['no_telp']."</td>";
                        if ($data['status']=='1') {
                        echo "<td style='text-align:center;'><span class='badge bg-success'>Aktif</span></td>";
                        }elseif ($data['status']=='0') {
                        echo "<td style='text-align:center;'><span class='badge bg-danger'>Non-Aktif</span></td>";
                        }
                        ?>
                        <td class="text-center">
                            <a href="#" id="<?php echo $data['id_pengepul']; ?>" class="open_modal bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah"><i data-feather="edit-3"></i></a>
                        </td>
                        <?php 
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengepul</h5>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="nama">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">No Telp</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="nohp">
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
    $(document).ready(function() {

        $('#btnAdd').on('click', function() {
            $('#addRowModal').modal('show');
            document.getElementById("formTambah").reset();
        });
        
        $('#addRowButton').on('click', function() {
            var namauser = $('#nama').val();
            var notelp = $('#nohp').val();
            

            if(namauser !="" && notelp !=""){
                $.ajax({
                    url: "proses/addpengepul.php",
                    type: "POST",
                    data: {
                        nama: namauser,
                        notelp: notelp
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(!dataResult.isError){
                            $('#addRowModal').modal('hide');
                            
                            swal({
                                title: 'Berhasil!',
                                text: "Data tersimpan",
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

        $('#zero-config').on('click', '.open_modal', function() {
            var m = $(this).attr("id");
            $.ajax({
            url: "Pages/ubahpengepul.php",
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

