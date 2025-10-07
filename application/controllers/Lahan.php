<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Lahan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Lahan_m');
	}
	public function index()
	{
		$data = array(
			'title'    => 'Data Lahan',
			'desa'	 =>  $this->Lahan_m->data_desa(),
			'kecamatan'	 =>  $this->Lahan_m->data_kecamatan(),
			'kota'	 =>  $this->Lahan_m->data_kota()

			
			
			
		);
		$this->load->view('Lahan/item/index', $data);
	}

	public function LoadData()
	{
		// Ambil data untuk tabel
    $results = $this->Lahan_m->getAllData();
    $data = [];
    foreach ($results as $res) {
        $row = array();
        
        $row['lahan_no']     = $res->lahan_no;
        $row['village']      = $res->village;
        $row['farmer_temp'] = $res->farmer_temp;
        $row['planting_area']      = $res->planting_area;
        $row['land_area']     = $res->land_area;
        $data[] = $row;
    }

    // Ambil data hitungan yang sudah difilter
    $filtered_counts = $this->Lahan_m->get_filtered_counts();

    $output = array(
        "draw" => $this->input->post('draw'),
        "recordsTotal" => $this->Lahan_m->count_all(),
        "recordsFiltered" => $this->Lahan_m->count_filtered(),
        "data" => $data,
        // Tambahkan data hitungan di sini
        "totalLahan" => $filtered_counts['total_lahan'],
        "totalPetani" => $filtered_counts['total_petani'],
    );
    
    echo json_encode($output);
	}
}
