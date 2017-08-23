<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class report_collection_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count() {
		return $this->db->count_all("report_collection_tbl");
	}
	
	public function fetchAll($limit, $start) {
		$this->db->select ('*');
		$this->db->from ('report_collection_tbl');
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
	
	public function search($column,$value, $limit, $start){
		
		$this->db->select ('*');
		$this->db->from ('report_collection_tbl');
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
	
	public function rekap_absen_bulanan($data){
		
		$sql = "selects p.nip, p.nama, a.tanggal, 
		case a.absen_pagi when 1 then 'Y' else 'N' end hadir_pagi,CASE a.absen_pagi WHEN 0.5 THEN 'Y' ELSE 'N' END telat_pagi, CASE a.absen_pagi WHEN 0 THEN 'Y' ELSE 'N' END absen_pagi,
		CASE a.absen_siang WHEN 1 THEN 'Y' ELSE 'N' END hadir_siang,CASE a.absen_siang WHEN 0.5 THEN 'Y' ELSE 'N' END telat_siang, CASE a.absen_siang WHEN 0 THEN 'Y' ELSE 'N' END absen_siang,
		CASE a.absen_sore WHEN 1 THEN 'Y' ELSE 'N' END hadir_sore,CASE a.absen_sore WHEN 0.5 THEN 'Y' ELSE 'N' END telat_sore, CASE a.absen_sore WHEN 0 THEN 'Y' ELSE 'N' END absen_sore,
		a.absen_pagi + a.absen_siang + a.absen_sore total_kehadiran,
		case a.attribut when 1 then 'Y' else 'N' end seragam_lengkap,case a.attribut when 0 then 'Y' else 'N' end seragam_tdk_lengkap,
		a.attribut total_seragam,
		a.absen_pagi + a.absen_siang + a.absen_sore + a.attribut total_nilai,
		round(((a.absen_pagi + a.absen_siang + a.absen_sore + a.attribut)/4)*100,2) dlm_persen
		from pegawai_tbl p
		join absensi_tbl a on
		p.nip = a.nip ";
		if($data['tanggal']==''){
			$sql = $sql. " where month(a.tanggal) ='".$data['bulan']."' and year(a.tanggal) ='".$data['tahun']."' ";
		}else{
			$sql = $sql. " where a.tanggal = '".$data['tanggal']."' ";
		}
		
		$sql = $sql." order by a.tanggal ";
		
		$query = $this->db->query($sql);
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function rekap_prilaku_tahunan($data){
		
		$sql = "SELECT p.nip, p.nama, MONTH(pp.tanggal) bulan, YEAR(pp.tanggal) tahun, AVG(pp.disiplin) disiplin, AVG(pp.integritas) integritas, AVG(pp.kepemimpinan) kepemimpinan, AVG(pp.kerjasama) kerjasama, AVG(pp.komitmen) komitmen, AVG(pp.orientasi_pelayanan) orientasi_pelayanan, AVG(pp.guidance) guidance, 
			(AVG(pp.disiplin)+AVG(pp.guidance)+AVG(pp.integritas)+AVG(pp.kepemimpinan)+AVG(pp.kerjasama)+AVG(pp.komitmen)+AVG(pp.orientasi_pelayanan))/7 total_nilai FROM pegawai_tbl p
			LEFT JOIN penilaian_pribadi_tbl pp ON
			p.nip = pp.nip ";
		if($data['nip']==''){
			$sql = $sql." WHERE p.nip = '".$data['nip']."' ";
		}
		$sql = $sql."GROUP BY p.nip, p.nama, MONTH(pp.tanggal), YEAR(pp.tanggal) ";
		
		$query = $this->db->query($sql);
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
}