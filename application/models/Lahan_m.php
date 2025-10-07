<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lahan_m extends CI_Model
{

    protected $table = 'lahangeko_2023';
    protected $primary = 'id';

private function _get_query()
    {
        $this->db->select('lahangeko_2023.*');
        $this->db->from($this->table);

        // Ambil nilai filter dari POST request yang dikirim JavaScript
        $filter_kota = $this->input->post('filter_kota');
        $filter_kecamatan = $this->input->post('filter_kecamatan');
        $filter_desa = $this->input->post('filter_desa');
        $filter_identifikasi = $this->input->post('filter_identifikasi');

        // Terapkan filter ke query jika ada nilainya
        if($filter_identifikasi){
            //$this->db->select('lahangeko_2023.*');
            //$this->db->from($this->table);
            $this->db->join('lahan_bhl','lahangeko_2023.lahan_no=lahan_bhl.kd_lahan');
            $this->db->where('lahangeko_2023.status',$filter_identifikasi);
        }
        if ($filter_kota) {
        $this->db->where('city', $filter_kota);
    }
    if ($filter_kecamatan) {
        $this->db->where('kecamatan', $filter_kecamatan);
    }
    if ($filter_desa) {
        $this->db->where('village', $filter_desa);
    }

    }   

public function getAllData()
{
    $this->_get_query(); // Panggil query utama dengan filter
        
        // Terapkan pagination dari DataTables
        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }

        $query = $this->db->get();
        return $query->result();
}
public function count_filtered()
    {
        $this->_get_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Menghitung total semua data di tabel TANPA filter.
     * Digunakan untuk informasi "(filtered from 100 total entries)".
     */
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function get_filtered_counts()
    {
        // Panggil query yang sama untuk menerapkan JOIN dan WHERE clause
        $this->_get_query();

        // Ubah SELECT untuk melakukan dua jenis COUNT sekaligus
        $this->db->select('
            COUNT(*) as total_lahan, 
            COUNT(DISTINCT farmer_no) as total_petani
        ');
        
        // Dapatkan hasilnya sebagai satu baris objek
        $result = $this->db->get()->row();

        // Kembalikan hasilnya dalam bentuk array agar mudah diakses di controller
        return [
            'total_lahan' => $result->total_lahan,
            'total_petani' => $result->total_petani
        ];
    }

   public function data_desa()
   {
        $sql="select village from $this->table group by village";
        return $this->db->query($sql)->result();
    }
   
   public function data_kecamatan()
   {
        $sql="select kecamatan from $this->table group by kecamatan";
        return $this->db->query($sql)->result();
    }
   
   public function data_kota()
   {
        $sql="select city from $this->table group by city";
        return $this->db->query($sql)->result();
   }

}
