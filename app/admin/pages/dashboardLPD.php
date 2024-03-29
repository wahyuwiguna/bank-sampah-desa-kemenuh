<?php
    $tgl = date('Y-m-d');

    $tahun = date('Y');
    $bln = date('m');
    $namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

    // TOTAL NASABAH
    $query5 = "SELECT COUNT(id_nasabah) as total FROM tb_nasabah WHERE status='Aktif'";
    $hasil5 = mysqli_query($koneksi,$query5);
    $data5 = mysqli_fetch_array($hasil5);

    $sumnasabah = $data5['total'];

    // TOTAL JENIS SAMPAH
    $query5 = "SELECT COUNT(id_jenis_sampah) as total FROM tb_jenis_sampah WHERE status='1'";
    $hasil5 = mysqli_query($koneksi,$query5);
    $data5 = mysqli_fetch_array($hasil5);

    $sumjenissampah = $data5['total'];

    // TOTAL PENGEPUL
    $query5 = "SELECT COUNT(id_pengepul) as total FROM tb_pengepul WHERE status='1'";
    $hasil5 = mysqli_query($koneksi,$query5);
    $data5 = mysqli_fetch_array($hasil5);

    $sumpengepul = $data5['total'];

    $totsampahterkumpul = array();
    $sumsampahterkumpul = 0;
    $totnilaisampahterkumpul = array();
    $sumnilaisampahterkumpul = 0;
    
    $totpenarikantabungan = array();
    $sumpenarikantabungan = 0;


    for ($a=1; $a <= 12 ; $a++) { 
        $query_da = "SELECT COALESCE(sum(total_harga), 0) as total, COALESCE(sum(total_berat), 0) as jumlah FROM tb_tabungan_sampah WHERE MONTH(tanggal) = $a AND YEAR(tanggal) = $tahun";
        $sql_da = mysqli_query($koneksi, $query_da);
        $data_da = mysqli_fetch_array($sql_da);
        $totsampahterkumpul[$a - 1] = $data_da['jumlah'];
        $totnilaisampahterkumpul[$a - 1] = $data_da['total'];

        $sumsampahterkumpul += $data_da['jumlah'];
        $sumnilaisampahterkumpul += $data_da['total'];
    } 

    for ($a=1; $a <= 12 ; $a++) { 
        $query_da = "SELECT COALESCE(sum(jumlah), 0) as jumlah FROM tb_penarikan_tabungan WHERE MONTH(tanggal) = $a AND YEAR(tanggal) = $tahun";
        $sql_da = mysqli_query($koneksi, $query_da);
        $data_da = mysqli_fetch_array($sql_da);
        $totpenarikantabungan[$a - 1] = $data_da['jumlah'];

        $sumpenarikantabungan += $data_da['jumlah'];
    } 

    




    //GRAFIK PEMBELIAN DAN PENJUALAN SAMPAH
    $daftar_penjualan = array();
        for ($a=1; $a <= 12 ; $a++) { 
        $query_da = "SELECT COALESCE(sum(total_harga), 0) as total FROM `tb_penjualan` WHERE MONTH(tanggal) = $a AND YEAR(tanggal) = $tahun";
        $sql_da = mysqli_query($koneksi, $query_da);
        $data_da = mysqli_fetch_array($sql_da);
        $daftar_penjualan[$a - 1] = $data_da['total'];
    } 

    $daftar_pembelian = array();
    for ($a=1; $a <= 12 ; $a++) { 
        $query_da = "SELECT COALESCE(sum(total_harga), 0) as total FROM `tb_tabungan_sampah` WHERE MONTH(tanggal) = $a AND YEAR(tanggal) = $tahun";
        $sql_da = mysqli_query($koneksi, $query_da);
        $data_da = mysqli_fetch_array($sql_da);
        $daftar_pembelian[$a - 1] = $data_da['total'];
    } 

?>


<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        </ol>
    </nav>
</div>

<div class="row layout-top-spacing">

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-four">
            <div class="widget-heading">
                <h5 class="">Data Master</h5>
            </div>
            <div class="widget-content">

                <div class="order-summary">

                    <div class="summary-list summary-income">

                        <div class="summery-info">

                            <div class="w-icon">
                                <i data-feather="users"></i>
                            </div>

                            <div class="w-summary-details">

                                <div class="w-summary-info">
                                    <h6>Total Nasabah <span class="summary-count" id="totnasabah"><?php echo $sumnasabah;?> Nasabah </span></h6>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="summary-list summary-profit">

                        <div class="summery-info">

                            <div class="w-icon">
                                <i data-feather="trash"></i>
                            </div>
                            <div class="w-summary-details">

                                <div class="w-summary-info">
                                    <h6>Total Jenis Sampah <span class="summary-count" id="totjenissampah"><?php echo $sumjenissampah;?> Jenis Sampah</span></h6>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="summary-list summary-expenses">

                        <div class="summery-info">

                            <div class="w-icon">
                                <i data-feather="globe"></i>
                            </div>
                            <div class="w-summary-details">

                                <div class="w-summary-info">
                                    <h6>Total Pengepul <span class="summary-count" id="totpengepul"><?php echo $sumpengepul;?> Pengepul</span></h6>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="row widget-statistic">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
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
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-referral">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <i data-feather="shopping-bag"></i>
                            </div>
                            <div class="">
                                <p class="w-value">Rp. <?php echo number_format($sumnilaisampahterkumpul); ?></p>
                                <h5 class="">Total Nilai Sampah Terkumpul</h5>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">    
                        <div class="w-chart">
                            <div id="hybrid_followers1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-engagement">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <i data-feather="credit-card"></i>
                            </div>
                            <div class="">
                                <p class="w-value">Rp. <?php echo number_format($sumpenarikantabungan); ?></p>
                                <h5 class="">Total Penarikan Tabungan</h5>
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
                <h5 class="">Top Saldo Nasabah Tahun <?php echo $tahun; ?></h5>
            </div>

            <div class="widget-content">
                <?php
                                    
                    $query = "SELECT b.id_nasabah, c.nama_nasabah, c.no_rekening ,d.nama_banjar, SUM(a.berat) AS totberat, SUM(subtotal) AS totsubtotal, c.id_banjar FROM tb_tabungan_sampah_detail a INNER JOIN tb_tabungan_sampah b ON a.kode_tabungan_sampah = b.kode INNER JOIN tb_nasabah c ON b.id_nasabah = c.id_nasabah INNER JOIN tb_banjar d ON c.id_banjar = d.id_banjar WHERE YEAR(b.tanggal) = '". date('Y') ."' GROUP BY b.id_nasabah ORDER BY totsubtotal DESC LIMIT 5"; 

                    $sql = mysqli_query($koneksi, $query); 
                   

                    while($data = mysqli_fetch_array($sql)){
                ?>
                    <div class="transactions-list">
                        <div class="t-item">
                            <div class="t-company-name">
                                <div class="t-icon">
                                    <div class="icon">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                <div class="t-name">
                                    <h4><?php echo $data['nama_nasabah']; ?></h4>
                                    <p class="meta-date"><?php echo $data['no_rekening']." - ".$data['nama_banjar']; ?></p>
                                </div>
                            </div>
                            <div class="t-rate rate-inc">
                                <p><span>Rp. <?php echo number_format($data['totsubtotal']); ?></span></p>
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
                    <h5 class="">Grafik Penjualan dan Tabungan Sampah Nasabah Tahun <?php echo $tahun; ?></h5>
                </div>
            </div>

            <div class="widget-content">
                <div id="uniqueVisits"></div>
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
      name: 'Tabungan Sampah',
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

  // Referral

  var d_1options4 = {
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
      name: 'Penjualan Sampah',
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
    colors: ['#e7515a'],
    tooltip: {
      x: {
        show: true,
      }
    }
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
      name: 'Penarikan Tabungan',
      data: [
        <?php 
            for ($p=0; $p < 12; $p++) {
            echo $totpenarikantabungan[$p].",";

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

  /*
      ===================================
          Unique Visitors | Options
      ===================================
  */

  var d_1options1 = {
      chart: {
          height: 350,
          type: 'bar',
          toolbar: {
            show: false,
          }
      },
      colors: ['#1abc9c', '#4361ee'],
      plotOptions: {
          bar: {
              horizontal: false,
              columnWidth: '55%',
              endingShape: 'rounded'  
          },
      },
      dataLabels: {
          enabled: false
      },
      legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
              width: 10,
              height: 10,
            },
            itemMargin: {
              horizontal: 0,
              vertical: 8
            }
      },
      stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
      },
      series: [{
          name: 'Penjualan Sampah',
          data: [
            <?php 
              for ($p=0; $p < 12; $p++) {
                echo $daftar_penjualan[$p].",";

                }
             ?>
          ]
      }, {
        name: 'Tabungan Sampah Nasabah',
        data: [
            <?php 
              for ($p=0; $p < 12; $p++) {
                echo $daftar_pembelian[$p].",";

                }
             ?>
        ]
      }],
      xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul','Agu', 'Sep','Okt','Nop','Des'],
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'light',
          type: 'vertical',
          shadeIntensity: 0.3,
          inverseColors: false,
          opacityFrom: 1,
          opacityTo: 0.8,
          stops: [0, 100]
        }
      },
      tooltip: {
          y: {
              formatter: function (val) {
                  return val
              }
          }
      }
    }



   // Followers

   var d_1C_5 = new ApexCharts(document.querySelector("#hybrid_followers"), d_1options3);
  d_1C_5.render()

  // Referral

  var d_1C_6 = new ApexCharts(document.querySelector("#hybrid_followers1"), d_1options4);
  d_1C_6.render()

  // Engagement Rate

  var d_1C_7 = new ApexCharts(document.querySelector("#hybrid_followers3"), d_1options5);
  d_1C_7.render()


  var d_1C_3 = new ApexCharts(
      document.querySelector("#uniqueVisits"),
      d_1options1
  );
  d_1C_3.render();

</script>