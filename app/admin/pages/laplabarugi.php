<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

   
?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Laporan</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Laporan Laba Rugi</a></li>
        </ol>
    </nav>
</div>

<br>

<div class="row">
    <div class="col-xl-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header" style="padding:0px 0px;">  
                <div class="col-12" style="padding:0px 0px 10px 0px;">
                    <form method="POST" action="proses/tampilkanlaplabarugi.php" class="form-inline">
                
                        <div class="input-group mb-2 mr-sm-2">
                            <select name="bulan" class="form-control">
                                <?php 
                                    $query_k = "SELECT * FROM tb_bulan ORDER BY id ASC";
                                    $sql_k = mysqli_query($koneksi, $query_k); 
                                    while($data_kat = mysqli_fetch_array($sql_k)){
                                    ?>
                                        <option value="<?php echo $data_kat['id']; ?>" <?php if ($data_kat['id'] == $bulan ) { echo "selected"; } ?>> <?php  echo $data_kat['bulan']; ?> </option>;
                                    <?php
                                    }

                                ?>
                            </select>
                           
                        </div>

                        <div class="input-group mb-2 mr-sm-2">
                            <select name="tahun" class="form-control">
                                <?php
                                    $y_now = date('Y');

                                    for($i = 0; $i < 2; $i++){
                                        ?>
                                        <option value="<?php echo $y_now; ?>" <?php if ($y_now == $tahun ) { echo "selected"; } ?>> <?php  echo $y_now; ?> </option>;
                                        <?php
                                        $y_now --;
                                    }
                                    
                                ?>
                            </select>
                           
                        </div>
            
                        <button type="submit" class="btn btn-primary btn-rounded btn-icon-text" id="tampilkan" style="margin-bottom:10px;">
                            <i data-feather="refresh-cw"></i>
                            Tampilkan
                        </button>

                        <div class="float-right">
                            <a href="pages/cetaklaplabarugi.php?bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-success btn-rounded btn-icon-text" style="margin-bottom:10px;" target="_blank">
                                <i data-feather="printer"></i>
                                Cetak
                            </a>
                        </div>
                        
                    </form>
                    
                </div>                              
                
            </div>
            <div class="widget-content widget-content-area">
                <br>
                <h3 class="text-center">Laba Rugi</h3>
                <div class="row">
                    <div class="col-4">

                    </div>

                    <div class="col-4">
                        <div class="table-responsive">
                            <table class="display table table-bordered" >
                                    
                                <tbody>
                                    <tr>
                                        <td colspan="2"><b>PENDAPATAN</b></td>
                                    </tr>
                                    <tr>
                                        <td>Pemasukan ke Kas</td>
                                        <td style="text-align:right;">
                                            <?php 
                                                //PENJUALAN
                                                $query1k = "SELECT sum(debit) as debit, sum(kredit) as kredit FROM tb_arus_kas WHERE YEAR(tanggal) = '". $tahun ."' AND MONTH(tanggal) = '". $bulan ."' AND status = 'Kas'";
                                                $hasil1k = mysqli_query($koneksi,$query1k);
                                                $data1k = mysqli_fetch_array($hasil1k);

                                                $debit = $data1k['debit'];
                                                $kredit = $data1k['kredit'];

                                                echo "Rp. ".number_format($debit);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Penjualan Sampah ke Pengepul</td>
                                        <td style="text-align:right;">
                                            <?php 
                                                //PENJUALAN
                                                $query1 = "SELECT sum(total_harga) as total FROM tb_penjualan WHERE YEAR(tanggal) = '". $tahun ."' AND MONTH(tanggal) = '". $bulan ."'";
                                                $hasil1 = mysqli_query($koneksi,$query1);
                                                $data1 = mysqli_fetch_array($hasil1);

                                                $totpenjualan = $data1['total'];

                                                echo "Rp. ".number_format($totpenjualan);
                                            ?>
                                        </td>
                                    </tr>
                                   

                                    <tr>
                                        <td><b>Total Pendapatan</b></td>
                                        <td style="text-align:right;"><b><?php echo "Rp. ".number_format($totpenjualan + $debit);  ?></b></td>
                                        
                                    </tr>
                                    

                                    <tr>
                                        <td colspan="2" style="padding-top:30px;"><b>PENGELUARAN</b></td> 
                                    </tr>
                                    <tr>
                                        <td>Pengeluaran dari Kas</td>
                                        <td style="text-align:right;">
                                            <?php 
                                                echo "Rp. ".number_format($kredit);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pembelian Sampah ke Nasabah</td>
                                        <td style="text-align:right;">
                                            <?php 
                                                //PEMBELIAN
                                                $query2 = "SELECT sum(total_harga) as total FROM tb_tabungan_sampah WHERE YEAR(tanggal) = '". $tahun ."' AND MONTH(tanggal) = '". $bulan ."'";
                                                $hasil2 = mysqli_query($koneksi,$query2);
                                                $data2 = mysqli_fetch_array($hasil2);

                                                $totpembelian = $data2['total'];

                                                echo "Rp. ".number_format($totpembelian);
                                            ?>
                                        </td>
                                    </tr>

                                   
                                    
                                    <tr>
                                        <td ><b>Total Pengeluaran</b></td>
                                        <td style="text-align:right;"><b><?php echo "Rp. ". number_format($totpembelian + $kredit) ?></b></td>
                                    </tr>
                                    <tr>
                                    <td style="padding-top:40px;"><b>LABA / RUGI</b></td> 
                                    <td style="text-align:right;padding-top:40px;"><b>
                                        <?php 
                                            $laba = ($totpenjualan + $debit) - ($totpembelian + $kredit);

                                            if($laba > 0){
                                                echo "Rp. ". number_format($laba);
                                            }else{
                                                echo "- Rp. ". number_format($laba * -1);
                                            }
                                        ?>
                                                            
                                    </b></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                    </div> 

                    <div class="col-4">

                    </div>

                </div>

                <br><br>
            </div>
        </div>
    </div>
    
</div>


<script>
    $(document).ready(function() {
        var f2 = flatpickr(document.getElementById('tanggal'), {
            enableTime: false,
            dateFormat: "Y-m",
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


