<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class uraian_tupoksi_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($id,$id2,$id3) {
		$this->db->select ('*');
		$this->db->from ('uraian_tupoksi_tbl ut');
		$this->db->join ('tupoksi_tbl t','t.id_tupoksi = ut.id_tupoksi and t.kd_skpd = ut.kd_skpd and t.kd_position = ut.kd_position ');
		$this->db->where('ut.kd_skpd',$id2);
		$this->db->where('ut.kd_position',$id3);
		$this->db->where('ut.id_tupoksi',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function fetchAll($id,$id2,$id3,$limit, $start) {
		$this->db->select ('ut.id_uraian, ut.uraian_tupoksi, ut.aktif,ut.jenis_tupoksi');
		$this->db->from ('uraian_tupoksi_tbl ut');
		$this->db->join ('tupoksi_tbl t','t.id_tupoksi = ut.id_tupoksi and t.kd_skpd = ut.kd_skpd and t.kd_position = ut.kd_position ');
		$this->db->where('ut.kd_skpd',$id2);
		$this->db->where('ut.kd_position',$id3);
		$this->db->where('ut.id_tupoksi',$id);
		$this->db->limit ($limit, $start);
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function fetchById($id,$id2,$id3,$id4){
		$this->db->select ('ut.kd_position, ut.kd_skpd,ut.id_tupoksi, t.tupoksi, ut.id_uraian, ut.uraian_tupoksi, ut.aktif, ut.jenis_tupoksi');
		$this->db->from ('uraian_tupoksi_tbl ut');
		$this->db->join ('tupoksi_tbl t','t.id_tupoksi = ut.id_tupoksi and t.kd_skpd = ut.kd_skpd and t.kd_position = ut.kd_position ');
		$this->db->where('ut.kd_skpd',$id2);
		$this->db->where('ut.kd_position',$id3);
		$this->db->where('ut.id_tupoksi',$id);
		$this->db->where('ut.id_uraian',$id4);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->kd_skpd = $data['kd_skpd'];
		$this->kd_position = $data['kd_position'];
		$this->id_tupoksi = $data['id_tupoksi'];
		$this->id_uraian = $data['id_uraian'];
		$this->uraian_tupoksi = $data['uraian_tupoksi'];
		$this->jenis_tupoksi = $data['jenis_tupoksi'];
		$this->aktif = 'Y';
		
		// insert data
		if($this->db->insert('uraian_tupoksi_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->uraian_tupoksi = $data['uraian_tupoksi'];
		$this->jenis_tupoksi = $data['jenis_tupoksi'];
		$this->aktif = $data['aktif'];
		
		// update data
		if($this->db->update ('uraian_tupoksi_tbl', $this, array ('id_tupoksi' => $data['id_tupoksi'],'id_uraian'=> $data['id_uraian'],'kd_skpd'=>$data['kd_skpd'],'kd_position'=>$data['kd_position']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id,$id2,$id3,$id4) {
		if($this->db->delete ('uraian_tupoksi_tbl', array ('id_tupoksi' => $id,'id_uraian'=> $id4,'kd_skpd'=>$id2,'kd_position'=>$id3))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('uraian_tupoksi_tbl');
	}
	
	public function getName($id,$id2,$id3,$id4){
		$this->db->select('uraian_tupoksi');
		$this->db->from('uraian_tupoksi_tbl');
		$this->db->where('id_tupoksi',$id);
		$this->db->where('id_uraian',$id2);
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->uraian_tupoksi;
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('*');
		$this->db->from ('uraian_tupoksi_tbl');
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