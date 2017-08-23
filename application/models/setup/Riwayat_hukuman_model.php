<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_hukuman_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($nip) {
		$this->db->where('nip',$nip);
		return $this->db->count_all("riwayat_hukuman_tbl");
	}
	
	public function recordCountAll() {
		return $this->db->count_all("riwayat_hukuman_tbl");
	}
	
	public function fetchAll($limit, $start,$nip) {
		$this->db->select ('rh.nip, rh.seq_no, rh.hukuman, rh.uraian_hukuman, rh.no_surat_kerja, rh.tgl_surat_kerja, rh.pejabat');
		$this->db->from ('riwayat_hukuman_tbl rh ');
		$this->db->where('rh.nip',$nip);
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
	
	public function fetchById($nip,$seq_no){
		$this->db->select ('rh.nip, p.nama, rh.seq_no, rh.hukuman, rh.uraian_hukuman uraian_hukum, rh.no_surat_kerja, rh.tgl_surat_kerja, rh.pejabat');
		$this->db->from ('riwayat_hukuman_tbl rh');
		$this->db->join ('pegawai_tbl p','p.nip = rh.nip','left');
		$this->db->where('rh.nip',$nip);
		$this->db->where('rh.seq_no',$seq_no);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->nip = $data['nip'];
		$this->seq_no = $data['seq_no'];
		$this->hukuman = $data['hukuman'];
		$this->uraian_hukuman = $data['uraian_hukum'];
		$this->no_surat_kerja = $data['no_surat_kerja'];
		$this->tgl_surat_kerja = $data['tgl_surat_kerja'];
		$this->pejabat = $data['pejabat'];
		
		// insert data
		if($this->db->insert('riwayat_hukuman_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->hukuman = $data['hukuman'];
		$this->uraian_hukuman = $data['uraian_hukum'];
		$this->no_surat_kerja = $data['no_surat_kerja'];
		$this->tgl_surat_kerja = $data['tgl_surat_kerja'];
		$this->pejabat = $data['pejabat'];
		
		// update data
		if($this->db->update ('riwayat_hukuman_tbl', $this, array ('nip' => $data['nip'],'seq_no' => $data['seq_no']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id, $seq_no) {
		if($this->db->delete ('riwayat_hukuman_tbl', array ('nip' => $id,'seq_no'=> $seq_no))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data,$nip){
		$this->db->where('nip',$nip);
		$this->db->where($column,$data);
		return  $this->db->count_all('riwayat_hukuman_tbl');
	}
	
	public function generateSeqNo($nip){
		return $this->db->query("SELECT ifnull(max(seq_no),0) seq_no FROM riwayat_hukuman_tbl WHERE nip='".$nip."'")->row()->seq_no+1;
	}
	
	public function search($column,$value, $nip, $limit, $start){
		
		$this->db->select ('rh.nip, rh.seq_no, rh.hukuman, rh.uraian_hukuman, rh.no_surat_kerja, rh.tgl_surat_kerja, rh.pejabat');
		$this->db->where('nip',$nip);
		$this->db->like($column,$value);
		$this->db->limit ($limit, $start);
		$query = $this->db->get('riwayat_hukuman_tbl rh');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
		
	}
	
}