<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Tabungan Sampah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Tambah Transaksi Tabungan Sampah</a></li>
        </ol>
    </nav>
    
</div>

<div class="row layout-top-spacing">
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <div class="row" style="margin: 15px;">
                        <div class="col-5">
                            <div class="form-group row mb-4">
                                <label class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-xl-10 col-lg-9 col-sm-10">
                                    <input id="tanggal" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date.." style="color:black;">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-xl-2 col-sm-3 col-sm-2 col-form-label">Nasabah</label>
                                <div class="col-xl-10 col-lg-9 col-sm-10">
                                    <select class="selectpicker form-control" id="nasabah" data-live-search="true" onchange="nasabah_changed()">
                                        <option value="" selected>- Pilih Nasabah -</option>
                                        <?php 
                                            $query_k = "SELECT * FROM tb_nasabah WHERE status = 'Aktif' ORDER BY id_nasabah DESC";
                                            $sql_k = mysqli_query($koneksi, $query_k); 
                                        
                                            while($data_kat = mysqli_fetch_array($sql_k)){
                                            echo "<option value='$data_kat[id_nasabah]' ><b>".$data_kat['NIK']." - ".$data_kat['nama_nasabah']."</b></option>";
                                            }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>  

                        <div class="col-7">
                            <div class="form-group form-group-default" style="text-align:right;">
                                <label>Grand Total</label>
                                <h1 style="font-size:50px;">Rp. <span id="grandtotal">0</span></h1>
                            </div>
                        </div>  

                </div>
                
                <div class="row" style="margin: 15px;">

                    <div class="col-5" id="card-nasabah">
                        <div class="widget widget-account-invoice-two">
                            <div class="widget-content" style="height:150px;">
                                <div class="account-box">
                                    <div class="info">
                                        <div class="inv-title">
                                            <h5 class=""><span id="card-nik">NIK</span></h5>
                                            <h3 class="text-white"><span id="card-nama">NAMA NASABAH</span></h3>
                                            <h6 class="text-white"><span id="card-notelp">NO TELP</span></h6>
                                            <h6 class="text-white"><span id="card-alamat">ALAMAT</span></h6>
                                            <h6 class="text-white"><span id="card-banjar">BANJAR</span></h6>
                                        </div>
                                        <div class="inv-balance-info">

                                            <p class="inv-balance">Rp. <span id="card-saldo">0</span></p>
                                            <span class="inv-stats balance-credited">Saldo</span>
                                            
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-7">
                        <div class="form-group form-group-default" style="text-align:right;">
                            <label>Total Berat</label>
                            <h1 style="font-size:50px;"><span id="totalberat">0</span> Kg</h1>
                        

                            <br><br>
                            <a href="index.php?ref=transaksitabungansampah.php&mulai=<?php echo $today; ?>&akhir=<?php echo $today; ?>" class="btn btn-outline-dark">Batal</a>
                            <button id="saveRowButton" class="btn btn-success btn-icon-text">
                                Simpan Transaksi
                            </button>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <button type="button" class="btn btn-info btn-rounded btn-icon-text" id="btnAkun" style="margin: 15px;">
                    <i data-feather="search"></i>
                    Cari Jenis Sampah
                </button>

                <div class="row" style="margin: 15px;">
                    <div class="col-12">
                        <span id="totaldata" style="display:none;">0</span>
                        <div class="table-responsive">
                            <table id="dtTable" class="table table-striped table-bordered" style="width:100%">
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cari Jenis Sampah</h5>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Jenis Sampah</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="kode_sampah">
                            <select class="selectpicker form-control" data-live-search="true" id="jenissampah" style="width:100%" onchange="produk_changed()">
                                <?php 
                                    $query_k = "SELECT * FROM tb_jenis_sampah WHERE status ='1' ORDER BY jenis_sampah ASC";
                                    $sql_k = mysqli_query($koneksi, $query_k); 
                                    echo "<option value='' selected>- Pilih -</option>";
                                    while($data_kat = mysqli_fetch_array($sql_k)){
                                        echo "<option value='$data_kat[id_jenis_sampah]' ><b>".$data_kat['jenis_sampah']."</b></option>";
                                        }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="keterangan" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Harga /Kg</label>
                        <div class="col-sm-9">
                            <input id="harga" type="text" class="form-control" value="0" onkeyup="calculate()" onClick="this.select();">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Total Berat (Kg)</label>
                        <div class="col-sm-9">
                            <input id="jumlah" type="text" class="form-control" value="0" onkeyup="calculate()" onClick="this.select();" pattern="^\d*(\.\d{0,2})?$">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Nilai Sampah</label>
                        <div class="col-sm-9">
                            <input id="subtotal" type="text" class="form-control" value="0" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="addRowButton" class="btn btn-success btn-rounded">Tambah</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL ADD -->

<!-- MODAL EDIT -->
<div class="modal fade" id="editRowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Jenis Sampah</h5>
            </div>
            <div class="modal-body">
                <form id="formTambah">
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Jenis Sampah</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="id_tabungan_sampah_detail_temp2">
                            <input id="jenissampah2" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="keterangan2" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Harga /Kg</label>
                        <div class="col-sm-9">
                            <input id="harga2" type="text" class="form-control" value="0" onkeyup="calculate2()" onClick="this.select();">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Total Berat (Kg)</label>
                        <div class="col-sm-9">
                            <input id="jumlah2" type="text" class="form-control" value="0" onkeyup="calculate2()" onClick="this.select();" pattern="^\d*(\.\d{0,2})?$">
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-3 col-form-label col-form-label-sm">Nilai Sampah</label>
                        <div class="col-sm-9">
                            <input id="subtotal2" type="text" class="form-control" value="0" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="editRowButton" class="btn btn-success btn-rounded">Ubah</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL EDIT -->

<script>
$(document).ready(function() {
    var f2 = flatpickr(document.getElementById('tanggal'), {
        enableTime: false,
        dateFormat: "Y-m-d",
        defaultDate: "today",
    });

    $('#btnAkun').on('click', function() {
        var e = document.getElementById("nasabah");
        var nasabah_id = e.value;

        if(nasabah_id == ""){
            swal({
                title: 'Peringatan!',
                text: "Pilih Nasabah Terlebih Dahulu",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });

            return false;
        }else{
            $('#addRowModal').modal('show');
            $('#jenissampah').prop('selectedIndex',0);
            $("#jenissampah").val("").trigger('change');
            document.getElementById("formTambah").reset();
        }

       
        
    });

    catTable = $('#dtTable').DataTable( {
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "thousands": "."
            },
        columns: [
            { title: "Kode", className: 'text-center'},
            { title: "Jenis Sampah", className: 'text-left' },
            { title: "Harga /Kg", className: 'text-right', render: $.fn.dataTable.render.number( '.', '.', 0, '' )},
            { title: "Jumlah (Kg)", className: 'text-center'}, 
            { title: "Subtotal", className: 'text-right', render: $.fn.dataTable.render.number( '.', '.', 0, '' )},
            { title: "Aksi", className: 'text-center' },
        ],
    });

    get_list();

    $('#addRowButton').on('click', function() {
        // $("#addRowButton").attr("disabled", "disabled");
        
		var jb = document.getElementById("jenissampah");
        var idjenissampah = jb.value;
        var kodesampah = $('#kode_sampah').val();

        var jenissampah = $("#jenissampah option:selected" ).text();

        var harga = $('#harga').val();
        var hargaangka = parseInt(harga.replace(/,.*|[^0-9]/g, ''), 10);

        var jumlah = document.getElementById('jumlah').value;
        
        var subtotal = $('#subtotal').val();
        var subtotalangka = parseInt(subtotal.replace(/,.*|[^0-9]/g, ''), 10);
        
		if(idjenissampah !=""){
			$.ajax({
				url: "Proses/addtabungansampahdetailtemp.php",
				type: "POST",
				data: {
					id_jenis_sampah: idjenissampah,
                    jenis_sampah: jenissampah,
                    kode_sampah: kodesampah,
                    harga: hargaangka,
                    jumlah: jumlah,
                    subtotal: subtotalangka,
                    
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(!dataResult.isError){
                        $('#addRowModal').modal('hide');
                        get_list();
                        
                        
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
                text: "Pilih Jenis Sampah Dahulu",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });
		}
	});

    $('#editRowButton').on('click', function() {
        // $("#addRowButton").attr("disabled", "disabled");
    
        var id = $('#id_tabungan_sampah_detail_temp2').val();
        var harga = $('#harga2').val();
        var hargaangka = parseInt(harga.replace(/,.*|[^0-9]/g, ''), 10);

        var jumlah = document.getElementById('jumlah2').value;
        

        var subtotal = $('#subtotal2').val();
        var subtotalangka = parseInt(subtotal.replace(/,.*|[^0-9]/g, ''), 10);
        
		if(id !=""){
			$.ajax({
				url: "Proses/updatetabungansampahdetailtemp.php",
				type: "POST",
				data: {
					id: id,
                    harga: hargaangka,
                    jumlah: jumlah,
                    subtotal: subtotalangka,
                    
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(!dataResult.isError){
                        $('#editRowModal').modal('hide');
                        get_list();                        
                        
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
                text: "Detail Jenis Sampah Tidak Ditemukan",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });
		}
	});

    $('#saveRowButton').on('click', function() {
        swal({
            title: 'Simpan Transaksi?',
            text: "Tabungan sampah akan disimpan",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1abc9c',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Tidak',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                createdata();
            }
        });

	});

    $('#dtTable').on('click','.updateUser',function(){
        var id = $(this).data('id');

        $('#editRowModal').modal('show');

        //OPEN MODAL

        $.ajax({
            url: 'proses/loaddetailtabungansampahtemp.php',
            type: 'post',
            data: {id: id},
            success: function(dataResult){
                 var data = JSON.parse(dataResult);
                 
                document.getElementById("id_tabungan_sampah_detail_temp2").value = data[0].id; 
                document.getElementById("jenissampah2").value = data[0].jenissampah;
                document.getElementById("keterangan2").value = data[0].keterangan;
                document.getElementById("harga2").value = Number(data[0].harga).toLocaleString("id-ID");
                document.getElementById("jumlah2").value = data[0].jumlah;
                document.getElementById("subtotal2").value = Number(data[0].subtotal).toLocaleString("id-ID");
                
            }
        });

    });

    $('#dtTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');
       
        swal({
            title: 'Anda Yakin?',
            text: "Hapus jenis sampah yang dipilih",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e7515a',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Tidak',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: 'proses/deletetabungansampahdetailtemp.php',
                    type: 'post',
                    data: {id: id},
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(!dataResult.isError){
                            
                            if(dataResult.baris == 0){
                                location.reload();
                            }else{
                                get_list();
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
        });

    });
    
});

function get_list() {
    catTable.clear();
    var subtot = 0;
    var row = 0;
    var totitem = 0;
    

    $.ajax({
        url: 'proses/getdetailtabungansampahtemp.php',
        type: 'post',
        data: {},
        success: function (data) {
            var dataR = JSON.parse(data);

            if(!dataR.noData){
                $.each(dataR.data, function() {
                catTable.row.add([
                        // this.gambar,
                        this.kode_sampah,
                        this.jenis_sampah,
                        this.harga,
                        this.jumlah,
                        this.subtotal,
                        this.action
                ]).draw();

                subtot =  parseInt(subtot) + parseInt(this.subtotal);
                totitem =  parseFloat(totitem) + parseFloat(this.jumlah);
                row += 1;
            });

            
                $("#grandtotal").text(Number(subtot).toLocaleString("id-ID"));
                $("#totalberat").text(Number(totitem).toLocaleString("id-ID"));
                $("#totaldata").text(row);
            }
            
        }
    });

    
}

function calculate(){
    var harga = $('#harga').val();
    var hargaangka = parseInt(harga.replace(/,.*|[^0-9]/g, ''), 10);

    var jumlah = $('#jumlah').val();

    var jml = document.getElementById('jumlah').value;

    //SUBTOTAL
    var subtot = parseInt(hargaangka) * parseFloat(jml);

    var dengan_rupiah = document.getElementById('subtotal');
    dengan_rupiah.value = Number(subtot).toLocaleString("id-ID");

}

function calculate2(){
    var harga = $('#harga2').val();
    var hargaangka = parseInt(harga.replace(/,.*|[^0-9]/g, ''), 10);

    var jumlah = $('#jumlah2').val();

    var jml = document.getElementById('jumlah2').value;

    //SUBTOTAL
    var subtot = parseInt(hargaangka) * parseFloat(jml);

    var dengan_rupiah = document.getElementById('subtotal2');
    dengan_rupiah.value = Number(subtot).toLocaleString("id-ID");

}

Date.prototype.yyyymmdd = function() {
var mm = this.getMonth() + 1; // getMonth() is zero-based
var dd = this.getDate();

return [this.getFullYear(),
        (mm>9 ? '' : '0') + mm,
        (dd>9 ? '' : '0') + dd
        ].join('-');
};

function createdata(){
    var to1 = new Date($('#tanggal').val());
    var e = document.getElementById("nasabah");
    var nasabah = e.value;

    var tg = to1.yyyymmdd();
    
    var row = $("#totaldata").text();


    if(nasabah == ""){
        swal({
                title: 'Peringatan!',
                text: "Pilih nasabah terlebih dahulu",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });
        return false;
    }

    if(row == "0"){
        swal({
                title: 'Peringatan!',
                text: "Pilih jenis sampah terlebih dahulu",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em'
            });
        return false;
    }

    $.ajax({
        url: "Proses/addtabungansampah.php",
        type: "POST",
        data: {
            tanggal: tg,
            nasabah : nasabah
            
        },
        cache: false,
        success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
            if(!dataResult.isError){
                
                swal({
                    title: 'Berhasil!',
                    text: "Tabungan sampah berhasil tersimpan",
                    type: 'success',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                setTimeout(function () {
                    window.location.href = "index.php?ref=transaksitabungansampah.php&mulai=<?php echo $today; ?>&akhir=<?php echo $today; ?>";
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

function produk_changed()
{
    var e = document.getElementById("jenissampah");
    var produk_id = e.value;

    if(produk_id != ""){
        $.ajax({
            method: 'POST',
            url: 'proses/getdetailjenissampah.php',
            data: {
                p_id: produk_id
            },
            success: function(dataResult) {

                var dataResult = JSON.parse(dataResult);
                
                var dengan_rupiah = document.getElementById('harga');
                dengan_rupiah.value = Number(dataResult.harga_beli).toLocaleString("id-ID");

                $("#jumlah").val(1);
                $("#keterangan").val(dataResult.keterangan);
                $("#kode_sampah").val(dataResult.kode_sampah);
                
                
                calculate();

            }
        }) 
    }else{
        document.getElementById("harga").value = 0;
        document.getElementById("jumlah").value = 0;
        document.getElementById("keterangan").value = "";
        document.getElementById("kode_sampah").value = "";
        
        calculate();
    }
    
    
}

function nasabah_changed(){
    var e = document.getElementById("nasabah");
    var produk_id = e.value;

    if(produk_id != ""){
        $.ajax({
            method: 'POST',
            url: 'proses/getdetailnasabah.php',
            data: {
                p_id: produk_id
            },
            success: function(dataResult) {

                var dataResult = JSON.parse(dataResult);
                
                $("#card-nik").text(dataResult.nik);
                $("#card-nama").text(dataResult.nama);
                $("#card-notelp").text(dataResult.notelp);
                $("#card-alamat").text(dataResult.alamat);
                $("#card-banjar").text(dataResult.banjar);
                $("#card-saldo").text(Number(dataResult.saldo).toLocaleString("id-ID"));
                
                // showCard();
            }
        }) 
    }else{
        
        $("#card-nik").text("NIK");
        $("#card-nama").text("NAMA NASABAH");
        $("#card-notelp").text("NO TELP");
        $("#card-alamat").text("ALAMAT");
        $("#card-banjar").text("BANJAR");
        $("#card-saldo").text(Number(0).toLocaleString("id-ID"));

        // hideCard();
        
    }
    
    
}

function showCard() {
    var x = document.getElementById("card-nasabah");
    x.style.display = "block";
    x.style.visibility = "visible";
}

function hideCard() {
    var x = document.getElementById("card-nasabah");
    x.style.display = "none";
    x.style.visibility = "hidden";
}
</script>

<script>
  $(function () {
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('harga');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, '');
    });

    var dengan_rupiah2 = document.getElementById('harga2');
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