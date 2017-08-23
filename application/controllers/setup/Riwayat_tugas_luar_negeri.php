<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_tugas_luar_negeri extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_pendidikan'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('setup/riwayat_tugas_luar_negeri_model' );
		$this->load->model ('setup/pegawai_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:riwayat_nip','max_length[50]');
		$this->form_validation->set_rules('jenis_pendidikan', 'lang:riwayat_jenis_pendidikan','max_length[1]');
		$this->form_validation->set_rules('jurusan', 'lang:riwayat_jurusan','max_length[50]');
		$this->form_validation->set_rules('nama_sekolah', 'lang:riwayat_nama_sekolah','max_length[50]');
		$this->form_validation->set_rules('kepala_sekolah', 'lang:riwayat_kepala_sekolah','max_length[50]');
		$this->form_validation->set_rules('no_ijazah', 'lang:riwayat_no_ijazah','max_length[50]');
		$this->form_validation->set_rules('tahun_ijazah', 'lang:riwayat_tahun_ijazah','max_length[50]');
		
		return $this->form_validation->run();
	}
	
	/* Setup Property column */
	public function inputSetting($data){
		$this->data['nip'] = array(
				'name'  => 'nip',
				'id'    => 'nip',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=> 'readonly',
				'placeholder'=>'nomor induk pegawai',
				'value' => $data['nip'],
		);
		$this->data['nama'] = array(
				'name'  => 'nama',
				'id'    => 'nama',
				'type'  => 'text',
				'readonly'=>'readonly',
				'class' => 'form-control',
				'placeholder'=>'Nama Pegawai',
				'value' => $data['nama'],
		);
		$this->data['seq_no'] = array(
				'name'  => 'seq_no',
				'id'    => 'seq_no',
				'type'  => 'number',
				'class' => 'form-control',
				'readonly' => 'readonly',
				'placeholder'=>'sequence no',
				'value' => $data['seq_no'],
		);
		$this->data['tujuan'] = array(
				'name'  => 'tujuan',
				'id'    => 'tujuan',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'tujuan',
				'value' => $data['tujuan'],
		);
		$this->data['jenis_tugas'] = array(
				'name'  => 'jenis_tugas',
				'id'    => 'jenis_tugas',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'jenis tugas',
				'value' => $data['jenis_tugas'],
		);
		$this->data['valid_from'] = array(
				'name'  => 'valid_from',
				'id'    => 'valid_from',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal dimulai tugas',
				'value' => $data['valid_from'],
		);
		$this->data['valid_to'] = array(
				'name'  => 'valid_to',
				'id'    => 'valid_to',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal berakhir tugas',
				'value' => $data['valid_to'],
		);
		$this->data['no_surat_kerja'] = array(
				'name'  => 'no_surat_kerja',
				'id'    => 'no_surat_kerja',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'no surat kerja',
				'value' => $data['no_surat_kerja'],
		);
		$this->data['tgl_surat_kerja'] = array(
				'name'  => 'tgl_surat_kerja',
				'id'    => 'tgl_surat_kerja',
				'type'  => 'number',
				'class' => 'form-control',
				'placeholder'=>'tahun ijazah',
				'value' => $data['tgl_surat_kerja'],
		);
		return $this->data;
	}
	
	public function index() {
		$nip = null;
		if($this->input->post('submit') || $this->session->userdata('nip')) {
			if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
			{
				redirect('auth/login', 'refresh');
			}
			else
			{	$nip_session = $this->session->userdata('nip');
				$nip = $this->input->post('nip');
				if($nip == $nip_session){
					$nip = $this->input->post('nip');
				}else{
					$option = array(
						'nip'=> $this->input->post('nip')
					);
					$this->session->set_userdata($option);
					$nip = $this->input->post('nip');
				}
			}
		}else{
			$this->data['riwayat']=null;
			$this->data['links']=null;
			$this->template->admin_render('setup/riwayat_tugas_luar_negeri/index', $this->data);
		}
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
		/* Get all users */
		
		$config = array ();
		$config ["base_url"] = base_url () . "setup/riwayat_tugas_luar_negeri/index";
		$config ["total_rows"] = $this->riwayat_tugas_luar_negeri_model->record_count($nip);
		$config ["per_page"] = 25;
		$config ["uri_segment"] = 4;
		$choice = $config ["total_rows"] / $config ["per_page"];
		$config ["num_links"] = 5;
		
		// config css for pagination
		$config ['full_tag_open'] = '<ul class="pagination">';
		$config ['full_tag_close'] = '</ul>';
		$config ['first_link'] = 'First';
		$config ['last_link'] = 'Last';
		$config ['first_tag_open'] = '<li>';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="prev">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li>';
		$config ['next_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li>';
		$config ['last_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		
		if ($this->uri->segment ( 4 ) == "") {
			$data ['number'] = 0;
		} else {
			$data ['number'] = $this->uri->segment ( 4 );
		}
		
		$this->pagination->initialize ( $config );
		$page = ($this->uri->segment ( 4 )) ? $this->uri->segment ( 4 ) : 0;
		
		$this->data ['riwayat'] = $this->riwayat_tugas_luar_negeri_model->fetchAll($config ["per_page"], $page,$nip);
		$this->data ['links'] = $this->pagination->create_links ();
		$this->template->admin_render('setup/riwayat_tugas_luar_negeri/index', $this->data);
		
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>$this->input->post('nip'),
						'seq_no'=>$this->riwayat_tugas_luar_negeri_model->generateSeqNo($this->input->post('nip')),
						'tujuan'=>$this->input->post ('tujuan'),
						'jenis_tugas'=>$this->input->post ('jenis_tugas'),
						'valid_from'=>$this->input->post ('valid_from'),
						'valid_to'=>$this->input->post ('valid_to'),
						'no_surat_kerja'=>$this->input->post ('no_surat_kerja'),
						'tgl_surat_kerja'=>$this->input->post ('tgl_surat_kerja'),
						'pejabat'=>$this->input->post ('pejabat')
				);
				$this->riwayat_tugas_luar_negeri_model->create($data);
				redirect('setup/riwayat_tugas_luar_negeri');
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/riwayat_tugas_luar_negeri/add', 'refresh');
			}
			
		} else {
			$data = array(
					'nip'=>$this->session->userdata('nip'),
					'nama'=>$this->pegawai_model->getName($this->session->userdata('nip')),
					'seq_no'=>null,
					'tujuan'=>null,
					'jenis_tugas'=>null,
					'valid_from'=>null,
					'valid_to'=>null,
					'no_surat_kerja'=>null,
					'tgl_surat_kerja'=>null,
					'pejabat'=>null
			);
			$this->template->admin_render('setup/riwayat_tugas_luar_negeri/form',$this->inputSetting($data));
		}
	}
	
	public function modify($nip,$seq_no) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'nip'=>$this->input->post('nip'),
					'seq_no'=>$this->input->post ('seq_no'),
					'tujuan'=>$this->input->post ('tujuan'),
					'jenis_tugas'=>$this->input->post ('jenis_tugas'),
					'valid_from'=>$this->input->post ('valid_from'),
					'valid_to'=>$this->input->post ('valid_to'),
					'no_surat_kerja'=>$this->input->post ('no_surat_kerja'),
					'tgl_surat_kerja'=>$this->input->post ('tgl_surat_kerja'),
					'pejabat'=>$this->input->post ('pejabat')
				);
			}
			$this->riwayat_tugas_luar_negeri_model->update($data);
			redirect('setup/riwayat_tugas_luar_negeri/index','refresh');
		} else {
			$query = $this->riwayat_tugas_luar_negeri_model->fetchById($nip,$seq_no);
			foreach ($query as $row){
				$this->template->admin_render('setup/riwayat_tugas_luar_negeri/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($nip=null,$seq_no=null) {
		$this->riwayat_tugas_luar_negeri_model->delete($nip,$seq_no);
		redirect ('setup/riwayat_tugas_luar_negeri/index','refresh');
	}
	
	public function find(){
		
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else {
			if($this->input->post('submit')){
				$column = $this->input->post('column');
				$query = $this->input->post('data');
				
				$option = array(
					'user_column'=>$column,
					'user_data'=>$query
				);
				$this->session->set_userdata($option);
			}else{
			   $column = $this->session->has_userdata('user_column');
			   $query = $this->session->has_userdata('user_data');
			}
			
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */
		
			$config = array ();
			$config ["base_url"] = base_url () . "setup/riwayat_tugas_luar_negeri/find";
			$config ["total_rows"] = $this->riwayat_tugas_luar_negeri_model->search_count($column,$query);
			$config ["per_page"] = 25;
			$config ["uri_segment"] = 4;
			$choice = $config ["total_rows"] / $config ["per_page"];
			$config ["num_links"] = 5;
				
			// config css for pagination
			$config ['full_tag_open'] = '<ul class="pagination">';
			$config ['full_tag_close'] = '</ul>';
			$config ['first_link'] = 'First';
			$config ['last_link'] = 'Last';
			$config ['first_tag_open'] = '<li>';
			$config ['first_tag_close'] = '</li>';
			$config ['prev_link'] = 'Previous';
			$config ['prev_tag_open'] = '<li class="prev">';
			$config ['prev_tag_close'] = '</li>';
			$config ['next_link'] = 'Next';
			$config ['next_tag_open'] = '<li>';
			$config ['next_tag_close'] = '</li>';
			$config ['last_tag_open'] = '<li>';
			$config ['last_tag_close'] = '</li>';
			$config ['cur_tag_open'] = '<li class="active"><a href="#">';
			$config ['cur_tag_close'] = '</a></li>';
			$config ['num_tag_open'] = '<li>';
			$config ['num_tag_close'] = '</li>';
				
			if ($this->uri->segment ( 4 ) == "") {
				$data ['number'] = 0;
			} else {
				$data ['number'] = $this->uri->segment ( 4 );
			}
				
			$this->pagination->initialize ( $config );
			$page = ($this->uri->segment ( 4 )) ? $this->uri->segment ( 4 ) : 0;
				
			$this->data ['pegawai'] = $this->riwayat_tugas_luar_negeri_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/riwayat_tugas_luar_negeri/index', $this->data);
		}
	}
	
	public function getChild(){
		
	}
	
}