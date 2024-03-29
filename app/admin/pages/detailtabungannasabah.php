<?php
    $nasabah = $_GET['id'];
    $tahun = date('Y');

    $modal=mysqli_query($koneksi,"SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar WHERE a.id_nasabah='$nasabah' LIMIT 1");
    $data = mysqli_fetch_array($modal);

    $query_chart = "SELECT a.id_jenis_sampah,c.jenis_sampah, SUM(a.berat) AS berat FROM tb_tabungan_sampah_detail a INNER JOIN tb_tabungan_sampah b ON a.kode_tabungan_sampah = b.kode INNER JOIN tb_jenis_sampah c ON a.id_jenis_sampah = c.id_jenis_sampah WHERE b.id_nasabah = '". $nasabah ."' GROUP BY a.id_jenis_sampah ORDER BY berat DESC";
    $sql_chart = mysqli_query($koneksi, $query_chart);
    
    $jenis_sampah_chart = array();
    $jumlah_jenis_sampah_chart = array();

    $a = 1;
    while($data_chart = mysqli_fetch_array($sql_chart)){
        $jenis_sampah_chart[$a - 1] = $data_chart['jenis_sampah'];
        $jumlah_jenis_sampah_chart[$a - 1] = $data_chart['berat'];

        $a++;
    }


?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Tabungan Nasabah</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Detail Tabungan Nasabah</a></li>
        </ol>
    </nav>
    <div class="float-right">
        
    </div>
</div>

<div class="row layout-top-spacing">
    <div class="col-5">
        <div class="widget widget-account-invoice-two">
            <div class="widget-content" style="height:220px;">
                <div class="account-box">
                    <div class="info">
                        <div class="inv-title">
                            <h5 class=""><span id="card-nik"><?php echo $data['NIK']; ?></span></h5>
                            <h3 class="text-white"><span id="card-nama"><?php echo $data['nama_nasabah']; ?></span></h3>
                            <h6 class="text-white"><span id="card-notelp"><?php echo $data['no_telp']; ?></span></h6>
                            <h6 class="text-white"><span id="card-alamat"><?php echo $data['alamat']; ?></span></h6>
                            <h6 class="text-white"><span id="card-banjar"><?php echo $data['nama_banjar']; ?></span></h6>
                        </div>
                        <div class="inv-balance-info">

                            <p class="inv-balance" style="font-size:30px;">Rp. <span id="card-saldo"><?php echo number_format($data['saldo']); ?></span></p>
                            <span class="inv-stats balance-credited"><?php echo $data['no_rekening']; ?></span>
                            <br><br><br><br><br><br>
                            <button type="button" class="btn btn-warning btn-rounded btn-icon-text" id="btnAdd">
                                <i data-feather="pocket"></i>
                                Tarik Saldo
                            </button>
                        </div>
                    </div>

                   
                
                </div>
            </div>
        </div>
    </div>

    <div class="col-7">
        <div id="chartBar" class="col-xl-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 style="padding-top:0px;padding-left:0px;">Jenis sampah yang dikumpulkan</h4> 
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div id="s-bar" class=""></div>
                </div>
            </div>
        </div>
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
                        <th style="text-align:center;">Kode Transaksi</th>
                        <th style="text-align:center;">Debit</th>
                        <th style="text-align:center;">Kredit</th>
                        <th style="text-align:center;">Saldo</th>
                        <!-- <th class="text-center dt-no-sorting">Aksi</th>  -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM tb_tabungan WHERE id_nasabah = ". $nasabah ." ORDER BY tanggal DESC, debit ASC";
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        $saldo = $data['saldo'];

                        while($data2 = mysqli_fetch_array($sql)){
                            echo "<tr>";
                            echo "<td style='text-align:center;'>".$no++."</td>";
                            echo "<td style='text-align:center;'>".date('d M Y', strtotime($data2['tanggal']))."</td>";
                            echo "<td>".$data2['kode_transaksi']."</td>";
                            
                            echo "<td style='text-align:right;color:#05a34a;'>".number_format($data2['debit'])."</td>";
                            echo "<td style='text-align:right;color:#ff3366;'>".number_format($data2['kredit'])."</td>";
                            echo "<td style='text-align:right;color:#6571ff;'>".number_format($saldo)."</td>"; 
                            // if($data2['kredit'] > 0){
                            //     echo "<td><center><a href='Pages/cetakbuktipenarikan.php?kode=". $data2['kode_transaksi'] ."' target='_blank'><button class='btn btn-warning btn-icon-text btn-xs'>Bukti Penarikan <i class='btn-icon-append' data-feather='printer'></i></button></a></center></td>";
                            // }else{
                            //     echo "<td></td>";
                            // }

                            $saldo = $saldo - $data2['debit'] + $data2['kredit'];
                        ?>
                        
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
<div class="modal fade" id="addRowModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tarik Saldo Nasabah</h5>
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
                        <label class="col-sm-4 col-form-label col-form-label-sm">No Rekening</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="norek" value="<?php echo $data['no_rekening']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Nama Nasabah</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="nama" value="<?php echo $data['nama_nasabah']; ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Saldo Tersedia</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="saldo" value="<?php echo number_format($data['saldo']); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row  mb-4">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Jumlah Penarikan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="jumlah" value="0" onClick="this.select();">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                <button type="button" id="addRowButton" class="btn btn-success btn-rounded">Proses</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL ADD -->

<script>
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
            var nasabah = <?php echo $nasabah; ?>;

            var tg = to1.yyyymmdd();
            var saldo = <?php echo $data['saldo']; ?>;
            var jml = $('#jumlah').val();
            var jumlah = parseInt(jml.replace(/,.*|[^0-9]/g, ''), 10);

            if(jumlah == 0){
                swal({
                    title: 'Peringatan!',
                    text: "Jumlah Penarikan Tidak Boleh 0",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                return false;
            }

            if(jumlah > saldo){
                swal({
                    title: 'Peringatan!',
                    text: "Jumlah Penarikan Melebihi Saldo",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });

                var jm = document.getElementById('jumlah');
                jm.value = Number(saldo).toLocaleString("id-ID");

                return false;
            }

            if(nasabah !=""){
                $.ajax({
                    url: "Proses/addpenarikantabungan.php",
                    type: "POST",
                    data: {
                        tanggal: tg,
                        nasabah : nasabah,
                        jumlah: jumlah
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(!dataResult.isError){
                            $('#addRowModal').modal('hide');
                            
                            swal({
                                title: 'Berhasil!',
                                text: "Penarikan Saldo Berhasil",
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
                                text: "Penarikan Saldo Gagal",
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
                    text: "Nasasbah tidak ditemukan",
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em'
                });
               
            }
        });
        
    });

    Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
            (mm>9 ? '' : '0') + mm,
            (dd>9 ? '' : '0') + dd
            ].join('-');
    };
</script>

<script>
  $(function () {
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('jumlah');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, '');
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

<script>
    var sBar = {
        chart: {
            height: 170,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        // colors: ['#4361ee'],
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opt) {
                return val + " kg"
            },
        },
        tooltip :{
            theme: 'dark',
            x: {
                show: true
            },
            y: {
                title: {
                    formatter: function () {
                        return ''
                    }
                    }
            }
        },

        series: [{
            data: [
                <?php 
                    for ($p=0; $p < count($jumlah_jenis_sampah_chart); $p++) {
                        echo "'".$jumlah_jenis_sampah_chart[$p]."',";

                    }
                ?>
            ]
        }],
        xaxis: {
            categories: [
                <?php 
                    for ($p=0; $p < count($jenis_sampah_chart); $p++) {
                        echo "'".$jenis_sampah_chart[$p]."',";

                    }
                ?>
            ],
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#s-bar"),
        sBar
    );

    chart.render();
</script>