<?php
    // $banjar = $_GET['banjar'];
    $mulai = $_GET['mulai'];
    $akhir = $_GET['akhir'];


    $mulai2 = $mulai. " 00:00:00";
    $akhir2 = $akhir. " 23:59:59";

   
?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Transaksi Tabungan Sampah</a></li>
        </ol>
    </nav>
    <div class="float-right">
        <a href="index.php?ref=tambahtabungansampah.php" class="btn btn-primary btn-rounded btn-icon-text">
            <i data-feather="plus"></i>
            Baru
        </a>
    </div>
</div>

<div class="row layout-top-spacing" id="cancel-row">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-header" style="padding:0px 0px;">  
            <div class="col-12" style="padding: 0px 0px 10px 0px;">
                <form method="POST" action="proses/tampilkantabungansampah.php" class="form-inline">
            
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Tanggal</div>
                        </div>
                        <input id="tanggal" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date.." style="color:black;width:270px;" >
                        <input type="hidden" name="TglMulai" id="ID_START" value="<?php echo $mulai; ?>">
                        <input type="hidden" name="TglSelesai" id="ID_END" value="<?php echo $akhir; ?>">
                    </div>
        
                    <button type="submit" class="btn btn-success btn-rounded btn-icon-text" id="tampilkan" style="margin-bottom:10px;">
                        <i data-feather="refresh-cw"></i>
                        Tampilkan
                    </button>
                    
                </form>
                
            </div>                              
            
        </div>
        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table style-3 table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align:center;" width="30px;">No</th>
                        <th style="text-align:center;">Tanggal</th>
                        <th style="text-align:center;">Transaksi</th>
                        <th style="text-align:center;">Rekening</th>
                        <th style="text-align:center;">Nasabah</th>
                        <th style="text-align:center;">Total Berat (Kg)</th>
                        <th style="text-align:center;">Total Harga</th>
                        <th class="text-center dt-no-sorting">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT a.*, b.no_rekening, b.nama_nasabah, b.NIK FROM tb_tabungan_sampah a INNER JOIN tb_nasabah b ON a.id_nasabah = b.id_nasabah WHERE a.tanggal >= '". $mulai2 ."' AND a.tanggal <= '". $akhir2 ."' ORDER BY a.kode DESC"; 
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        while($data = mysqli_fetch_array($sql)){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>".$no++."</td>";
                        echo "<td style='text-align:center;'>".date('d M Y', strtotime($data['tanggal']))."</td>";
                        ?>
                            <td class="text-center">
                                <a href="#" class="open_modal_detail" id="<?php echo $data['id_tabungan_sampah']; ?>" style="color:blue;"><?php echo $data['kode']; ?></a>
                            </td>  
                            
                        <?php
                        echo "<td>".$data['no_rekening']."</td>";
                        echo "<td>".$data['nama_nasabah']."</td>";
                        echo "<td style='text-align:center;'>".$data['total_berat']."</td>";
                        echo "<td style='text-align:right;'>".number_format($data['total_harga'])."</td>";
                        ?>
                            <td class="text-center">
                                <a href="index.php?ref=ubahtabungansampah.php&id=<?php echo $data['id_tabungan_sampah']; ?>"  class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah"><i data-feather="edit-3"></i></a>
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

<!-- MODAL EDIT -->
<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog" aria-hidden="true"></div>
<!-- MODAL EDIT -->

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

        $(".open_modal_detail").click(function(e) {
            var m = $(this).attr("id");
            $.ajax({
            url: "Pages/detailtabungansampah.php",
            type: "GET",
            data : {id: m,},
            success: function (ajaxData){
                    $("#ModalDetail").html(ajaxData);
                    $("#ModalDetail").modal('show',{backdrop: 'true'});
                }
            });
        });
        
    });
</script>