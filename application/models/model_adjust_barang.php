<?php  
 class Model_adjust_barang extends CI_Model  
 {  
  /*variable datatables*/
  var $table = "temp_adjust_barang";  
  //var $select_column = array("kode_barang", "nama_barang","qty","bonus","id_karyawan");  
  var $order_column = array("kode_barang", "nama_barang", "satuan"," kode_supp","harga_beli","jumlah","nilai_adjust","id_karyawan");
  /*function get data from database*/  
  public function make_query()  
  {  
    $this->db->select('*');  
    $this->db->from($this->table);
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

   /*get item info*/
  public function get_item_info()  
  {
    $kode_barang   = trim($this->input->post('kode_barang'));
    $this->db->select('*');  
    $this->db->from('master_barang');
    $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
    $this->db->where('kode_barang', $kode_barang);
    $query = $this->db->get();  
    return $query;
  }

    //get slip_no 
  public  function get_no_slip(){ 
    //no bill table penjualan  
     return $get_data   = $this->db->query("SELECT seq FROM `tbl_adjust` where tanggal='".date('Y-m-d')."' order by id desc limit 1 ");
  }

  //insert ke table temp_beli_barang
  public function insert_tmp_adjust_barang($data){
    $kode_barang  = $this->input->post('kode_barang');
    $hsl = $this->db->query("SELECT * FROM temp_adjust_barang WHERE kode_barang='$kode_barang' and id_karyawan='".$this->session->userdata('id_karyawan')."'");
    $cek_barang = $this->db->query("SELECT kode_barang FROM master_barang WHERE kode_barang='$kode_barang' ");

    if ($hsl->num_rows()>0) {
      return 1;
      return false;
    }
    else if ($cek_barang->num_rows()==0) {
      return 2;
      return false;
    }
    else {
      $this->db->insert('temp_adjust_barang',$data);
    }   
  }

  //sum_nilai_adjust untuk footer datatable
  public function sum_nilai_adjust()  
  {
    return $get_data   = $this->db->query("SELECT sum(nilai_adjust) as nilai_adjust FROM temp_adjust_barang where id_karyawan='".$this->session->userdata('id_karyawan')."'");
  }

  //hapus barang
  public function delete_product(){   
    $kode_barang  = $this->input->post('kode_barang');
    $this->db->where(array('kode_barang' => $kode_barang,'id_karyawan' => $this->session->userdata('id_karyawan')));  
    $this->db->delete("temp_adjust_barang");  
  }

  //hapus isi tbl_temp_adjust
  public function clear_temp_adjust_barang(){
    $this->db->where(array('id_karyawan' => $this->session->userdata('id_karyawan')));  
    $this->db->delete("temp_adjust_barang");
  }

  //get no retur   
  public  function get_no_adjust()  
  { 
    return $get_data   = $this->db->query("SELECT max(seq) as seq_no_adjust FROM tbl_adjust ");
  }

  //ambil data dari tbl_temp_adjust untuk dimasukkan ke tbl_adjust 
  public function get_adjust()  
  {
    return $get_data   = $this->db->query("SELECT sum(nilai_adjust)as nilai_adjust,kode_supp as kode_supp FROM `temp_adjust_barang` where id_karyawan ='".$this->session->userdata('id_karyawan')."'");
  }

  //ambil data dari tbl_temp_adjust untuk dimasukkan ke tbl_det_adjust 
  public function get_det_adjust()  
  {
    return $get_data   = $this->db->query("SELECT * FROM temp_adjust_barang where  id_karyawan='".$this->session->userdata('id_karyawan')."' AND kode_barang !='' ");
  }

  //insert ke tbl_adjust
  public  function ins_adjust($data_adjust)  
  { 
    $this->db->insert('tbl_adjust',$data_adjust);
  }

  //insert ke tbl_det_adjust
  public  function ins_det_adjust($data_det_adjust)  
  { 
    $this->db->insert('tbl_det_adjust',$data_det_adjust);
  }

  //update stock
  public function update_stock(){
    $get_data     = $this->db->query("SELECT * FROM temp_adjust_barang where id_karyawan='".$this->session->userdata('id_karyawan')."'");
    $result =  $get_data->result();
    foreach ($result as $data) {
      $kode_barang = $data->kode_barang;
      $jumlah      = $data->jumlah;
      $this->db->set('book_stock','book_stock'.'-'. $jumlah, FALSE);
      $this->db->set('sales_stock','sales_stock'.'-'. $jumlah, FALSE);
      $this->db->set('adjust','adjust'.'+'. $jumlah, FALSE);
      $this->db->where(array('kode_barang' => $kode_barang));
      $result=$this->db->update('master_barang');
    }
  }




}  