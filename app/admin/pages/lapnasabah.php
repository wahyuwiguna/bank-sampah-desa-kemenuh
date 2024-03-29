<?php
    $banjar = $_GET['banjar'];
    // $mulai = $_GET['mulai'];
    // $akhir = $_GET['akhir'];


    // $mulai2 = $mulai. " 00:00:00";
    // $akhir2 = $akhir. " 23:59:59";

   
?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Laporan</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Laporan Data Nasabah</a></li>
        </ol>
    </nav>
</div>


<br>

<div class="row">
    <div class="col-xl-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header" style="padding:0px 0px;">  
                <div class="col-12" style="padding:0px 0px 10px 0px;">
                    <form method="POST" action="proses/tampilkanlapkas.php" class="form-inline">
                
                        <div class="input-group mb-2 mr-sm-2">
                            <select class="selectpicker form-control" id="banjarutama">
                                <option value="all" <?php if($banjar == "all"){ echo "selected";} ?>>Semua Banjar</option>
                                <?php 
                                $query_k = "SELECT * FROM tb_banjar ORDER BY nama_banjar ASC";
                                $sql_k = mysqli_query($koneksi, $query_k); 
                            
                                while($data_kat = mysqli_fetch_array($sql_k)){
                                ?>
                                    <option value="<?php echo $data_kat['id_banjar']; ?>" <?php if ($data_kat['id_banjar'] == $banjar ) { echo "selected"; } ?>> <?php  echo $data_kat['nama_banjar']; ?> </option>;
                                <?php
                                }

                                ?>
                            </select>
                        </div>
            
                        <!-- <button type="submit" class="btn btn-primary btn-rounded btn-icon-text" id="tampilkan" style="margin-bottom:10px;">
                            <i data-feather="refresh-cw"></i>
                            Tampilkan
                        </button> -->

                        <div class="float-right">
                        <a href="pages/cetaklapnasabah.php?banjar=<?php echo $banjar; ?>" class="btn btn-success btn-rounded btn-icon-text" style="margin-bottom:10px;" target="_blank">
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
                                <th style="text-align:center;">NIK</th>
                                <th style="text-align:center;">Rekening</th>
                                <th style="text-align:center;">Nama</th>
                                <th style="text-align:center;">No Telp</th>
                                <th style="text-align:center;">Banjar</th>
                                <th style="text-align:center;">Status</th> 
                                <th style="text-align:center;">Saldo</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($banjar == "all"){   
                                    $query = "SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar ORDER BY b.nama_banjar, a.id_nasabah ASC"; 
                                }else{
                                    $query = "SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar WHERE a.id_banjar = '". $banjar ."' ORDER BY b.nama_banjar, a.id_nasabah ASC"; 
                                }

                                
                                $sql = mysqli_query($koneksi, $query); 
                                $no = 1;
                                $jml_nasabah = 0;
                                $jml_saldo = 0;

                                while($data = mysqli_fetch_array($sql)){
                                    echo "<tr>";
                                    echo "<td style='text-align:center;'>".$no++."</td>";
                                    echo "<td style='text-align:center;'>".$data['NIK']."</td>";
                                    echo "<td>".$data['no_rekening']."</td>";
                                    echo "<td>".$data['nama_nasabah']."</td>";
                                    echo "<td>".$data['no_telp']."</td>";
                                    echo "<td>".$data['nama_banjar']."</td>";
                                    if ($data['status']=='Aktif') {
                                        echo "<td style='text-align:center;'><span class='badge bg-success'>Aktif</span></td>";
                                    }elseif ($data['status']=='TidakAktif') {
                                        echo "<td style='text-align:center;'><span class='badge bg-danger'>Non-Aktif</span></td>";
                                    }elseif ($data['status']=='Validasi') {
                                        echo "<td style='text-align:center;'><span class='badge bg-warning'>Validasi</span></td>";
                                    }
                                    echo "<td style='text-align:right;'><b>".number_format($data['saldo'])."</b></td>";
                                    echo "</tr>";

                                    $jml_nasabah += 1;
                                    $jml_saldo += $data['saldo'];

                                }
                            ?>
                        
                    
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align:center;"><b>TOTAL</b></td>
                                <td colspan="2" style="text-align:center;"><b><?php echo number_format($jml_nasabah); ?> Nasabah</b></td>
                                <td colspan="2" style="text-align:right;"><b>Rp. <?php echo number_format($jml_saldo); ?></b></td>
                                
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
        $('#banjarutama').change(function(){
            var banjar = $(this).val();
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);
            url.searchParams.set("banjar", banjar); // setting your param
            var newUrl = url.href; 

            window.location.href = newUrl;
        })
       
    });
</script>


