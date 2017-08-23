<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_jabatan_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($nip) {
		$this->db->where('nip',$nip);
		return $this->db->count_all("riwayat_jabatan_tbl");
	}
	
	public function fetchAll($limit, $start,$nip) {
		$this->db->select ('rj.nip, p.nama, po.nama nama_position, rj.seq_no, rj.valid_from, rj.valid_to, rj.kd_skpd, s.nama nama_skpd, rj.position, rj.esselon, rj.jenis_jabatan, rj.no_sk, rj.tgl_sk, rj.valid_jabatan');
		$this->db->from ('riwayat_jabatan_tbl rj');
		$this->db->join ('pegawai_tbl p','rj.nip = p.nip');
		$this->db->join ('skpd_tbl s','rj.kd_skpd = s.kd_skpd');
		$this->db->join ('position_tbl po','po.kd_skpd = rj.kd_skpd and po.kd_position = rj.position');
		$this->db->where('rj.nip',$nip);
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
		$this->db->select ('rj.nip, p.nama, rj.seq_no, rj.jenis_jabatan, rj.valid_from, rj.valid_to, rj.kd_skpd, rj.position, po.nama position_name, rj.esselon, rj.no_sk, rj.tgl_sk, rj.valid_jabatan');
		$this->db->from ('riwayat_jabatan_tbl rj');
		$this->db->join ('pegawai_tbl p','rj.nip = p.nip');
		$this->db->join ('skpd_tbl s','rj.kd_skpd = s.kd_skpd');
		$this->db->join ('position_tbl po','po.kd_skpd = rj.kd_skpd and po.kd_position = rj.position');
		$this->db->where('rj.nip',$nip);
		$this->db->where('rj.seq_no',$seq_no);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->nip = $data['nip'];
		$this->seq_no = $data['seq_no'];
		$this->valid_from = $data['valid_from'];
		$this->valid_to = $data['valid_to'];
		$this->kd_skpd = $data['kd_skpd'];
		$this->position = $data['position'];
		$this->esselon = $data['esselon'];
		$this->no_sk = $data['no_sk'];
		$this->tgl_sk = $data['tgl_sk'];
		$this->valid_jabatan = 'Y';
		
		// insert data
		if($this->db->insert('riwayat_jabatan_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->valid_from = $data['valid_from'];
		$this->valid_to = $data['valid_to'];
		$this->kd_skpd = $data['kd_skpd'];
		$this->position = $data['position'];
		$this->jenis_jabatan = $data['jenis_jabatan'];
		$this->esselon = $data['esselon'];
		$this->no_sk = $data['no_sk'];
		$this->tgl_sk = $data['tgl_sk'];
		$this->valid_jabatan = $data['valid_jabatan'];
		
		// update data
		if($this->db->update ('riwayat_jabatan_tbl', $this, array ('nip' => $data['nip'],'seq_no' => $data['seq_no']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id, $seq_no) {
		if($this->db->delete ('riwayat_jabatan_tbl', array ('nip' => $id,'seq_no'=> $seq_no))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data,$nip){
		$this->db->where('nip',$nip);
		$this->db->where($column,$data);
		return  $this->db->count_all('riwayat_jabatan_tbl');
	}
	
	public function generateSeqNo($nip){
		return $this->db->query("SELECT ifnull(max(seq_no),0) seq_no FROM riwayat_jabatan_tbl WHERE nip='".$nip."'")->row()->seq_no+1;
	}
	
	public function search($column,$value, $nip, $limit, $start){
		
		$this->db->select ('rj.nip, p.nama, rj.seq_no, rj.valid_from, rj.valid_to, rj.kd_skpd, rj.position, rj.esselon, rj.esselon, rj.esselon, rj.no_sk, rj.tgl_sk, rj.valid_jabatan');
		$this->db->from ('riwayat_jabatan_tbl rj');
		$this->db->join ('pegawai_tbl p','rj.nip = p.nip');
		$this->db->where('rj.nip',$nip);
		$this->db->like($column,$value);
		$this->db->limit ($limit, $start);
		$query = $this->db->get('riwayat_jabatan_tbl rh');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getValidPosition($id,$id2){
		return $this->db->query('select rj.position from riwayat_jabatan_tbl rj where rj.nip="'.$id.'" and rj.kd_skpd="'.$id2.'" and rj.valid_jabatan="Y"')->row()->position;
	}
	
	public function getListStaffByPosition($position,$skpd){
		$this->db->select('rj.kd_skpd, rj.nip, pg.nama, p.kd_position');
		$this->db->join('riwayat_jabatan_tbl rj','p.kd_position = rj.position and p.kd_skpd = rj.kd_skpd','left');
		$this->db->join('pegawai_tbl pg','pg.nip = rj.nip','left');
		$this->db->where('p.parent_position',$position);
		$this->db->where('p.skpd',$skpd);
		$query = $this->db->get('position_tbl p');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
}