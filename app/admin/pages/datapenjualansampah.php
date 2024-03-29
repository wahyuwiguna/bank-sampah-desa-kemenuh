<div class="page-header">
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Transaksi Penjualan Sampah</a></li>
        </ol>
    </nav>
    <div class="float-right">
        <a href="index.php?ref=tambahpenjualansampah.php" class="btn btn-primary btn-rounded btn-icon-text">
            <i data-feather="plus"></i>
            Baru
        </a>
    </div>
</div>

<div class="row layout-top-spacing" id="cancel-row">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table style-3 table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align:center;" width="30px;">No</th>
                        <th style="text-align:center;">Tanggal</th>
                        <th style="text-align:center;">Pengepul</th>
                        <th style="text-align:center;">Kode Penjualan</th>
                        <th style="text-align:center;">Total Berat (Kg)</th>
                        <th style="text-align:center;">Total Harga</th>
                        <th class="text-center dt-no-sorting">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT a.*, b.nama_pengepul FROM tb_penjualan a INNER JOIN tb_pengepul b ON a.id_pengepul = b.id_pengepul ORDER BY a.tanggal DESC";
                        $sql = mysqli_query($koneksi, $query); 
                        $no = 1;
                        while($data = mysqli_fetch_array($sql)){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>".$no++."</td>";
                        echo "<td style='text-align:center;'>".date('d M Y', strtotime($data['tanggal']))."</td>";
                        echo "<td>".$data['nama_pengepul']."</td>";
                        ?>
                            <td class="text-center">
                                <a href="#" class="open_modal_detail" id="<?php echo $data['id_penjualan']; ?>" style="color:blue;"><?php echo $data['kode']; ?></a>
                            </td>  
                            
                        <?php
                        echo "<td style='text-align:center;'>".$data['total_berat']."</td>";
                        echo "<td style='text-align:right;'>".number_format($data['total_harga'])."</td>";
                        ?>
                            <td class="text-center">
                                <a href="index.php?ref=ubahpenjualansampah.php&id=<?php echo $data['id_penjualan']; ?>"  class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah"><i data-feather="edit-3"></i></a>
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
        $(".open_modal_detail").click(function(e) {
            var m = $(this).attr("id");
            $.ajax({
            url: "Pages/detailpenjualansampah.php",
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