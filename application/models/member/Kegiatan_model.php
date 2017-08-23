<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class kegiatan_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count() {
		$this->db->where('tgl_kegiatan',date('Y-m-d'));
		return $this->db->count_all("kegiatan_tbl");
	}
	
	public function fetchAllByNip($nip,$limit, $start) {
		$this->db->select ('*');
		$this->db->from ('kegiatan_tbl');
		$this->db->where('nip',$nip);
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
	
	public function fetchById($nip,$kd_skpd,$kd_position,$kd_kegiatan, $tgl_kegiatan){
		$this->db->select ('*');
		$this->db->from ('kegiatan_tbl');
		$this->db->where('nip',$nip);
		$this->db->where('kd_skpd',$kd_skpd);
		$this->db->where('kd_position',$kd_position);
		$this->db->where('kd_kegiatan',$kd_kegiatan);
		$this->db->where('tgl_kegiatan',$tgl_kegiatan);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function fetchByDate($nip,$kd_skpd,$kd_position,$tgl_kegiatan){
		$this->db->select ('*');
		$this->db->from ('kegiatan_tbl');
		$this->db->where('nip',$nip);
		$this->db->where('kd_skpd',$kd_skpd);
		$this->db->where('kd_position',$kd_position);
		$this->db->where('tgl_kegiatan',$tgl_kegiatan);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function generateKegiatan($nip){
		$this->db->select('IFNULL(MAX(kd_kegiatan),0)+1 id');
		$this->db->from('kegiatan_tbl');
		$this->db->where('nip',$nip);
		$this->db->where('tgl_kegiatan',date('Y-m-d'));
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->id;
	}
	
	public function create($data) {
		$this->nip = $data['nip'];
		$this->kd_skpd = $data['kd_skpd'];
		$this->kd_position = $data['kd_position'];
		$this->kd_tupoksi = $data['kd_tupoksi'];
		$this->kd_uraian = $data['kd_uraian'];
		$this->kd_kegiatan = $data['kd_kegiatan'];
		$this->tgl_kegiatan = $data['tgl_kegiatan'];
		$this->uraian_kegiatan = $data['uraian_kegiatan'];
		
		// insert data
		$this->db->insert('kegiatan_tbl', $this);
	}

	public function update($data) {
		// get data
		$this->nip = $data['nip'];
		$this->kd_skpd = $data['kd_skpd'];
		$this->kd_position = $data['kd_position'];
		$this->kd_tupoksi = $data['kd_tupoksi'];
		$this->kd_uraian = $data['kd_uraian'];
		$this->kd_kegiatan = $data['kd_kegiatan'];
		$this->tgl_kegiatan = $data['tgl_kegiatan'];
		$this->uraian_kegiatan = $data['uraian_kegiatan'];
		
		// update data
		$this->db->update ('kegiatan_tbl', $this, array ('nip'=> $this->nip = $data['nip'], 'kd_skpd' => $data['kd_skpd'], 'kd_position'=>$data['kd_position'], 'kd_kegiatan'=>$data['kd_kegiatan'], 'tgl_kegiatan'=>$data['tgl_kegiatan']));
	}
	
	public function delete($id) {
		if($this->db->delete ('kegiatan_tbl', array ('qid' => $id))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('kegiatan_tbl');
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('*');
		$this->db->from ('kegiatan_tbl');
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
	
}