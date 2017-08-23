<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class pegawai_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model('admin/user_operation_model');
		$this->load->model('setup/position_model');
	}
	
	public function record_count() {
		return $this->db->count_all("pegawai_tbl");
	}
	
	public function fetchAll($limit, $start) {
		$this->db->select ('p.nip, ifnull(p.nip_lama,"-") nip_lama, p.nama, p.picture, p.gelar_depan, p.gelar_belakang, 
		p.tempat_lahir, p.tgl_lahir, p.telp, 
		(case p.kelamin when "1" then "Pria" else "Wanita" end) kelamin ,
		(case p.agama when "1" then "Islam" when "2" then "Katolik" when "3" then "Protestan" when "4" then "Hindu" when "5" then "Budha" when "6" then "Sinto" when "7" then "Konghucu" else "Lain-lain" end) agama, 
		(case p.gol_darah when "1" then "A" when "2" then "B" when "3" then "AB" else "O" end) gol_darah,
		(case p.status when "1" then "Lajang" when "2" then "Nikah" else "Cerai" end) status, 
		p.no_kartu_pegawai, p.no_askes, p.no_taspen, p.no_kartu_keluarga, p.npwp, p.qversion, p.qid,p.alamat, p.kode_pos');
		$this->db->from ('pegawai_tbl p ');
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
	
	public function isEksis($nip){
		$this->db->select('1');
		$this->db->from('pegawai_tbl');
		$this->db->where('nip',$nip);
		$query = $this->db->get();
		if($query->num_rows()!=0){
			return true;
		}else{
			return false;
		}
	}
	
	public function fetchById($id){
		$this->db->select ('p.nip, ifnull(p.nip_lama,"-") nip_lama, p.nama, p.picture, p.gelar_depan, p.gelar_belakang, 
		p.tempat_lahir, p.tgl_lahir, p.telp, p.kelamin , p.agama, p.gol_darah, p.status,  p.no_kartu_pegawai, p.no_askes, p.no_taspen, p.no_kartu_keluarga, p.npwp, p.qversion, p.qid,p.alamat, p.kode_pos');
		$this->db->from ('pegawai_tbl p');
		$this->db->where('p.nip',$id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->nip = $data['nip'];
		$this->nip_lama = $data['nip_lama'];
		$this->nama = $data['nama'];
		$this->gelar_depan = $data['gelar_depan'];
		$this->gelar_belakang = $data['gelar_belakang'];
		$this->tempat_lahir = $data['tempat_lahir'];
		$this->tgl_lahir = $data['tgl_lahir'];
		$this->telp = $data['telp'];
		$this->kelamin = $data['kelamin'];
		$this->agama = $data['agama'];
		$this->alamat = $data['alamat'];
		$this->kode_pos = $data['kode_pos'];
		$this->gol_darah = $data['gol_darah'];
		$this->no_kartu_pegawai = $data['no_kartu_pegawai'];
		$this->status = $data['status'];
		$this->no_taspen = $data['no_taspen'];
		$this->npwp = $data['npwp'];
		
		// insert data
		if($this->db->insert('pegawai_tbl', $this)){
			return "Data succesfully inserted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}

	public function update($data) {
		// get data
		$this->nip_lama = $data['nip_lama'];
		$this->nama = $data['nama'];
		$this->gelar_depan = $data['gelar_depan'];
		$this->gelar_belakang = $data['gelar_belakang'];
		$this->tempat_lahir = $data['tempat_lahir'];
		$this->telp = $data['telp'];
		$this->kelamin = $data['kelamin'];
		$this->tgl_lahir = $data['tgl_lahir'];
		$this->agama = $data['agama'];
		$this->alamat = $data['alamat'];
		$this->kode_pos = $data['kode_pos'];
		$this->gol_darah = $data['gol_darah'];
		$this->status = $data['status'];
		$this->no_kartu_pegawai = $data['no_kartu_pegawai'];
		$this->no_taspen = $data['no_taspen'];
		$this->npwp = $data['npwp'];
		
		// update data
		if($this->db->update ( 'pegawai_tbl', $this, array ('nip' => $data['nip']))){
			return "Data succesfully updated!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function delete($id) {
		if($this->db->delete ('pegawai_tbl', array ('nip' => $id))){
			return "Data succesfully deleted!";
		}else{
			$data = $this->db->error();
			return $data['message'];
		}
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('pegawai_tbl');
	}
	
	public function getName($nip){
		$this->db->select('nama');
		$this->db->from('pegawai_tbl');
		$this->db->where('nip',$nip);
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->nama;
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('p.nip, ifnull(p.nip_lama,"-") nip_lama, p.nama, p.picture, p.gelar_depan, p.gelar_belakang,
		p.tempat_lahir, p.tgl_lahir, p.telp,
		(case p.kelamin when "1" then "Pria" else "Wanita" end) kelamin ,
		(case p.agama when "1" then "Islam" when "2" then "Katolik" when "3" then "Protestan" when "4" then "Hindu" when "5" then "Budha" when "6" then "Sinto" when "7" then "Konghucu" else "Lain-lain" end) agama,
		(case p.gol_darah when "1" then "A" when "2" then "B" when "3" then "AB" else "O" end) gol_darah,
		(case p.status when "1" then "Lajang" when "2" then "Nikah" else "Cerai" end) status,
		p.no_kartu_pegawai, p.no_askes, p.no_taspen, p.no_kartu_keluarga, p.npwp, p.qversion, p.qid,p.alamat, p.kode_pos');
		$this->db->from ('pegawai_tbl p ');
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
	
	public function getSessionPegawai($email){
		$this->db->select('rj.nip, rj.kd_skpd, rj.position,u.id');
		$this->db->from('users u');
		$this->db->join('riwayat_jabatan_tbl rj','rj.nip = u.nip and rj.valid_jabatan = "Y"','left');
		$this->db->where('u.email',$email);
		$query = $this->db->get();
		$ret = $query->row();
		$data = array(
				'ss_user'=> $ret->id,
				'ss_nip'=>$ret->nip,
				'ss_skpd'=>$ret->kd_skpd,
				'ss_position'=>$ret->position,
				'ss_parent'=>$this->position_model->getParentPosition($ret->kd_skpd,$ret->position)
		);
		return $data;
	}
	
	public function getGroupByUserId(){
		$this->db->select('u.id, u.nip, g.id group_id, g.description');
		$this->db->from('users_groups ug');
		$this->db->join('users u','ug.user_id = u.id','LEFT');
		$this->db->join('groups g','g.id = ug.group_id','LEFT');
		$this->db->where('u.id',$this->session->userdata('ss_user'));
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->group_id;

	}
	
	public function getImage($nip){
		$default = "default.png";
		$this->db->select('picture');
		$this->db->from('pegawai_tbl');
		$this->db->where('nip',$nip);
		$query= $this->db->get();
		$ret = $query->row();
		if ($query->num_rows()> 0){
			if($ret->picture!=null){
				$default =  $ret->picture;
			}
		}
		return $default;
	}
	
	public function upload($data){
		$this->picture = $data['nama'];
		$this->db->update('pegawai_tbl', $this, array ('nip' => $data['nip']));
	}
	
}