<?php
/*initialize escPos*/
require __DIR__ . '/print/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// Enter the share name for your USB printer here
//$connector = new WindowsPrintConnector("Receipt Printer");

defined('BASEPATH') OR exit('No direct script access allowed');
class Daftar_kendaraan extends CI_Controller {
	function __construct(){
		parent::__construct();
			/*if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}*/
	}

	public function index(){
		$this->load->view('back/pages/v_daftar_kendaraan');
	}

	public function fetch_daftar_kendaraan(){  
	     $this->load->model("daftar_kendaraan_model");  
	     $fetch_data = $this->daftar_kendaraan_model->make_datatables();  
	     $data = array();
	     foreach($fetch_data as $row)  
	     {  
	          $sub_array = array();
	          $sub_array[] = $row->id;
	          $sub_array[] = $row->no_polisi;  
	          $sub_array[] = $row->jenis_kendaraan;
	          $sub_array[] = $row->tanggal;
	          $sub_array[] = $row->waktu_masuk;  
	          $sub_array[] = $row->waktu_keluar;
	          $sub_array[] = $row->jumlah_helm;
	          $sub_array[] = $row->status;
	          $sub_array[] = '<button type="button" name="delete" id="delete" data-id="'.$row->id.'" class="btn btn-flat btn-xs bg-orange '.($row->status =='KELUAR' ? 'disabled' : '').'"><i class="ion ion-close-round"></i></button>';
	          $data[] = $sub_array;  
	     }  
	     $output = array(  
	          "draw"            => intval($_POST["draw"]),  
	          "recordsTotal"    => $this->daftar_kendaraan_model->get_all_data(),  
	          "recordsFiltered" => $this->daftar_kendaraan_model->get_filtered_data(),  
	          "data"            => $data  
	     );  
	     echo json_encode($output);  
	    }

	public  function insert_kendaraan(){
      	$insert_data = array(
	  		'no_polisi'     	=> strtoupper($this->input->post("no_polisi")),
	  		'jenis_kendaraan' 	=> $this->input->post("jenis_kendaraan"),
	  		'tanggal'  			=> date("Y-m-d"),
	  		'left_date' 		=> date('d'),
	  		'jam' 				=> date('H:00:00'),
	  		'waktu_masuk'     	=> date("h:i:sa"),
	  		'waktu_keluar'     	=> $this->input->post("jam_keluar"),
	  		'jumlah_helm'     	=> $this->input->post("jumlah_helm"),
	  		'status'     		=> $this->input->post("status"),  
	       	'user_id'   		=> $this->session->userdata('user_id'),  
	       	'user_name' 		=> $this->session->userdata('user_name')
	       	
      );
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->insert_kendaraan_masuk($insert_data);
	  echo json_encode($data);
	  $data_print 		= $this->daftar_kendaraan_model->getdata_print();
	  $id_kendaraan 	= $data_print ['id'];
	  $no_polisi 		= $data_print ['no_polisi'];
	  $waktu_masuk 		= $data_print ['waktu_masuk'];
	  $tanggal 			= date('d-m-Y', strtotime($data_print ['tanggal']));
	  $jenis_kendaraan 	= $data_print ['jenis_kendaraan'];
	  $jumlah_helm 		= $data_print ['jumlah_helm'];
	  $user_name 		= $data_print ['user_name'];


	  $connector = new WindowsPrintConnector("Receipt Printer");
	  $printer = new Printer($connector);

		$date = date('j-m-Y H:i:s');

		$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("LOTTE GROSIR\n");
		$printer -> selectPrintMode();
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("Store 13 Makassar\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("KARCIS PARKIR ".$jenis_kendaraan.' ( GRATIS )'."\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("WAKTU   : ".$tanggal.' : '.$waktu_masuk."\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("PETUGAS : ".$user_name."\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("******************************\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("ID_KENDARAAN : ".$id_kendaraan."\n");
		$printer -> text("NO_POLISI    : ".$no_polisi."\n");
		if ($jenis_kendaraan=='MOTOR') {
			$printer -> text("JUMLAH_HELM  : ".$jumlah_helm."\n");
		}
		$printer -> selectPrintMode();
		$printer -> text("******************************\n");
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$printer -> text("PERHATIAN\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("Lotte Grosir tidak bertanggung\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("jawab atas kerusakan dan kehil\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("angan kendaraan atau barang da\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("lam kendaraan anda\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("******************************\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("Visit : www.lottegrosir.co.id\n");								
		$printer -> feed();
		$printer -> cut();
		$printer -> close();

   	}
   	/*begin notification*/
   	public  function label_notif_masuk(){
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->label_notif_masuk();
	  echo json_encode($data);
   	}

   	public  function label_notif_keluar(){
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->label_notif_keluar();
	  echo json_encode($data);
   	}

   	public  function content_notif_total(){
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->content_notif_total();
	  echo json_encode($data);
   	}

   	public  function content_notif_motor(){
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->content_notif_motor();
	  echo json_encode($data);
   	}

   	public  function content_notif_mobil(){
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->content_notif_mobil();
	  echo json_encode($data);
   	}
   	/*end notification*/

   	public function get_no_polisi(){
	    $this->load->model("daftar_kendaraan_model");
	    $id_kendaraan 		= $this->input->post('id_kendaraan'); 
	    $data 				= $this->daftar_kendaraan_model->get_no_polisi($id_kendaraan);
	    $get_no_polisi 		= $data['no_polisi'];
	    echo $get_no_polisi;
	}
	public function get_jenis_kendaraan(){
	    $this->load->model("daftar_kendaraan_model");
	    $id_kendaraan 				=$this->input->post('id_kendaraan'); 
	    $data 						= $this->daftar_kendaraan_model->get_jenis_kendaraan($id_kendaraan);
	    $get_jenis_kendaraan 		= $data['jenis_kendaraan'];
	    echo $get_jenis_kendaraan;
	}
	public function get_waktu_masuk(){
	    $this->load->model("daftar_kendaraan_model");
	    $id_kendaraan 			= $this->input->post('id_kendaraan'); 
	    $data 					= $this->daftar_kendaraan_model->get_waktu_masuk($id_kendaraan);
	    $get_waktu_masuk 		= $data['waktu_masuk'];
	    echo $get_waktu_masuk;
	}


   	public  function insert_kendaraan_keluar(){
   		$this->load->model('daftar_kendaraan_model'); 
		$data_post 			= $this->daftar_kendaraan_model->getdata_post_insert_keluar();
		$no_polisi 			= $data_post ['no_polisi'];
		$jenis_kendaraan 	= $data_post ['jenis_kendaraan'];
		$waktu_masuk 		= $data_post ['waktu_masuk'];
   		$dteStart 			= new DateTime($waktu_masuk);
		$dteEnd   			= new DateTime(date("h:i:sa"));
		$dteDiff  			= $dteStart->diff($dteEnd); 
      	$insert_data = array(
      		'id_kendaraan' 		=> $this->input->post("id_kendaraan"),
	  		'no_polisi'     	=> $no_polisi,
	  		'jenis_kendaraan' 	=> $jenis_kendaraan,
	  		'tanggal'  			=> date("Y-m-d"),
	  		'waktu_masuk'     	=> $waktu_masuk,
	  		'waktu_keluar'     	=> date("h:i:sa"),
	  		'lama_parkir'     	=> $dteDiff->format("%H:%I:%S"),
	       	'user_id'   		=> $this->session->userdata('user_id'),  
	       	'user_name' 		=> $this->session->userdata('user_name')
      );
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->insert_kendaraan_keluar($insert_data);
	  echo json_encode($data);
   	}

   	public  function insert_tanpa_karcis(){
   		$this->load->model('daftar_kendaraan_model'); 
		$data_post 			= $this->daftar_kendaraan_model->getdata_post_insert_keluar();
		$no_polisi 			= $data_post ['no_polisi'];
		$jenis_kendaraan 	= $data_post ['jenis_kendaraan'];
		$waktu_masuk 		= $data_post ['waktu_masuk'];


      	$insert_data = array(
      		'id_kendaraan' 		=> $this->input->post("id_kendaraan"),
	  		'no_polisi'     	=> $no_polisi,
	  		'jenis_kendaraan' 	=> $jenis_kendaraan,
	  		'tanggal'  			=> date("Y-m-d"),
	  		'waktu_keluar'     	=> date("h:i:sa"),
	       	'user_id'   		=> $this->session->userdata('user_id'),  
	       	'user_name' 		=> $this->session->userdata('user_name'),
	       	'keterangan' 		=> $this->input->post("check_karcis"),
      );
      $this->load->model('daftar_kendaraan_model');  
	  $data = $this->daftar_kendaraan_model->insert_tanpa_karcis($insert_data);
	  echo json_encode($data);
   	}


   	public function delete_kendaraan(){  
       $this->load->model("daftar_kendaraan_model");  
       $this->daftar_kendaraan_model->delete_kendaraan();   
  	}

 

  




	
}
