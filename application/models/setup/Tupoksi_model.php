<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Tupoksi_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count() {
		return $this->db->count_all("tupoksi_tbl");
	}
	
	public function fetchAll($limit, $start) {
		$this->db->select ('t.kd_skpd, s.nama nama_skpd, t.kd_position, p.nama nama_position, t.id_tupoksi, t.tupoksi, t.tahun, t.aktif');
		$this->db->from ('tupoksi_tbl t');
		$this->db->join ('skpd_tbl s','s.kd_skpd = t.kd_skpd');
		$this->db->join ('position_tbl p','p.kd_skpd = t.kd_skpd and p.kd_position = t.kd_position');
		$this->db->order_by('t.kd_skpd,t.kd_position,t.id_tupoksi');
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
	
	public function fetchById($id,$id2,$id3){
		$this->db->select ('t.kd_skpd, s.nama nama_skpd, t.kd_position, p.nama nama_position, t.id_tupoksi, t.tupoksi, t.tahun, t.aktif');
		$this->db->from ('tupoksi_tbl t');
		$this->db->join ('skpd_tbl s','s.kd_skpd = t.kd_skpd');
		$this->db->join ('position_tbl p','p.kd_skpd = t.kd_skpd and p.kd_position = t.kd_position');
		$this->db->where('t.id_tupoksi',$id);
		$this->db->where('t.kd_skpd',$id2);
		$this->db->where('t.kd_position',$id3);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->kd_position = $data['kd_position'];
		$this->kd_skpd = $data['kd_skpd'];
		$this->id_tupoksi = $data['id_tupoksi'];
		$this->tupoksi = $data['tupoksi'];
		$this->tahun = $data['tahun'];
		$this->aktif = $data['aktif'];
		
		// insert data
		if($this->db->insert('tupoksi_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->tupoksi = $data['tupoksi'];
		$this->tahun = $data['tahun'];
		$this->aktif = $data['aktif'];
		
		// update data
		if($this->db->update ('tupoksi_tbl', $this, array ('id_tupoksi' => $data['id_tupoksi'],'kd_skpd'=>$data['kd_skpd'],'kd_position'=>$data['kd_position']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id,$id2,$id3) {
		if($this->db->delete ('tupoksi_tbl', array ('id_tupoksi' => $id,'kd_skpd'=>$id2, 'kd_position'=>$id3))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('tupoksi_tbl');
	}
	
	public function getName($id,$id2,$id3){
		$this->db->select('tupoksi');
		$this->db->from('tupoksi_tbl');
		$this->db->where('id_tupoksi',$id);
		$this->db->where('kd_skpd',$id2);
		$this->db->where('kd_position',$id3);
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->tupoksi;
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('t.kd_skpd, s.nama nama_skpd, t.kd_position, p.nama nama_position, t.id_tupoksi, t.tupoksi, t.tahun, t.aktif');
		$this->db->from ('tupoksi_tbl t');
		$this->db->join ('skpd_tbl s','s.kd_skpd = t.kd_skpd');
		$this->db->join ('position_tbl p','p.kd_skpd = t.kd_skpd and p.kd_position = t.kd_position');
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
	
	public function getListTupoksi($nip, $skpd,$position){
		
		$this->db->select('"'.$nip.'" nip, ut.kd_skpd, ut.kd_position, ut.id_tupoksi, ut.id_uraian, ut.uraian_tupoksi, ut.qid');
		$this->db->from('uraian_tupoksi_tbl ut');
		$this->db->where('ut.kd_skpd',$skpd);
		$this->db->where('ut.kd_position',$position);
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getByQid($id){
		$this->db->select('ut.kd_skpd, ut.kd_position, ut.id_tupoksi, ut.id_uraian');
		$this->db->from('uraian_tupoksi_tbl ut');
		$this->db->where('ut.qid',$id);
		$query= $this->db->get();
		return $query->row();
	}
	
}