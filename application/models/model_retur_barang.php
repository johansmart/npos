<?php  
 class Model_retur_barang extends CI_Model  
 {  
  /*variable datatables*/
  var $table = "temp_retur";  
  var $select_column = array("temp_retur.no_nota","temp_retur.kode_barang","master_barang.nama_barang","satuan.satuan","master_barang.kode_supp","temp_retur.harga_beli","temp_retur.jumlah","temp_retur.total_harga_beli","temp_retur.id_karyawan");  
  var $order_column = array("no_nota","kode_barang","nama_barang","satuan","kode_supp","harga_beli","jumlah","total_harga_beli","id_karyawan");
  /*function get data from database*/  
  public function make_query()  
  {  
    $this->db->select($this->select_column);  
    $this->db->from($this->table);
    $this->db->join('master_barang', 'temp_retur.kode_barang = master_barang.kode_barang', 'left');
    $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
    $this->db->where(array('id_karyawan' => $this->session->userdata('id_karyawan'))); 
    if(isset($_POST["order"]))  
    {  
        $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
    }  
  }
  /*function datatables*/
  public function make_datatables(){  
       $this->make_query();  
       if($_POST["length"] != -1)  
       {  
          $this->db->limit($_POST['length'], $_POST['start']);  
       }  
       $query = $this->db->get();  
       return $query->result();  
  }

  public function get_filtered_data(){  
       $this->make_query();  
       $query = $this->db->get();  
       return $query->num_rows();  
  }

  public function get_all_data(){  
       $this->db->select("*");  
       $this->db->from($this->table);  
       return $this->db->count_all_results();  
  }

  public function clear_temp_retur(){
      $this->db->where(array('id_karyawan' => $this->session->userdata('id_karyawan')));  
      $this->db->delete("temp_retur");
  }

  public function get_det_pembelian(){
      $no_nota  = $this->input->post('no_nota');
      $get_data  = $this->db->query(" SELECT * from tbl_det_pembelian where no_nota ='$no_nota'");
      return $get_data;
  }

  //insert temp retur
  public function insert_temp_retur($data){
        $this->db->insert('temp_retur',$data);
  }

  //update table temp_retur sebelum kirim
  public function update_send($data){  
    return $this->db->update_batch('temp_retur', $data, 'kode_barang');
  }

  /*ambil data table temp_retur untuk insert ke tbl_retur*/  
  public function get_retur(){  
    return $get_data   = $this->db->query("SELECT no_nota as no_nota,sum(nilai_retur)as nilai_retur FROM `temp_retur` where id_karyawan ='".$this->session->userdata('id_karyawan')."' AND alasan !='' AND jml_retur > 0 ");
  }

  /*ambil data table temp_retur untuk insert ke tbl_det_retur*/  
  public function get_det_retur(){  
    return $get_data   = $this->db->query("SELECT * FROM temp_retur where  id_karyawan='".$this->session->userdata('id_karyawan')."' AND alasan !='' AND jml_retur > 0 ");
  }

  //get no retur   
  public  function get_no_retur()  
  { 
    return $get_data   = $this->db->query("SELECT max(seq) as seq_no_retur FROM tbl_retur ");
  }

  //periksa jumlah retur lebih besar dari jumlah beli
  public function check_jml_retur(){
    return $get_data   = $this->db->query("SELECT jml_retur FROM `temp_retur` where jml_retur > jumlah AND id_karyawan='".$this->session->userdata('id_karyawan')."'");
  }

  //periksa jumlah retur lebih besar dari jumlah beli
  public function check_jml_bisa_retur(){
    return $get_data   = $this->db->query("SELECT jml_retur FROM `temp_retur` where jml_retur > jml_bisa_retur AND id_karyawan='".$this->session->userdata('id_karyawan')."'");
  }

  //ambil no_nota
  public function get_no_nota(){
    return $get_no_nota   = $this->db->query("SELECT no_nota as no_nota FROM `temp_retur` where id_karyawan='".$this->session->userdata('id_karyawan')."' limit 1");
  }

   //periksa jumlah retur yang sudah diretur
  public function check_jml_sdh_retur($no_nota){
    return $get_data   = $this->db->query("SELECT COALESCE(sum(jml_retur),0) as jml_retur FROM `tbl_det_retur` where no_nota='$no_nota' group by kode_barang");
  }

  //get slip_no 
  public  function get_no_slip(){ 
    //no bill table penjualan  
     return $get_data   = $this->db->query("SELECT seq as seq FROM `tbl_retur` where tanggal='".date('Y-m-d')."' order by id desc limit 1 ");
  }

  //insert temp retur
  public function insert_retur($data){
    $this->db->insert('tbl_retur',$data);
  }

  //insert tbl_det_retur
  public function insert_det_retur($data){
    $this->db->insert('tbl_det_retur',$data);
  }

  public function update_stock(){
    $get_data     = $this->db->query("SELECT * FROM temp_retur where id_karyawan='".$this->session->userdata('id_karyawan')."' AND alasan !='' AND jml_retur > 0 ");
    $result =  $get_data->result();
    foreach ($result as $data) {
      $kode_barang = $data->kode_barang;
      $jumlah      = $data->jml_retur;
      $this->db->set('book_stock','book_stock'.'-'. $jumlah, FALSE);
      $this->db->set('sales_stock','sales_stock'.'-'. $jumlah, FALSE);
      $this->db->set('retur','retur'.'+'. $jumlah, FALSE);
      $this->db->where(array('kode_barang' => $kode_barang));
      $result=$this->db->update('master_barang');
    }
  }





}  