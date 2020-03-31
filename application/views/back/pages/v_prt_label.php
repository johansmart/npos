
<?php
$kolom = 5;
$i = 0;
//jumlah data
$row = $baris;

echo '<table '.($row>=5? 'width="100%"' : ($row==4? 'width="80%"' : ($row==3 ? 'width="60%"' : ($row==2 ? 'width="40%"' : 'width="20%"')))).'>
<tbody>';
foreach($print_label as $p){
    if ($i >= $kolom) {
        echo '<tr></tr>';
        $i = 0;
    }
    $i++;
?>
<td wrap>
    <p style="font-size: 10px"><?php echo substr($p->nama_barang, 0, 32); ?></p>
    <p id="price"><?php echo 'Rp. '. number_format($p->harga_brg)?></p>
    <p id="barcode"><?php echo "*".$p->kode_barang."*"?></p>
    
    <p id="code"><?php echo $p->kode_barang?></p>
    <p id="cat"><?php echo $p->kategori?></p>
    <p id="tgl"><?php echo date('d-m-y')?></p>
</td>
<?php
}
?>
</tbody>
</table>

<style type="text/css">
 @font-face {
  font-family: '3OF9_NEW';
  src: url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/3OF9_NEW.ttf');
  src: url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/3OF9_NEW.ttf') format('ttf'),
       url('<?php echo base_url('assets/template/backend/') ?>bower_components/fonts/3OF9_NEW.ttf') format('truetype');
  }
  
  #price{
    font-size: 25px;
    margin-top: -5px
  }
  #barcode{
    font-family: '3OF9_NEW';
    font-size: 20px;
    margin-top: -5px;
  }
  #code{
    font-size: 10px;
    margin-top: -15px
  }
  #tgl{
    font-size: 10px;
    margin-top: -5px
  }
  #cat{
    font-size: 10px;
    margin-top: -5px
  }
 td {
  border: 0.5px solid black;
  text-align: center;
}
</style>