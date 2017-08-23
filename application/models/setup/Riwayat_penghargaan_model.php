<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_penghargaan_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($nip) {
		$this->db->where('nip',$nip);
		return $this->db->count_all("riwayat_penghargaan_tbl");
	}
	
	public function fetchAll($limit, $start,$nip) {
		$this->db->select ('rp.nip, rp.seq_no, rp.penghargaan, rp.no_surat_kerja, rp.tgl_surat_kerja, rp.tahun');
		$this->db->from ('riwayat_penghargaan_tbl rp ');
		$this->db->where('rp.nip',$nip);
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
		$this->db->select ('rp.nip, p.nama, rp.seq_no, rp.penghargaan, rp.no_surat_kerja, rp.tgl_surat_kerja, rp.tahun');
		$this->db->from ('riwayat_penghargaan_tbl rp');
		$this->db->join ('pegawai_tbl p','p.nip = rp.nip','left');
		$this->db->where('rp.nip',$nip);
		$this->db->where('rp.seq_no',$seq_no);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->nip = $data['nip'];
		$this->seq_no = $data['seq_no'];
		$this->penghargaan = $data['penghargaan'];
		$this->no_surat_kerja = $data['no_surat_kerja'];
		$this->tgl_surat_kerja = $data['tgl_surat_kerja'];
		$this->tahun = $data['tahun'];
		
		// insert data
		if($this->db->insert('riwayat_penghargaan_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->penghargaan = $data['penghargaan'];
		$this->no_surat_kerja = $data['no_surat_kerja'];
		$this->tgl_surat_kerja = $data['tgl_surat_kerja'];
		$this->tahun = $data['tahun'];
		
		// update data
		if($this->db->update ('riwayat_penghargaan_tbl', $this, array ('nip' => $data['nip'],'seq_no' => $data['seq_no']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id, $seq_no) {
		if($this->db->delete ('riwayat_penghargaan_tbl', array ('nip' => $id,'seq_no'=> $seq_no))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data,$nip){
		$this->db->where('nip',$nip);
		$this->db->where($column,$data);
		return  $this->db->count_all('riwayat_penghargaan_tbl');
	}
	
	public function generateSeqNo($nip){
		return $this->db->query("SELECT ifnull(max(seq_no),0) seq_no FROM riwayat_penghargaan_tbl WHERE nip='".$nip."'")->row()->seq_no+1;
	}
	
	public function search($column,$value, $nip, $limit, $start){
		
		$this->db->select ('rp.nip, rp.seq_no, rp.penghargaan, rp.no_surat_kerja, rp.tgl_surat_kerja, rp.tahun');
		$this->db->where('nip',$nip);
		$this->db->like($column,$value);
		$this->db->limit ($limit, $start);
		$query = $this->db->get('riwayat_penghargaan_tbl rp');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
		
	}
	
}