<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class staff_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	public function record_count() {
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
	
	public function fetchById($id){
		$this->db->select ('p.nip, p.nama, p.kelamin, pt.kd_skpd, pt.kd_position, pt.nama nama_position');
		$this->db->from ('pegawai_tbl p');
		$this->db->join ('riwayat_jabatan_tbl rj','p.nip = rj.nip and rj.valid_jabatan ="Y"');
		$this->db->join ('position_tbl pt','pt.kd_skpd = rj.kd_skpd and pt.kd_position =rj.position');
		$this->db->where('pt.parent_position',$this->session->userdata('ss_position'));
		$this->db->where('p.nip',$id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	public function create($data) {
		$this->kd_skpd = $data['kd_skpd'];
		$this->nama = $data['nama'];
		
		// insert data
		$this->db->insert('skpd_tbl', $this);
	}

	public function update($data) {
		// get data
		$this->nama = $data['nama'];;
		
		// update data
		$this->db->update ('skpd_tbl', $this, array ('kd_skpd' => $data['kd_skpd']));
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
	
	public function penilaianHarian(){
		$this->db->select('p.nip, p.nama, pt.nama nama_position, pk.tgl_kegiatan, round(sum(pk.nilai)/count(pk.nilai)*100) nilai_kinerja,round(((pp.orientasi_pelayanan + pp.integritas + pp.komitmen + pp.disiplin + pp.kerjasama + pp.kepemimpinan + pp.guidance)/700)*100) nilai_prilaku');
		$this->db->from('pegawai_tbl p');
		$this->db->join('riwayat_jabatan_tbl rj','p.nip = rj.nip AND rj.valid_jabatan ="Y"');
		$this->db->join('position_tbl pt','pt.kd_skpd = rj.kd_skpd AND pt.kd_position =rj.position');
		$this->db->join('penilaian_kinerja_tbl pk','pk.nip = p.nip and pk.kd_skpd = rj.kd_skpd and pk.kd_position = rj.position','left');
		$this->db->join('penilaian_pribadi_tbl pp','pk.nip = pp.nip and pk.tgl_kegiatan = pp.tanggal and pk.kd_skpd = pp.kd_skpd and pk.kd_position = pp.kd_position','left');
		$this->db->where('pt.parent_position',$this->session->userdata('ss_position'));
		$this->db->where('pk.tgl_kegiatan','2016-11-01');
		$this->db->group_by('p.nip, pk.tgl_kegiatan');
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function rekapPenilaianBulanan($bulan){
		
		$this->db->select('p.nip, p.nama, pt.nama nama_position,
			get_nilai_absensi(p.nip,'.$bulan.') nilai_absensi,
			get_nilai_pola(p.nip,'.$bulan.') nilai_pola,
			get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.$bulan.'") nilai_prilaku,
			get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.$bulan.'") nilai_kinerja,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.$bulan.'")*40)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.$bulan.'")*30)/100 +
			(get_nilai_pola(p.nip,"'.$bulan.'")*10)/100 + (get_nilai_absensi(p.nip,"'.$bulan.'")*20/100)),2) total,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.$bulan.'")*40)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.$bulan.'")*30)/100 +
			(get_nilai_pola(p.nip,"'.$bulan.'")*10)/100 + (get_nilai_absensi(p.nip,"'.$bulan.'")*20/100))* g.jml_diterima/100,2) thp
		');
		$this->db->from('pegawai_tbl p');
		$this->db->join('riwayat_jabatan_tbl rj','p.nip = rj.nip AND rj.valid_jabatan ="Y"');
		$this->db->join('position_tbl pt','pt.kd_skpd = rj.kd_skpd AND pt.kd_position =rj.position');
		$this->db->join('riwayat_kepangkatan_tbl rk','rk.nip = p.nip','left');
		$this->db->join('group_golongan_tbl gg','gg.id_golongan = rk.golongan','left');
		$this->db->join('golongan_tbl g','g.id_golongan = gg.id_gol','left');
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function penilaianBulanan(){
		$this->db->select('p.nip, p.nama, pt.nama nama_position,
			get_nilai_absensi(p.nip,'.date('m').') nilai_absensi,
			get_nilai_pola(p.nip,'.date('m').') nilai_pola,
			get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'") nilai_prilaku,
			get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'") nilai_kinerja,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*40)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*30)/100 +
			(get_nilai_pola(p.nip,"'.date('m').'")*10)/100 + (get_nilai_absensi(p.nip,"'.date('m').'")*20/100)),2) total,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*40)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*30)/100 +
			(get_nilai_pola(p.nip,"'.date('m').'")*10)/100 + (get_nilai_absensi(p.nip,"'.date('m').'")*20/100))* g.jml_diterima/100,2) thp
		');	
		$this->db->from('pegawai_tbl p');
		$this->db->join('riwayat_jabatan_tbl rj','p.nip = rj.nip AND rj.valid_jabatan ="Y"');
		$this->db->join('position_tbl pt','pt.kd_skpd = rj.kd_skpd AND pt.kd_position =rj.position');
		$this->db->join('riwayat_kepangkatan_tbl rk','rk.nip = p.nip','left');
		$this->db->join('group_golongan_tbl gg','gg.id_golongan = rk.golongan','left');
		$this->db->join('golongan_tbl g','g.id_golongan = gg.id_gol','left');
		$this->db->where('pt.parent_position',$this->session->userdata('ss_position'));
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function penilaianBulananBPKAD(){
		$this->db->select('p.nip, p.nama, ifnull(p.picture,"default.png") picture, pt.nama nama_position,
			get_nilai_absensi(p.nip,'.date('m').') nilai_absensi,
			get_nilai_pola(p.nip,'.date('m').') nilai_pola,
			get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'") nilai_prilaku,
			get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'") nilai_kinerja,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*60)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*40)/100 ),2) total,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*40)/100  +
			(get_nilai_pola(p.nip,"'.date('m').'")*20)/100 + (get_nilai_absensi(p.nip,"'.date('m').'")*40/100))* g.jml_diterima/100,2) thp
		');
		$this->db->from('pegawai_tbl p');
		$this->db->join('riwayat_jabatan_tbl rj','p.nip = rj.nip AND rj.valid_jabatan ="Y"','left');
		$this->db->join('position_tbl pt','pt.kd_skpd = rj.kd_skpd AND pt.kd_position =rj.position','left');
		$this->db->join('riwayat_kepangkatan_tbl rk','rk.nip = p.nip','left');
		$this->db->join('group_golongan_tbl gg','gg.id_golongan = rk.golongan','left');
		$this->db->join('golongan_tbl g','g.id_golongan = gg.id_gol','left');
		$this->db->where('p.nip !=',$this->session->userdata('ss_nip'));
		$query = $this->db->get();
		if ($query->num_rows()> 0) {
			foreach ( $query->result() as $row ) {
				$data [] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function recordCountPenilaianBulananBPKAD(){
		$this->db->select('p.nip, p.nama, pt.nama nama_position,
			get_nilai_absensi(p.nip,'.date('m').') nilai_absensi,
			get_nilai_pola(p.nip,'.date('m').') nilai_pola,
			get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'") nilai_prilaku,
			get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'") nilai_kinerja,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*40)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*30)/100 +
			(get_nilai_pola(p.nip,"'.date('m').'")*10)/100 + (get_nilai_absensi(p.nip,"'.date('m').'")*20/100)),2) total,
			round(((get_nilai_kinerja(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*40)/100 + (get_nilai_prilaku(p.nip, rj.kd_skpd, rj.position,"'.date('m').'")*30)/100 +
			(get_nilai_pola(p.nip,"'.date('m').'")*10)/100 + (get_nilai_absensi(p.nip,"'.date('m').'")*20/100))* g.jml_diterima/100,2) thp
		');
		$this->db->from('pegawai_tbl p');
		$this->db->join('riwayat_jabatan_tbl rj','p.nip = rj.nip AND rj.valid_jabatan ="Y"');
		$this->db->join('position_tbl pt','pt.kd_skpd = rj.kd_skpd AND pt.kd_position =rj.position');
		$this->db->join('riwayat_kepangkatan_tbl rk','rk.nip = p.nip','left');
		$this->db->join('group_golongan_tbl gg','gg.id_golongan = rk.golongan','left');
		$this->db->join('golongan_tbl g','g.id_golongan = gg.id_gol','left');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function penilaianPrilakuHarian(){
		$nilai = 0;
		$this->db->select('IFNULL(get_nilai_prilaku_harian(rj.nip,rj.kd_skpd,rj.position,'.date('Y-m-d').'),0) nilai_prilaku');
		$this->db->from('riwayat_jabatan_tbl rj');
		$this->db->where('rj.nip',$this->session->userdata('ss_nip'));
		$this->db->where('rj.kd_skpd',$this->session->userdata('ss_skpd'));
		$this->db->where('rj.valid_jabatan','Y');
		$query = $this->db->get();
		foreach ( $query->result() as $row ) {
			$nilai = $row->nilai_prilaku;
		}
		return $nilai;
	}
	
	public function penilaianKinerjaHarian(){
		$nilai = 0;
		$this->db->select('IFNULL(get_nilai_kinerja_harian(rj.nip,rj.kd_skpd,rj.position,'.date('Y-m-d').'),0) nilai_kinerja');
		$this->db->from('riwayat_jabatan_tbl rj');
		$this->db->where('rj.nip',$this->session->userdata('ss_nip'));
		$this->db->where('rj.kd_skpd',$this->session->userdata('ss_skpd'));
		$this->db->where('rj.valid_jabatan','Y');
		$query = $this->db->get();
		foreach ( $query->result() as $row ) {
			$nilai = $row->nilai_kinerja;
		}
		return $nilai;
	}
	
	public function penilaianAbsensiHarian(){
		$nilai = 0;
		$this->db->select('IFNULL(get_nilai_absensi_harian(rj.nip, '.date('Y-m-d').'),0) nilai_absensi');
		$this->db->from('riwayat_jabatan_tbl rj');
		$this->db->where('rj.nip',$this->session->userdata('ss_nip'));
		$this->db->where('rj.kd_skpd',$this->session->userdata('ss_skpd'));
		$this->db->where('rj.valid_jabatan','Y');
		$query = $this->db->get();
		foreach ( $query->result() as $row ) {
			$nilai = $row->nilai_absensi;
		}
		return $nilai;
	}
	
}