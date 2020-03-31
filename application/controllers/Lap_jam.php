<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_jam extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("model_lap_jam");
	}

	public function index()
	{
		$this->load->view('back/pages/v_lap_jam');
	}
	public function fetch_lap_jam(){  
	     $requestData = $_REQUEST;
	     $columns = array( 
		// datatable column index  => database column name
			0 =>'kategori', 
			1 => 'enam',
			2 => 'tujuh'
		);
	    /*create query for getting data*/ 
		$sql = "
		SELECT
		kategori.nama_kategori as kode_kategori
		,COALESCE(jm_enam,0) as enam
		,COALESCE(jm_tujuh,0) as tujuh
		,COALESCE(jm_delapan,0) as delapan
		,COALESCE(jm_sembilan,0) as sembilan
		,COALESCE(jm_sepuluh,0) as sepuluh
		,COALESCE(jm_sebelas,0) as sebelas
		,COALESCE(jm_duabelas,0) as duabelas
		,COALESCE(jm_tigabelas,0) as tigabelas
		,COALESCE(jm_empatbelas,0) as empatbelas
		,COALESCE(jm_limabelas,0) as limabelas
		,COALESCE(jm_enambelas,0) as enambelas
		,COALESCE(jm_tujuhbelas,0) as tujuhbelas
		,COALESCE(jm_delapanbelas,0) as delapanbelas
		,COALESCE(jm_sembilanbelas,0) as sembilanbelas
		,COALESCE(jm_duapuluh,0) as duapuluh
		,COALESCE(jm_duasatu,0) as duasatu
		,COALESCE(jm_duadua,0) as duadua
		";

		$sql.="
		FROM kategori 
		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_enam
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='06:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as enam ON kategori.kode_kategori=enam.kode_kategori 

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_tujuh
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='07:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as tujuh ON kategori.kode_kategori=tujuh.kode_kategori

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_delapan
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='08:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as delapan ON kategori.kode_kategori=delapan.kode_kategori  

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_sembilan
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='09:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as sembilan ON kategori.kode_kategori=sembilan.kode_kategori  

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_sepuluh
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='10:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as sepuluh ON kategori.kode_kategori=sepuluh.kode_kategori  

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_sebelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='11:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as sebelas ON kategori.kode_kategori=sebelas.kode_kategori  

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_duabelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='12:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as duabelas ON kategori.kode_kategori=duabelas.kode_kategori  

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_tigabelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='13:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as tigabelas ON kategori.kode_kategori=tigabelas.kode_kategori 

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_empatbelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='14:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as empatbelas ON kategori.kode_kategori=empatbelas.kode_kategori   

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_limabelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='15:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as limabelas ON kategori.kode_kategori=limabelas.kode_kategori 

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_enambelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='16:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as enambelas ON kategori.kode_kategori=enambelas.kode_kategori 

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_tujuhbelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='17:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as tujuhbelas ON kategori.kode_kategori=tujuhbelas.kode_kategori 

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_delapanbelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='18:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as delapanbelas ON kategori.kode_kategori=delapanbelas.kode_kategori

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_sembilanbelas
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='19:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as sembilanbelas ON kategori.kode_kategori=sembilanbelas.kode_kategori

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_duapuluh
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='20:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as duapuluh ON kategori.kode_kategori=duapuluh.kode_kategori

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_duasatu
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='21:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as duasatu ON kategori.kode_kategori=duasatu.kode_kategori

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_duadua
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='22:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as duadua ON kategori.kode_kategori=duadua.kode_kategori

		left JOIN 
		(SELECT kategori.kode_kategori, sum(COALESCE(tbl_det_penjualan.total,0))AS jm_duatiga
		FROM 
		kategori, tbl_det_penjualan WHERE kategori.kode_kategori=tbl_det_penjualan.kode_kategori and tbl_det_penjualan.tanggal='".$_POST["start_date"]."' and left_time='23:00:00'
		GROUP BY tbl_det_penjualan.kode_kategori ASC ) as duatiga ON kategori.kode_kategori=duatiga.kode_kategori
		";

		  
	    $query = $this->model_lap_jam->query($sql);
		$totalData = count($query);
		$totalFiltered = $totalData;

		/*define colum for searching*/
		if(!empty($requestData['search']['value']) ) { 
		$sql.=" where kategori.kode_kategori LIKE '".$requestData['search']['value']."%' ";
		}

		//$sql.="GROUP BY kategori WITH ROLLUP";


		$query = $this->model_lap_jam->query($sql);
		$totalData = count($query);
		$totalFiltered = $totalData;

		/*ordering clause // by default 0th colum asc*/
		/*$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";*/

		$data = array();
		foreach ($query as $row) {
			$nestedData=array(); 
			$nestedData[] = $row["kode_kategori"];
			$nestedData[] = number_format($row["enam"]);
			$nestedData[] = number_format($row["tujuh"]);
			$nestedData[] = number_format($row["delapan"]);
			$nestedData[] = number_format($row["sembilan"]);
			$nestedData[] = number_format($row["sepuluh"]);
			$nestedData[] = number_format($row["sebelas"]);
			$nestedData[] = number_format($row["duabelas"]);
			$nestedData[] = number_format($row["tigabelas"]);
			$nestedData[] = number_format($row["empatbelas"]);
			$nestedData[] = number_format($row["limabelas"]);
			$nestedData[] = number_format($row["enambelas"]);
			$nestedData[] = number_format($row["tujuhbelas"]);
			$nestedData[] = number_format($row["delapanbelas"]);
			$nestedData[] = number_format($row["sembilanbelas"]);
			$nestedData[] = number_format($row["duapuluh"]);
			$nestedData[] = number_format($row["duasatu"]);
			$nestedData[] = number_format($row["duadua"]);
			$data[] = $nestedData;
		}

		/*create json in datatable from*/
		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);
			echo json_encode($json_data); 
	}


}
