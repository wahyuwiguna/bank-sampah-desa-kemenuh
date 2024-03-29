<?php
    include "../../koneksi.php";
    $id=$_GET['id'];
    $modal=mysqli_query($koneksi,"SELECT a.*, b.*, c.nama_banjar FROM tb_tabungan_sampah a INNER JOIN tb_nasabah b ON a.id_nasabah = b.id_nasabah INNER JOIN tb_banjar c ON b.id_banjar = c.id_banjar WHERE a.id_tabungan_sampah='$id' LIMIT 1");
    $data = mysqli_fetch_array($modal);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Tabungan Sampah | <?php echo $data['kode']; ?></h5>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-8">
                    <table>
                        <tr>
                            <td style="width:150px;padding:3px;">Kode Transaksi</td>
                            <td><b><?php echo $data['kode']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="width:150px;padding:3px;">Tanggal</td>
                            <td><b><?php echo date('d M Y', strtotime($data['tanggal'])); ?></b></td>
                        </tr>
                        <tr>
                            <td style="width:150px;padding:3px;">No Rekening</td>
                            <td><b><?php echo $data['no_rekening']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="width:150px;padding:3px;">Nasabah</td>
                            <td><b><?php echo $data['NIK']; ?> - <?php echo $data['nama_nasabah']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="width:150px;padding:3px;">Alamat</td>
                            <td><b><?php echo $data['alamat']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="width:150px;padding:3px;">No Telp</td>
                            <td><b><?php echo $data['no_telp']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="width:150px;padding:3px;">Banjar</td>
                            <td><b><?php echo $data['nama_banjar']; ?></b></td>
                        </tr>
                    </table>
                </div>    

                <div class="col-4">
                    <div class="form-group form-group-default" style="text-align:right;">
                        <label>Grand Total</label>
                        <h1 style="font-size:25px;">Rp. <?php echo number_format($data['total_harga']); ?></h1>
                    </div>
                    <div class="form-group form-group-default" style="text-align:right;">
                        <label>Total Berat</label>
                        <h1 style="font-size:25px;"><?php echo $data['total_berat']; ?> Kg</h1>
                    </div>
                </div>
           </div>
           <br>
           <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Jenis Sampah</th>
                                    <th class="text-center">Harga /Kg</th>
                                    <th class="text-center">Berat (Kg)</th>
                                    <th class="text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query2 = "SELECT * FROM tb_tabungan_sampah_detail WHERE kode_tabungan_sampah = '". $data['kode'] ."' ORDER BY jenis_sampah DESC"; 
                                    $sql2 = mysqli_query($koneksi, $query2); 
                                    $no = 1;
                                    while($data2 = mysqli_fetch_array($sql2)){
                                    echo "<tr>";
                                    echo "<td style='text-align:center;'>".$no++."</td>";
                                    echo "<td>".$data2['jenis_sampah']."</td>";
                                    echo "<td style='text-align:right;'>".number_format($data2['harga'])."</td>";
                                    echo "<td style='text-align:center;'>".$data2['berat']."</td>";
                                    echo "<td style='text-align:right;'>".number_format($data2['subtotal'])."</td>";
                                    echo "</tr>";
                                    }
                                ?>
                            
                        
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>    

        </div>
        <div class="modal-footer">
            <button class="btn btn-rounded" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Tutup</button>
        </div>
    </div>
</div>