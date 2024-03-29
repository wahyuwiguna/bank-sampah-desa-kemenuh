<?php
    $nasabah = $_SESSION['id_nasabah'];
    $tahun = date('Y');

    $modal=mysqli_query($koneksi,"SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar WHERE a.id_nasabah='$nasabah' LIMIT 1");
    $data = mysqli_fetch_array($modal);


    $totsampahterkumpul = array();
    $sumsampahterkumpul = 0;
    $totnilaisampahterkumpul = array();
    $sumnilaisampahterkumpul = 0;
    

    for ($a=1; $a <= 12 ; $a++) { 
        $query_da = "SELECT COALESCE(sum(total_harga), 0) as total, COALESCE(sum(total_berat), 0) as jumlah FROM tb_tabungan_sampah WHERE MONTH(tanggal) = $a AND YEAR(tanggal) = $tahun AND id_nasabah='". $nasabah ."'";
        $sql_da = mysqli_query($koneksi, $query_da);
        $data_da = mysqli_fetch_array($sql_da);
        $totsampahterkumpul[$a - 1] = $data_da['jumlah'];
        $totnilaisampahterkumpul[$a - 1] = $data_da['total'];

        $sumsampahterkumpul += $data_da['jumlah'];
        $sumnilaisampahterkumpul += $data_da['total'];
    } 


    $query_chart = "SELECT a.id_jenis_sampah,c.jenis_sampah, SUM(a.berat) AS berat FROM tb_tabungan_sampah_detail a INNER JOIN tb_tabungan_sampah b ON a.kode_tabungan_sampah = b.kode INNER JOIN tb_jenis_sampah c ON a.id_jenis_sampah = c.id_jenis_sampah WHERE b.id_nasabah = '". $nasabah ."' AND YEAR(b.tanggal) = ".$tahun." GROUP BY a.id_jenis_sampah ORDER BY berat DESC";
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

<style>
    div.scroll {
        background-color: #fed9ff;
        width: auto;
        height: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 20px;
    }
</style>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        </ol>
    </nav>

</div>

<div class="row layout-top-spacing">

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-account-invoice-two">
            <div class="widget-content" style="height:240px;">
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
                            
                        </div>
                    </div>

                
                
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing" style="padding-bottom:0px;">
        <div class="row widget-statistic">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" style="padding-bottom:0px;">
                <div class="widget widget-one_hybrid widget-followers">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <i data-feather="trash-2"></i>
                            </div>
                            <div class="">
                                <p class="w-value"><?php echo $sumsampahterkumpul; ?> Kg</p>
                                <h5 class="">Total Sampah Terkumpul</h5>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">    
                        <div class="w-chart">
                            <div id="hybrid_followers"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" style="padding-bottom:0px;">
                <div class="widget widget-one_hybrid widget-engagement">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <i data-feather="shopping-cart"></i>
                            </div>
                            <div class="">
                                <p class="w-value">Rp. <?php echo number_format($sumnilaisampahterkumpul); ?></p>
                                <h5 class="">Total Tabungan Sampah</h5>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">    
                        <div class="w-chart">
                            <div id="hybrid_followers3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
        
</div>

<div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-table-one">
            <div class="widget-heading">
                <h5 class="">Jenis sampah yang diterima</h5>
            </div>

            <div class="widget-content" style="overflow-y: auto; height:300px; padding-right:10px;">


            <?php
                                    
                $query = "SELECT * FROM tb_jenis_sampah WHERE status = '1' ORDER BY jenis_sampah ASC"; 

                $sql = mysqli_query($koneksi, $query); 
                

                while($data = mysqli_fetch_array($sql)){
            ?>
                <div class="transactions-list t-info">
                    <div class="t-item">
                        <div class="t-company-name">
                            <div class="t-icon">
                                <div class="icon" style="background-color:#f3effc;">
                                    <i data-feather="trash-2"></i>
                                </div>
                            </div>
                            <div class="t-name">
                                <h4><?php echo $data['jenis_sampah']; ?></h4>
                                <p class="meta-date"><?php echo $data['keterangan']; ?></p>
                            </div>
                        </div>
                        <div class="t-rate rate-inc">
                            <p><span><?php echo number_format($data['harga_beli']); ?> /kg</span></p>
                        </div>
                    </div>
                </div>

            <?php
                }
            ?>

                
                
            </div>
        </div>
        
    </div>
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-three">
            <div class="widget-heading">
                <div class="">
                    <h5 class="">Jenis Sampah Yang Terkumpul di Tahun <?php echo $tahun; ?></h5>
                </div>
            </div>

            <div class="widget-content">
                 <div id="s-bar" class=""></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Followers

  var d_1options3 = {
    chart: {
      id: 'sparkline1',
      type: 'area',
      height: 160,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    series: [{
      name: 'Berat Tabungan Sampah',
      data: [
        <?php 
            for ($p=0; $p < 12; $p++) {
            echo $totsampahterkumpul[$p].",";

            }
            ?>
      ]
    }],
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul','Agu', 'Sep','Okt','Nop','Des'],
    yaxis: {
      min: 0
    },
    colors: ['#4361ee'],
    tooltip: {
      x: {
        show: true,
      },
      
    },
  }

  

  // Engagement Rate

  var d_1options5 = {
    chart: {
      id: 'sparkline1',
      type: 'area',
      height: 160,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    fill: {
      opacity: 1,
    },
    series: [{
      name: 'Tabungan Sampah',
      data: [
        <?php 
            for ($p=0; $p < 12; $p++) {
            echo $totnilaisampahterkumpul[$p].",";

            }
            ?>
      ]
    }],
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul','Agu', 'Sep','Okt','Nop','Des'],
    yaxis: {
      min: 0
    },
    colors: ['#1abc9c'],
    tooltip: {
      x: {
        show: true,
      }
    }
  }

   // Followers

   var d_1C_5 = new ApexCharts(document.querySelector("#hybrid_followers"), d_1options3);
  d_1C_5.render()


  // Engagement Rate

  var d_1C_7 = new ApexCharts(document.querySelector("#hybrid_followers3"), d_1options5);
  d_1C_7.render()



</script>

<script>
    var sBar = {
        chart: {
            height: 320,
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