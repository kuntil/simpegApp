<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_kepangkatan_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($nip) {
		$this->db->where('nip',$nip);
		return $this->db->count_all("riwayat_kepangkatan_tbl");
	}
	
	public function fetchAll($limit, $start,$nip) {
		$this->db->select ('rp.nip, p.nama, rp.seq_no, rp.golongan, rp.tmt_pangkat, rp.no_surat_kerja, rp.tgl_surat_kerja, rp.mk_bulan, rp.mk_tahun');
		$this->db->from ('riwayat_kepangkatan_tbl rp ');
		$this->db->join ('pegawai_tbl p','rp.nip = p.nip');
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
		$this->db->select ('rp.nip, p.nama, rp.seq_no, rp.golongan, rp.tmt_pangkat, rp.no_surat_kerja, rp.tgl_surat_kerja, rp.mk_bulan, rp.mk_tahun');
		$this->db->from ('riwayat_kepangkatan_tbl rp ');
		$this->db->join ('pegawai_tbl p','rp.nip = p.nip');
		$this->db->where('rp.nip',$nip);
		$this->db->where('rp.seq_no',$seq_no);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->nip = $data['nip'];
		$this->seq_no = $data['seq_no'];
		$this->golongan = $data['golongan'];
		$this->tmt_pangkat = $data['tmt_pangkat'];
		$this->no_surat_kerja = $data['no_surat_kerja'];
		$this->tgl_surat_kerja = $data['tgl_surat_kerja'];
		$this->mk_bulan = $data['mk_bulan'];
		$this->mk_tahun = $data['mk_tahun'];
		
		// insert data
		if($this->db->insert('riwayat_kepangkatan_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->golongan = $data['golongan'];
		$this->tmt_pangkat = $data['tmt_pangkat'];
		$this->no_surat_kerja = $data['no_surat_kerja'];
		$this->tgl_surat_kerja = $data['tgl_surat_kerja'];
		$this->mk_bulan = $data['mk_bulan'];
		$this->mk_tahun = $data['mk_tahun'];
		
		// update data
		if($this->db->update ('riwayat_kepangkatan_tbl', $this, array ('nip' => $data['nip'],'seq_no' => $data['seq_no']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id, $seq_no) {
		if($this->db->delete ('riwayat_kepangkatan_tbl', array ('nip' => $id,'seq_no'=> $seq_no))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data,$nip){
		$this->db->where('nip',$nip);
		$this->db->where($column,$data);
		return  $this->db->count_all('riwayat_kepangkatan_tbl');
	}
	
	public function generateSeqNo($nip){
		return $this->db->query("SELECT ifnull(max(seq_no),0) seq_no FROM riwayat_kepangkatan_tbl WHERE nip='".$nip."'")->row()->seq_no+1;
	}
	
	public function search($column,$value, $nip, $limit, $start){
		
		$this->db->select ('rp.nip, p.nama, rp.seq_no, rp.golongan, rp.tmt_pangkat, rp.no_surat_kerja, rp.tgl_surat_kerja, rp.mk_bulan, rp.mk_tahun');
		$this->db->from ('riwayat_kepangkatan_tbl rp ');
		$this->db->join ('pegawai_tbl p','rp.nip = p.nip');
		$this->db->where('rp.nip',$nip);
		$this->db->like($column,$value);
		$this->db->limit ($limit, $start);
		$query = $this->db->get('riwayat_kepangkatan_tbl rh');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
		
	}
	
}