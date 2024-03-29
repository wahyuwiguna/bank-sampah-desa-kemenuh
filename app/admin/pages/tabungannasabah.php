<?php
    $banjar = $_GET['banjar'];
?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Tabungan Nasabah</a></li>
        </ol>
    </nav>
    <div class="float-right">
        <div class="row mb-3">
            <label for="nohp" class="col-sm-3 col-form-label" style="padding-top:15px;">Banjar</label>
            <div class="col-sm-9">
                <select class="selectpicker form-control" id="banjarutama">
                    <option value="all" <?php if($banjar == "all"){ echo "selected";} ?>>Semua</option>
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
        </div>
    </div>
</div>

<div class="row layout-top-spacing" id="cancel-row">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table style-3 table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align:center;">NIK</th>
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
                       if($banjar == "all"){   
                            $query = "SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar ORDER BY a.id_nasabah DESC"; 
                        }else{
                            $query = "SELECT a.*, b.nama_banjar FROM tb_nasabah a INNER JOIN tb_banjar b ON a.id_banjar = b.id_banjar WHERE a.id_banjar = '". $banjar ."' ORDER BY a.id_nasabah DESC"; 
                        }
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        while($data = mysqli_fetch_array($sql)){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>".$data['NIK']."</td>";
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
                            <a href="index.php?ref=detailtabungannasabah.php&id=<?php echo $data['id_nasabah']; ?>"  class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Detail" data-original-title="Detail"><i data-feather="external-link"></i></a>
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