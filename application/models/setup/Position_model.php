<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class position_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model('setup/riwayat_jabatan_model');
	}
	
	public function record_count() {
		return $this->db->count_all("position_tbl");
	}
	
	public function fetchAll($limit, $start) {
		$this->db->select ('p.kd_skpd, s.nama nama_skpd, p.kd_position, p.nama, p.parent_position, p2.nama parent_name');
		$this->db->from ('position_tbl p');
		$this->db->join ('skpd_tbl s','s.kd_skpd = p.kd_skpd');
		$this->db->join ('position_tbl p2','p.kd_skpd = p2.kd_skpd and p.parent_position = p2.kd_position','left');
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
	
	public function fetchById($id,$id2){
		$this->db->select ('p.kd_skpd, s.nama nama_skpd, p.kd_position, p.nama, p.parent_position, p2.nama parent_name');
		$this->db->from ('position_tbl p');
		$this->db->join ('skpd_tbl s','s.kd_skpd = p.kd_skpd');
		$this->db->join ('position_tbl p2','p.kd_skpd = p2.kd_skpd and p.parent_position = p2.kd_position','left');
		$this->db->where('p.kd_skpd',$id);
		$this->db->where('p.kd_position',$id2);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->kd_skpd = $data['kd_skpd'];
		$this->kd_position = $data['kd_position'];
		$this->nama = $data['nama'];
		$this->parent_position = $data['parent_position'];
		
		// insert data
		if($this->db->insert('position_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->nama = $data['nama'];
		$this->parent_position = $data['parent_position'];
		
		// update data
		if($this->db->update ('position_tbl', $this, array ('kd_skpd' => $data['kd_skpd'],'kd_position'=> $data['kd_position']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id,$id2) {
		if($this->db->delete ('position_tbl', array ('kd_skpd' => $id,'kd_position'=> $id2))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('position_tbl');
	}
	
	public function getName($id,$id2){
		if($id!=null && $id2!=null){
			$this->db->select('nama');
			$this->db->from('position_tbl');
			$this->db->where('kd_skpd',$id);
			$this->db->where('kd_position',$id2);
			$query= $this->db->get();
			$ret = $query->row();
			return $ret->nama;
		}else{
			return "Belum Terdaftar";
		}
	}
	
	public function getPositionByNip($nip,$skpd){
		$this->db->select('nama');
		$this->db->from('position_tbl p');
		$this->db->where('kd_skpd',$skpd);
		$this->db->where('kd_position',$this->riwayat_jabatan_model->getValidPosition($nip,$skpd));
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->nama;
	}
	
	public function getParentPosition($skpd,$position){
		$default = "";
		$this->db->select('parent_position');
		$this->db->from('position_tbl p');
		$this->db->where('kd_skpd',$skpd);
		$this->db->where('kd_position',$position);
		$query= $this->db->get();
		$ret = $query->row();
		if ($query->num_rows()> 0){
			if($ret->parent_position!=null){
				$default =  $ret->parent_position;
			}
		}
		return $default;
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('*');
		$this->db->from ('position_tbl');
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