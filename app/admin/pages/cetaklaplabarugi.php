<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bank Sampah Desa Kemenuh - Cetak Lap. Laba Rugi</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style type="text/css" media="print">
    
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin:7mm;  /* this affects the margin in the printer settings */
    }
</style>

<style>
    
.tabledata,th,td{
     /* border: 1px solid #999; */
    padding-left: 5px;
}



.tabledata {

  border-collapse: collapse;
  border: 1px solid black;
  text-align:left;
  padding-left: 5px;
}
</style>
<body style="font-size:15px;color:000;font-family: 'Rubik', sans-serif;" >

    <?php
        include '../../koneksi.php';
        $bulan = $_GET['bulan'];
        $tahun = $_GET['tahun'];

        

        $namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

        $q_data_master = mysqli_query($koneksi, "SELECT * FROM tb_pengaturan LIMIT 1");
    	$data_index = mysqli_fetch_array($q_data_master);

        // $nama_banjar ="Semua Banjar";
        // if($banjar != "all"){
        //     $q_banjar = mysqli_query($koneksi, "SELECT * FROM tb_banjar WHERE id_banjar=". $banjar ." LIMIT 1");
    	//     $data_banjar = mysqli_fetch_array($q_banjar);

        //     $nama_banjar = $data_banjar['nama_banjar'];
        // }

    ?>
    <table width="100%">
        <tr>

            <td>
                <b><?php echo $data_index['nama_perusahaan'] ?></b> 
            </td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo $data_index['alamat'] ?></td>
            <td style="text-align:right;">
            </td>
        </tr>
        <tr>
            <td><?php echo $data_index['no_hp'] ?></td>
            <td></td>
        </tr>
    </table>
    <br>

    <table width="100%">
        <tr>
            <td style="width:70px;">
                Periode 
            </td>
            <td>: <b><?php echo $namaBulan[$bulan - 1]." ".$tahun; ?></b></td>
        </tr>
        
        
    </table>

    

    <p style="text-align:center;font-size:18px;">
    <b><u>Laporan Laba Rugi</u></b>  
    </p>
    
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
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
        </div>
    </div>
   
    <br>

    <div class="row">
        <div class="col-12">
            <table width="100%" style="font-size:15px;">
                <tr>
                    <td width="70%"></td>
                    <td>Kemenuh, <?php echo date('d F Y'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Ketua <?php echo $data_index['nama_perusahaan'] ?></td>
                </tr>
                <tr>
                    <td height="50px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $data_index['owner']  ?></td>
                </tr>
                
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
    var css = '@page { size: portrait; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
    style.styleSheet.cssText = css;
    } else {
    style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);

    window.print();
    </script>
</body>
</html>