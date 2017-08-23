<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class penilaian_prilaku_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count($nip) {
		$this->db->select ('*');
		$this->db->from ('penilaian_pribadi_tbl pp');
		$this->db->where('pp.nip',$this->session->userdata('ss_position'));
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function fetchByMonthAll($nip,$skpd,$position,$bln_aktifitas){
		$query = $this->db->query('select pk.nip, pt.nama, month(pk.tgl_kegiatan) bulan,sum(pk.nilai)/(select count(pk.nilai) from penilaian_kinerja_tbl p where month(p.tgl_kegiatan)='.$bln_aktifitas.')*100 persentase
				from penilaian_kinerja_tbl pk join pegawai_tbl pt on pt.nip = pk.nip where pk.nip = "'.$nip.'" and pk.kd_skpd ="'.$skpd.'" and pk.kd_position="'.$position.'" and month(pk.tgl_kegiatan)='.$bln_aktifitas.' ');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function fetchByMonth($nip,$skpd,$position,$bln_aktifitas){
		$query = $this->db->query('select pk.nip, pt.nama, month(pk.tgl_kegiatan) bulan,sum(pk.nilai)/(select count(pk.nilai) from penilaian_kinerja_tbl p where month(p.tgl_kegiatan)='.$bln_aktifitas.')*100 persentase 
				from penilaian_kinerja_tbl pk join pegawai_tbl pt on pt.nip = pk.nip where pk.nip = "'.$nip.'" and pk.kd_skpd ="'.$skpd.'" and pk.kd_position="'.$position.'" and month(pk.tgl_kegiatan)='.$bln_aktifitas.' ');
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function fetchByDate($nip,$skpd,$position,$bln_aktifitas,$limit, $start){
		$query = $this->db->query('select pk.tgl_kegiatan, pk.id_uraian, ut.uraian_tupoksi, pk.nilai, (pk.nilai/1)*100 persentase from penilaian_kinerja_tbl pk
				JOIN uraian_tupoksi_tbl ut on
				pk.kd_skpd = ut.kd_skpd and pk.kd_position = ut.kd_position and pk.id_tupoksi = ut.id_tupoksi and pk.id_uraian = ut.id_uraian
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
		$this->nip = $data['nip'];
		$this->tanggal = $data['tanggal'];
		$this->orientasi_pelayanan = $data['orientasi_pelayanan'];
		$this->integritas = $data['integritas'];
		$this->komitmen = $data['komitmen'];
		$this->disiplin = $data['disiplin'];
		$this->kerjasama = $data['kerjasama'];
		$this->kepemimpinan = $data['kepemimpinan'];
		$this->guidance = $data['guidance'];
		
		// insert data
		$this->db->insert('penilaian_pribadi_tbl', $this);
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
}