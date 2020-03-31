
<h2 class="page-header">
  <i class="fa fa-globe"></i> Faktur Pembelian Barang.
</h2>
<hr class="new1">

<b>Purchase No:</b> <?php echo $print_header['purc_no'];?><br>
<b>Tipe:</b> <?php echo $print_header['tipe_bayar'];?><br>
<b>Kode Supplier:</b> <?php echo $print_header['kode_supp'];?><br>
<b>Nama Supplier:</b> <?php echo $print_header['nama_supp'];?><br>
<b>Tanggal:</b> <?php echo $print_header['tanggal'];?><br>
<b>Userid:</b> <?php echo $print_header['id_karyawan'].'-'.$print_header['user_name'];?>
<hr class="new1">
<br>

<table style="width:100%;margin-top:-10px" class="table tbl-bordered" border="0">
<tr>
  <th>Kode Barang</th>
  <th>Nama Barang</th>
  <th>Harga Beli</th>
  <th>Jumlah</th>
  <th align="right">Subtotal</th>
</tr>

<?php foreach ($print_table as $table) {
  echo '
    <tr >
      <td>'.$table->kode_barang.'</td>
      <td>'.$table->nama_barang.'</td>
      <td>'.number_format($table->harga_beli).'</td>
      <td>'.number_format($table->jumlah).'</td>
      <td align="right">'.number_format($table->total_harga_beli).'</td>
    </tr>
    ';
   } 
?>
</table>

<hr class="new1">
<p align="right"><b>Total : <?php echo number_format($print_header['total_beli']);?></b></p>
<hr class="new1">
<p>Keterangan:</p>
<br><br><br><br>
<hr class="new1">
<p>Paraf:</p>
<br><br><br><br>
<hr class="new1">

<style type="text/css">
  @font-face {
  font-family: 'SourceSansPro-Regular';
  src: url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/SourceSansPro-Regular.ttf');
  src: url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/SourceSansPro-Regular.ttf') format('ttf'),
       url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/SourceSansPro-Regular.ttf') format('truetype');
  }
  body{
    font-family: 'SourceSansPro-Regular';
    font-weight: normal;
    font-size: 12px;
  }
  table {
  border-collapse: collapse;
  }

  /*th, td {
  border-bottom: 1px solid #ddd;
  }*/
  hr.new1 {
  border-top: 1px solid #8c8b8b;
  border-bottom: 1px solid #fff;
}
</style>