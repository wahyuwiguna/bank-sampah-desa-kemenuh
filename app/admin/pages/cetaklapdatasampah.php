<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bank Sampah Desa Kemenuh - Cetak Lap. Data Sampah</title>
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
        // $banjar = $_GET['banjar'];
        $mulai = $_GET['mulai'];
        $akhir = $_GET['akhir'];


        $mulai2 = $mulai. " 00:00:00";
        $akhir2 = $akhir. " 23:59:59";
        

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
            <td>: <b><?php echo $mulai." - ". $akhir ?></b></td>
        </tr>
        
        
    </table>

    

    <p style="text-align:center;font-size:18px;">
    <b><u>Laporan Data Sampah</u></b>  
    </p>
    
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover table-bordered" style="font-size:15px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;" width="30px;">No</th>
                                <th style="text-align:center;">Tanggal</th>
                                <th style="text-align:center;">Jenis Sampah</th>
                                <th style="text-align:center;">Total Jumlah Terkumpul (Kg)</th>
                                <th style="text-align:center;">Total Harga Sampah</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT b.tanggal, d.nama_banjar, a.jenis_sampah, SUM(a.berat) AS totberat, SUM(subtotal) AS totsubtotal, c.id_banjar FROM tb_tabungan_sampah_detail a INNER JOIN tb_tabungan_sampah b ON a.kode_tabungan_sampah = b.kode INNER JOIN tb_nasabah c ON b.id_nasabah = c.id_nasabah INNER JOIN tb_banjar d ON c.id_banjar = d.id_banjar WHERE b.tanggal >= '". $mulai2 ."' AND b.tanggal <= '". $akhir2 ."' GROUP BY b.tanggal, a.id_jenis_sampah, c.id_banjar ORDER BY b.tanggal DESC, d.nama_banjar ASC"; 

                                $sql = mysqli_query($koneksi, $query); 
                                $no = 1;
                                $totberat = 0;
                                $totharga = 0;

                                while($data = mysqli_fetch_array($sql)){
                                echo "<tr>";
                                echo "<td style='text-align:center;'>".$no++."</td>";
                                echo "<td style='text-align:center;'>".date('d M Y', strtotime($data['tanggal']))."</td>";
                                echo "<td>".$data['jenis_sampah']."</td>";
                                echo "<td style='text-align:center;'>".$data['totberat']."</td>";
                                echo "<td style='text-align:right;'>".number_format($data['totsubtotal'])."</td>";
                                echo "</tr>";

                                $totberat += $data['totberat'];
                                $totharga += $data['totsubtotal'];
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:center;"><b>TOTAL</b></td>
                                <td style="text-align:center;"><b><?php echo $totberat; ?> Kg</b></td>
                                <td style="text-align:right;"><b>Rp. <?php echo number_format($totharga); ?></b></td>
                            </tr>
                        </tfoot>
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