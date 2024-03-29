<?php
    $nasabah = $_SESSION['id_nasabah'];
    
?>

<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Transaksi Tabungan Sampah</a></li>
        </ol>
    </nav>
    
</div>

<div class="row layout-top-spacing" id="cancel-row">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
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
                        <!-- <th class="text-center dt-no-sorting">Aksi</th>  -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT a.*, b.no_rekening, b.nama_nasabah, b.NIK FROM tb_tabungan_sampah a INNER JOIN tb_nasabah b ON a.id_nasabah = b.id_nasabah WHERE a.id_nasabah = ". $nasabah ." ORDER BY a.kode DESC"; 
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