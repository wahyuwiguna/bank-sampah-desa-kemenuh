<?php
    // $banjar = $_GET['banjar'];
    $mulai = $_GET['mulai'];
    $akhir = $_GET['akhir'];


    $mulai2 = $mulai. " 00:00:00";
    $akhir2 = $akhir. " 23:59:59";


    $query_chart = "SELECT a.id_jenis_sampah,c.jenis_sampah, SUM(a.berat) AS berat FROM tb_penjualan_detail a INNER JOIN tb_penjualan b ON a.kode_penjualan = b.kode INNER JOIN tb_jenis_sampah c ON a.id_jenis_sampah = c.id_jenis_sampah WHERE b.tanggal >= '". $mulai2 ."' AND b.tanggal <= '". $akhir2 ."' GROUP BY a.id_jenis_sampah ORDER BY berat DESC";
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
            <li class="breadcrumb-item"><a href="javascript:void(0);">Laporan</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Laporan Penjualan Sampah</a></li>
        </ol>
    </nav>
</div>
<br>

<div class="row">
    <div id="chartBar" class="col-xl-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">                                
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4 style="padding-top:0px;padding-left:0px;">Jenis sampah yang terjual</h4> 
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div id="s-bar" class=""></div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-xl-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header" style="padding:0px 0px;">  
                <div class="col-12" style="padding: 0px 0px 10px 0px;">
                    <form method="POST" action="proses/tampilkanlappenjualansampah.php" class="form-inline">
                
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Tanggal</div>
                            </div>
                            <input id="tanggal" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date.." style="color:black;width:270px;" >
                            <input type="hidden" name="TglMulai" id="ID_START" value="<?php echo $mulai; ?>">
                            <input type="hidden" name="TglSelesai" id="ID_END" value="<?php echo $akhir; ?>">
                        </div>
            
                        <button type="submit" class="btn btn-primary btn-rounded btn-icon-text" id="tampilkan" style="margin-bottom:10px;">
                            <i data-feather="refresh-cw"></i>
                            Tampilkan
                        </button>

                        <div class="float-right">
                        <a href="pages/cetaklappenjualansampah.php?mulai=<?php echo $mulai; ?>&akhir=<?php echo $akhir; ?>" class="btn btn-success btn-rounded btn-icon-text" style="margin-bottom:10px;" target="_blank">
                            <i data-feather="printer"></i>
                            Cetak
                        </a>
                    </div>
                        
                    </form>
                    
                </div>                              
                
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th style="text-align:center;">Tanggal</th>
                                <th style="text-align:center;">Kode Transaksi</th>
                                <th style="text-align:center;">Pengepul</th>
                                <th style="text-align:center;">No Telp</th>
                                <th style="text-align:center;">Jenis Sampah</th>
                                <th style="text-align:center;">Berat</th>
                                <th style="text-align:center;">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT a.*, b.kode_pengepul, b.no_telp, b.nama_pengepul FROM tb_penjualan a INNER JOIN tb_pengepul b ON a.id_pengepul = b.id_pengepul WHERE a.tanggal >= '". $mulai2 ."' AND a.tanggal <= '". $akhir2 ."' ORDER BY a.tanggal DESC"; 
                                $sql2 = mysqli_query($koneksi, $query); 
                                $no = 1;
                                $totberat = 0;
                                $totharga = 0;

                                while($data = mysqli_fetch_array($sql2)){
                                    $items = array();
                                    $q_item = mysqli_query($koneksi, "SELECT a.jenis_sampah FROM tb_penjualan_detail a WHERE a.kode_penjualan = '". $data['kode'] ."' ORDER BY a.jenis_sampah ASC");
                                    $c = 0;
                                    while($d_item = mysqli_fetch_array($q_item)){
                                        $items[$c] = $d_item['jenis_sampah'];
                                        $c++;
                                    }

                                    echo "<tr>";
                                    echo "<td style='text-align:center;'>".$no++."</td>";
                                    echo "<td style='text-align:center;'>".date('d M Y', strtotime($data['tanggal']))."</td>";
                                    echo "<td>".$data['kode']."</td>";
                                    echo "<td>".$data['kode_pengepul'] ."<br><b>".$data['nama_pengepul']."</b></td>"; 
                                    echo "<td>".$data['no_telp']."</td>";
                                    echo "<td>";
                                        foreach( $items as $s )  
                                        {  
                                        echo "- $s<br />";  
                                        }  
                                    echo "</td>";                                
                                    
                                    echo "<td style='text-align:center;'>".$data['total_berat']."</td>";                                 
                                    echo "<td style='text-align:right;'>".number_format($data['total_harga'])."</td>";
                                    echo "</tr>";

                                    $totberat += $data['total_berat'];
                                    $totharga += $data['total_harga'];
                                }
                            ?>
                        
                    
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="text-align:center;"><b>TOTAL</b></td>
                                <td style="text-align:center;"><b><?php echo $totberat; ?> Kg</b></td>
                                <td style="text-align:right;"><b>Rp. <?php echo number_format($totharga); ?></b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>


<script>
    $(document).ready(function() {
        var f2 = flatpickr(document.getElementById('tanggal'), {
            mode: "range",
            enableTime: false,
            dateFormat: "Y-m-d",
            // defaultDate: "today",
            defaultDate: ["<?php echo $mulai; ?>", "<?php echo $akhir; ?>"],
            onChange:function(selectedDates){
                var _this=this;
                var dateArr = selectedDates.map(function(date){return _this.formatDate(date,'Y-m-d');});
                $('#ID_START').val(dateArr[0]);
                $('#ID_END').val(dateArr[1]);
                
            },
        });
       
    });
</script>

<script>
    var sBar = {
        chart: {
            height: 350,
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

