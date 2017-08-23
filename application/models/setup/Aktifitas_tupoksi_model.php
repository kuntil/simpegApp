<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class aktifitas_tupoksi_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($id,$id2) {
		$this->db->where('id_tupoksi',$id);
		$this->db->where('id_uraian',$id2);
		return $this->db->count_all("aktifitas_tupoksi_tbl");
	}
	
	public function fetchAll($id,$id2,$limit, $start) {
		$this->db->select ('at.id_tupoksi, t.tupoksi, at.id_uraian, ut.uraian_tupoksi, at.id_aktifitas, at.kategori, at.nama_aktifitas, at.satuan_output, at.lama_waktu, at.tingkat_kesulitan, at.bobot, at.aktif');
		$this->db->from ('aktifitas_tupoksi_tbl at');
		$this->db->join('uraian_tupoksi_tbl ut','ut.id_tupoksi = at.id_tupoksi and ut.id_uraian = at.id_uraian');
		$this->db->join('tupoksi_tbl t','t.id_tupoksi = at.id_tupoksi');
		$this->db->where('at.id_tupoksi',$id);
		$this->db->where('at.id_uraian',$id2);
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
	
	public function isEksis($id_tupoksi,$id_uraian,$id_aktifitas){
		$this->db->select('1');
		$this->db->from('aktifitas_tupoksi_tbl');
		$this->db->where('id_tupoksi',$id_tupoksi);
		$this->db->where('id_uraian',$id_uraian);
		$this->db->where('id_aktifitas',$id_aktifitas);
		$query = $this->db->get();
		if($query->num_rows()!=0){
			return true;
		}else{
			return false;
		}
	}
	
	public function fetchById($id,$id2,$id3){
		$this->db->select ('at.id_tupoksi, t.tupoksi, at.id_uraian, ut.uraian_tupoksi, at.id_aktifitas, at.kategori, at.nama_aktifitas, at.satuan_output, at.lama_waktu, at.tingkat_kesulitan, at.bobot, at.aktif');
		$this->db->from ('aktifitas_tupoksi_tbl at');
		$this->db->join('uraian_tupoksi_tbl ut','ut.id_tupoksi = at.id_tupoksi and ut.id_uraian = at.id_uraian');
		$this->db->join('tupoksi_tbl t','t.id_tupoksi = at.id_tupoksi');
		$this->db->where('at.id_tupoksi',$id);
		$this->db->where('at.id_uraian',$id2);
		$this->db->where('at.id_aktifitas',$id3);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->id_tupoksi = $data['id_tupoksi'];
		$this->id_uraian = $data['id_uraian'];
		$this->id_aktifitas = $data['id_aktifitas'];
		$this->nama_aktifitas = $data['nama_aktifitas'];
		$this->kategori = $data['kategori'];
		$this->satuan_output = $data['satuan_output'];
		$this->lama_waktu = $data['lama_waktu'];
		$this->tingkat_kesulitan = $data['tingkat_kesulitan'];
		$this->bobot = $data['bobot'];
		$this->aktif = $data['aktif'];
		
		// insert data
		if($this->db->insert('aktifitas_tupoksi_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->nama_aktifitas = $data['nama_aktifitas'];
		$this->kategori = $data['kategori'];
		$this->satuan_output = $data['satuan_output'];
		$this->lama_waktu = $data['lama_waktu'];
		$this->tingkat_kesulitan = $data['tingkat_kesulitan'];
		$this->bobot = $data['bobot'];
		$this->aktif = $data['aktif'];
		
		// update data
		if($this->db->update ('aktifitas_tupoksi_tbl', $this, array ('id_tupoksi' => $data['id_tupoksi'],'id_uraian'=> $data['id_uraian'],'id_aktifitas'=> $data['id_aktifitas']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id,$id2,$id3) {
		if($this->db->delete ('aktifitas_tupoksi_tbl', array ('id_tupoksi' => $id,'id_aktifitas'=> $id2,'id_aktifitas'=> $id3))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('aktifitas_tupoksi_tbl');
	}
	
	public function getName($id,$id2,$id3){
		$this->db->select('nama_aktifitas');
		$this->db->from('aktifitas_tupoksi_tbl');
		$this->db->where('id_tupoksi',$id);
		$this->db->where('id_uraian',$id2);
		$this->db->where('id_aktifitas',$id3);
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->tupoksi;
	}
	
	public function search($id,$id2,$column,$value, $limit, $start){
		
		$this->db->select ('at.id_tupoksi, t.tupoksi, at.id_uraian, ut.uraian_tupoksi, at.id_aktifitas, at.kategori, at.nama_aktifitas, at.satuan_output, at.lama_waktu, at.tingkat_kesulitan, at.bobot');
		$this->db->from ('aktifitas_tupoksi_tbl at');
		$this->db->join('uraian_tupoksi_tbl ut','ut.id_tupoksi = at.id_tupoksi and ut.id_uraian = at.id_uraian');
		$this->db->join('tupoksi_tbl t','t.id_tupoksi = at.id_tupoksi');
		$this->db->where('at.id_tupoksi',$id);
		$this->db->where('at.id_uraian',$id2);
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