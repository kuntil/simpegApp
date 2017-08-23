<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class penilaian_tupoksi_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_countByMonth($nip,$skpd,$position,$bln_aktifitas) {
		$query = $this->db->query('select pk.nip, pt.nama, month(pk.tgl_kegiatan) bulan,sum(pk.nilai)/(select count(p.nilai) from penilaian_kinerja_tbl p where month(p.tgl_kegiatan)='.$bln_aktifitas.')*100 persentase
				from penilaian_kinerja_tbl pk join pegawai_tbl pt on pt.nip = pk.nip where pk.nip = "'.$nip.'" and pk.kd_skpd ="'.$skpd.'" and pk.kd_position="'.$position.'" and month(pk.tgl_kegiatan)='.$bln_aktifitas.' ');
		return $query->num_rows();
	}
	
	public function record_count(){
		$this->db->select ('p.nip, p.nama, p.kelamin, pt.kd_skpd, pt.kd_position, pt.nama nama_position');
		$this->db->from ('pegawai_tbl p');
		$this->db->join ('riwayat_jabatan_tbl rj','p.nip = rj.nip and rj.valid_jabatan ="Y"');
		$this->db->join ('position_tbl pt','pt.kd_skpd = rj.kd_skpd and pt.kd_position =rj.position');
		$this->db->where('pt.parent_position',$this->session->userdata('ss_position'));
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function fetchAll($limit, $start) {
		$this->db->select ('p.nip, p.nama, p.kelamin, pt.kd_skpd, pt.kd_position, pt.nama nama_position');
		$this->db->from ('pegawai_tbl p');
		$this->db->join ('riwayat_jabatan_tbl rj','p.nip = rj.nip and rj.valid_jabatan ="Y"');
		$this->db->join ('position_tbl pt','pt.kd_skpd = rj.kd_skpd and pt.kd_position =rj.position');
		$this->db->where('pt.parent_position',$this->session->userdata('ss_position'));
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
	
	public function fetchByMonth($nip,$skpd,$position,$bln_aktifitas){
		$query = $this->db->query('select pk.nip, pt.nama,pk.uraian_kegiatan, month(pk.tgl_kegiatan) bulan,sum(pk.nilai)/(select count(p.nilai) from penilaian_kinerja_tbl p where month(p.tgl_kegiatan)='.$bln_aktifitas.')*100 persentase 
				from kegiatan_tbl pk join pegawai_tbl pt on pt.nip = pk.nip where pk.nip = "'.$nip.'" and pk.kd_skpd ="'.$skpd.'" and pk.kd_position="'.$position.'" and month(pk.tgl_kegiatan)='.$bln_aktifitas.' ');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function fetchByDate($nip,$skpd,$position,$bln_aktifitas,$limit, $start){
		$query = $this->db->query('select pk.tgl_kegiatan,pk.uraian_kegiatan, pk.kd_uraian, ut.uraian_tupoksi, pk.nilai, round((pk.nilai/100)*100,2) persentase from kegiatan_tbl pk
				JOIN uraian_tupoksi_tbl ut on
				pk.kd_skpd = ut.kd_skpd and pk.kd_position = ut.kd_position and pk.kd_tupoksi = ut.id_tupoksi and pk.kd_uraian = ut.id_uraian
				where pk.nip ="'.$nip.'" and pk.kd_skpd="'.$skpd.'" and pk.kd_position="'.$position.'" and month(pk.tgl_kegiatan)='.$bln_aktifitas.' limit '.$start.','.$limit.' ');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
		
	}
	
	public function create($data) {
		$this->kd_skpd = $data['kd_skpd'];
		$this->kd_position = $data['kd_position'];
		$this->id_tupoksi = $data['id_tupoksi'];
		$this->id_uraian = $data['id_uraian'];
		$this->nip = $data['nip'];
		$this->tgl_kegiatan = $data['tgl_kegiatan'];
		
		// insert data
		$this->db->insert('penilaian_kinerja_tbl', $this);
	}

	public function update($data) {
		// get data
		$this->nilai = $data['nilai'];
		// update data
		$this->db->update ('skpd_tbl', $this, array ('kd_skpd' => $data['kd_skpd'],'kd_position'=>$data['kd_position'],'id_tupoksi'=>$data['id_tupoksi'],
				'tgl_kegiatan'=>$data['tgl_kegiatan'],'id_uraian'=>$data['id_uraian'],'nip'=>$data['nip']));
	}
	
	public function delete($id) {
		$this->db->delete ('skpd_tbl', array ('kd_skpd' => $id));
	}
	
	public function search_count($column, $data){
		$this->db->where($column,$data);
		return  $this->db->count_all('skpd_tbl');
	}
	
	public function getName($nip){
		$this->db->select('nama');
		$this->db->from('skpd_tbl');
		$this->db->where('kd_skpd',$nip);
		$query= $this->db->get();
		$ret = $query->row();
		return $ret->nama;
	}
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('p.nip, p.nama, p.kelamin, pt.kd_skpd, pt.kd_position, pt.nama nama_position');
		$this->db->from ('pegawai_tbl p');
		$this->db->join ('riwayat_jabatan_tbl rj','p.nip = rj.nip and rj.valid_jabatan ="Y"');
		$this->db->join ('position_tbl pt','pt.kd_skpd = rj.kd_skpd and pt.kd_position =rj.position');
		$this->db->where('pt.parent_position',$this->session->userdata('ss_position'));
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
	
	public function penilaianKinerja($nip,$tgl_kegiatan,$kd_skpd,$kd_position){
		
		$this->db->select('pk.kd_uraian, ut.uraian_tupoksi, pk.uraian_kegiatan ,pk.nilai, pk.qid');
		$this->db->from('kegiatan_tbl pk');
		$this->db->join('uraian_tupoksi_tbl ut','ut.kd_skpd = pk.kd_skpd and ut.kd_position = pk.kd_position and ut.id_uraian = pk.kd_uraian');
		$this->db->where('pk.nip',$nip);
		$this->db->where('pk.kd_skpd',$kd_skpd);
		$this->db->where('pk.kd_position',$kd_position);
		$this->db->where('pk.tgl_kegiatan',$tgl_kegiatan);
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function updateByQid($data){
		// get data
		if($data['nilai']==1){
			$this->nilai = 20;
			$this->db->update ('kegiatan_tbl', $this, array ('qid'=>$data['qid']));
		}else if($data['nilai']==2){
			$this->nilai = 40;
			$this->db->update ('kegiatan_tbl', $this, array ('qid'=>$data['qid']));
		}else if($data['nilai']==3){
			$this->nilai = 60;
			$this->db->update ('kegiatan_tbl', $this, array ('qid'=>$data['qid']));
		}else if($data['nilai']==4){
			$this->nilai = 80;
			$this->db->update ('kegiatan_tbl', $this, array ('qid'=>$data['qid']));
		}else if($data['nilai']==5){
			$this->nilai = 100;
			$this->db->update ('kegiatan_tbl', $this, array ('qid'=>$data['qid']));
		}else{
			$this->nilai = $data['nilai'];
		}
		// update data
			
	}
}