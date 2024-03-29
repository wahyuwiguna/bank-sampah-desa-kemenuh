<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Data Master</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Data Nasabah</a></li>
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
                        <th style="text-align:center;">NIK</th>
                        <th style="text-align:center;">Tgl Register</th>
                        <th style="text-align:center;">Rekening</th>
                        <th style="text-align:center;">Nama</th>
                        <th style="text-align:center;">No Telp</th>
                        <th style="text-align:center;">Banjar</th>
                        <th style="text-align:center;">Saldo</th>
                        <th style="text-align:center;">Status</th> 
                        <th class="text-center dt-no-sorting">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar ORDER BY a.id_nasabah DESC"; 
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        while($data = mysqli_fetch_array($sql)){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>".$data['NIK']."</td>";
                        echo "<td style='text-align:center;'>".date('d M Y', strtotime($data['tanggal_register']))."</td>";
                        echo "<td>".$data['no_rekening']."</td>";
                        echo "<td>".$data['nama_nasabah']."</td>";
                        echo "<td>".$data['no_telp']."</td>";
                        echo "<td>".$data['nama_banjar']."</td>";
                        echo "<td style='text-align:right;'>".number_format($data['saldo'])."</td>";
                        if ($data['status']=='Aktif') {
                            echo "<td style='text-align:center;'><span class='badge bg-success'>Aktif</span></td>";
                        }elseif ($data['status']=='TidakAktif') {
                            echo "<td style='text-align:center;'><span class='badge bg-danger'>Non-Aktif</span></td>";
                        }elseif ($data['status']=='Validasi') {
                            echo "<td style='text-align:center;'><span class='badge bg-warning'>Validasi</span></td>";
                        }
                        ?>
                        <td class="text-center">
                            <a href="#" id="<?php echo $data['id_nasabah']; ?>" class="open_modal bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah"><i data-feather="edit-3"></i></a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Nasabah</h5>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">NIK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="nik">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="nama">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="alamat">
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Banjar</label>
                        <div class="col-sm-9">
                            <select class="selectpicker form-control" id="banjar" style="width:100%">
                                <option value="" selected>- Pilih Banjar -</option>
                                <?php 
                                $query_k = "SELECT * FROM tb_banjar ORDER BY nama_banjar ASC";
                                $sql_k = mysqli_query($koneksi, $query_k); 
                            
                                while($data_kat = mysqli_fetch_array($sql_k)){
                                echo "<option value='$data_kat[id_banjar]' ><b>".$data_kat['nama_banjar']."</b></option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">No Telp</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="nohp">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm" id="password">
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
            var nik = $('#nik').val();
            var nama = $('#nama').val();
            var alamat = $('#alamat').val();
            var jb = document.getElementById("banjar");
            var banjar = jb.value;
            var notelp = $('#nohp').val();
            var password = $('#password').val();

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
            }else if(password == ""){
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

            if(nik !="" && nama !="" && password !=""){
                $.ajax({
                    url: "proses/addnasabah.php",
                    type: "POST",
                    data: {
                        nik: nik,
                        nama: nama,
                        alamat: alamat,
                        banjar: banjar,
                        notelp: notelp,
                        password: password,				
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

        $(".open_modal").click(function(e) {
            var m = $(this).attr("id");
            $.ajax({
            url: "Pages/ubahnasabah.php",
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