<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class skpd_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model('admin/user_operation_model');
	}
	
	public function record_count() {
		return $this->db->count_all("skpd_tbl");
	}
	
	public function fetchAll($limit, $start) {
		$this->db->select ('*');
		$this->db->from ('skpd_tbl');
		$this->db->limit ($limit, $start);
		$query = $this->db->get ();
		if ($query->num_rows()> 0) {
			foreach ( $query->result () as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function isEksis($kd_skpd){
		$this->db->select('1');
		$this->db->from('skpd_tbl');
		$this->db->where('kd_skpd',$kd_skpd);
		$query = $this->db->get();
		if($query->num_rows()!=0){
			return true;
		}else{
			return false;
		}
	}
	
	public function fetchById($id){
		$this->db->select ('*');
		$this->db->from ('skpd_tbl');
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->kd_skpd = $data['kd_skpd'];
		$this->nama = $data['nama'];
		
		// insert data
		if($this->db->insert('skpd_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->nama = $data['nama'];;
		
		// update data
		if($this->db->update ('skpd_tbl', $this, array ('kd_skpd' => $data['kd_skpd']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id) {
		if($this->db->delete ('skpd_tbl', array ('kd_skpd' => $id))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('skpd_tbl');
	}
	
	public function getName($kd_skpd){
		if($kd_skpd!=null){
			$this->db->select('nama');
			$this->db->from('skpd_tbl');
			$this->db->where('kd_skpd',$kd_skpd);
			$query= $this->db->get();
			$ret = $query->row();
			return $ret->nama;
		}else{
			return "Belum Terdaftar";
		}
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('*');
		$this->db->from ('skpd_tbl');
		$this->db->like($column,$value);
		$this->db->limit ($limit, $start);
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getAktifitas($nip, $tgl_kegiatan){
		
		$this->db->select('ut.uraian_tupoksi, ut.jenis_tupoksi, k.tgl_kegiatan, k.uraian_kegiatan,k.qid');
		$this->db->from('kegiatan_tbl k');
		$this->db->join('uraian_tupoksi_tbl ut','k.kd_skpd = ut.kd_skpd AND k.kd_position = ut.kd_position AND k.kd_tupoksi = ut.id_tupoksi AND k.kd_uraian = ut.id_uraian');
		$this->db->where('k.nip',$nip);
		$this->db->where('k.tgl_kegiatan',$tgl_kegiatan);
		$this->db->order_by('ut.jenis_tupoksi,k.tgl_kegiatan');
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getUraianTupoksi($kd_skpd,$kd_position){
		
		$this->db->select('ut.id_uraian,ut.uraian_tupoksi,ut.id_tupoksi');
		$this->db->from('uraian_tupoksi_tbl ut');
		$this->db->where('ut.kd_skpd',$kd_skpd);
		$this->db->where('ut.kd_position',$kd_position);
		$this->db->where('ut.aktif','Y');
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
}