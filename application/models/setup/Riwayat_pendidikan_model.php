<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Riwayat_pendidikan_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($nip) {
		$this->db->where('nip',$nip);
		return $this->db->count_all("riwayat_pendidikan_tbl");
	}
	
	public function fetchAll($limit, $start,$nip) {
		$this->db->select ('rp.nip, rp.seq_no, (CASE rp.jenis_pendidikan WHEN "1" THEN "TK" WHEN "2" THEN "Sekolah Dasar" WHEN "3" THEN "Sekolah Menengah Pertama" WHEN "4" THEN "Sekolah Menengah Atas" WHEN "5" THEN "Strata 1" WHEN "6" THEN "Strata " WHEN "7" THEN "Doktor" END) jenis_pendidikan, rp.jurusan, rp.nama_sekolah, rp.kepala_sekolah, 
				rp.no_ijazah, rp.tahun_ijazah, rp.qversion, rp.qid');
		$this->db->from ('riwayat_pendidikan_tbl rp ');
		$this->db->where('rp.nip',$nip);
		$this->db->order_by('rp.nip,rp.seq_no','DESC');
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
		$this->db->select ('rp.nip,p.nama, rp.seq_no, rp.jenis_pendidikan, rp.jurusan, rp.nama_sekolah, rp.kepala_sekolah, 
				rp.no_ijazah, rp.tahun_ijazah, rp.qversion, rp.qid');
		$this->db->from ('riwayat_pendidikan_tbl rp');
		$this->db->join ('pegawai_tbl p','p.nip = rp.nip','left');
		$this->db->order_by('rp.seq_no,rp.nip','DESC');
		$this->db->where('rp.nip',$nip);
		$this->db->where('rp.seq_no',$seq_no);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->nip = trim($data['nip']);
		$this->seq_no = $data['seq_no'];
		$this->jenis_pendidikan = $data['jenis_pendidikan'];
		$this->jurusan = $data['jurusan'];
		$this->nama_sekolah = $data['nama_sekolah'];
		$this->kepala_sekolah = $data['kepala_sekolah'];
		$this->no_ijazah = $data['no_ijazah'];
		$this->tahun_ijazah = $data['tahun_ijazah'];
		
		// insert data
		if($this->db->insert('riwayat_pendidikan_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->jenis_pendidikan = $data['jenis_pendidikan'];
		$this->jurusan = $data['jurusan'];
		$this->nama_sekolah = $data['nama_sekolah'];
		$this->kepala_sekolah = $data['kepala_sekolah'];
		$this->no_ijazah = $data['no_ijazah'];
		$this->tahun_ijazah = $data['tahun_ijazah'];
		
		// update data
		if($this->db->update ('riwayat_pendidikan_tbl', $this, array ('nip' => $data['nip'],'seq_no' => $data['seq_no']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id, $seq_no) {
		if($this->db->delete ('riwayat_pendidikan_tbl', array ('nip' => $id,'seq_no'=> $seq_no))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data,$nip){
		$this->db->where('nip',$nip);
		$this->db->where($column,$data);
		return  $this->db->count_all('riwayat_pendidikan_tbl');
	}
	
	public function generateSeqNo($nip){
		return $this->db->query("SELECT max(seq_no) seq_no FROM riwayat_pendidikan_tbl WHERE nip='".$nip."'")->row()->seq_no+1;
	}
	
	public function search($column,$value, $nip, $limit, $start){
		
		$this->db->select ('rp.nip, rp.seq_no, rp.jenis_pendidikan, rp.jurusan, rp.nama_sekolah, rp.kepala_sekolah, 
				rp.no_ijazah, rp.tahun_ijazah, rp.qversion, rp.qid');
		$this->db->where('nip',$nip);
		$this->db->like($column,$value);
		$this->db->limit ($limit, $start);
		$query = $this->db->get('riwayat_pendidikan_tbl rp');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
		
	}
	
}