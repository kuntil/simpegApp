<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_kepangkatan extends Admin_Controller {
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
		$this->load->model ('setup/riwayat_kepangkatan_model' );
		$this->load->model ('setup/pegawai_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:riwayat_nip','max_length[50]');
		$this->form_validation->set_rules('tmt_pangkat', 'lang:riwayat_tmt_pangkat','max_length[50]');
		$this->form_validation->set_rules('no_surat_kerja', 'lang:riwayat_no_surat_kerja','max_length[50]');
		$this->form_validation->set_rules('tgl_surat_kerja', 'lang:riwayat_tgl_surat_kerja','max_length[50]');
		$this->form_validation->set_rules('mk_bulan', 'lang:riwayat_mk_bulan','max_length[50]');
		$this->form_validation->set_rules('mk_tahun', 'lang:riwayat_mk_tahun','max_length[50]');
		
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
		$this->data['golongan'] = array(
				'name'  => 'golongan',
				'id'    => 'golongan',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'golongan',
				'value' => $data['golongan'],
		);
		$this->data['tmt_pangkat'] = array(
				'name'  => 'tmt_pangkat',
				'id'    => 'tmt_pangkat',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal akhir di tetapkan',
				'value' => $data['tmt_pangkat'],
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
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal surat kerja',
				'value' => $data['tgl_surat_kerja'],
		);
		$this->data['mk_bulan'] = array(
				'name'  => 'mk_bulan',
				'id'    => 'mk_bulan',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'mk bulan',
				'value' => $data['mk_bulan'],
		);
		$this->data['mk_tahun'] = array(
				'name'  => 'mk_tahun',
				'id'    => 'mk_tahun',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'mk tahun',
				'value' => $data['mk_tahun'],
		);
		return $this->data;
	}
	
	public function index() {
		$nip = null;
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
		/* Get all users */
		
		$config = array ();
		$config ["base_url"] = base_url () . "setup/riwayat_kepangkatan/index";
		$config ["total_rows"] = $this->riwayat_kepangkatan_model->record_count($nip);
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
				$this->data ['riwayat'] = $this->riwayat_kepangkatan_model->fetchAll($config ["per_page"], $page,$nip);
				$this->data ['links'] = $this->pagination->create_links ();
				$this->template->admin_render('setup/riwayat_kepangkatan/index', $this->data);
			}
		}else{
			$this->data['riwayat']=null;
			$this->data['links']=null;
			$this->template->admin_render('setup/riwayat_kepangkatan/index', $this->data);
		}
				
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>trim($this->input->post('nip')),
						'seq_no'=>$this->riwayat_kepangkatan_model->generateSeqNo(trim($this->input->post('nip'))),
						'golongan'=>$this->input->post ('golongan'),
						'tmt_pangkat'=>$this->input->post ('tmt_pangkat'),
						'no_surat_kerja'=>$this->input->post ('no_surat_kerja'),
						'tgl_surat_kerja'=>$this->input->post ('tgl_surat_kerja'),
						'mk_bulan'=>$this->input->post ('mk_bulan'),
						'mk_tahun'=>$this->input->post ('mk_tahun')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_kepangkatan','add') == true ){
					$message = $this->riwayat_kepangkatan_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/riwayat_kepangkatan','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/riwayat_kepangkatan/index','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/riwayat_kepangkatan/add', 'refresh');
			}
			
		} else {
			$data = array(
					'nip'=>$this->session->userdata('nip'),
					'nama'=>$this->pegawai_model->getName($this->session->userdata('nip')),
					'seq_no'=>null,
					'golongan'=>null,
					'tmt_pangkat'=>null,
					'no_surat_kerja'=>null,
					'tgl_surat_kerja'=>null,
					'mk_bulan'=>null,
					'mk_tahun'=>null
			);
			$this->template->admin_render('setup/riwayat_kepangkatan/form',$this->inputSetting($data));
		}
	}
	
	public function modify($nip,$seq_no) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'nip'=>$nip,
					'seq_no'=>$seq_no,
					'golongan'=>$this->input->post ('golongan'),
					'tmt_pangkat'=>$this->input->post ('tmt_pangkat'),
					'no_surat_kerja'=>$this->input->post ('no_surat_kerja'),
					'tgl_surat_kerja'=>$this->input->post ('tgl_surat_kerja'),
					'mk_bulan'=>$this->input->post ('mk_bulan'),
					'mk_tahun'=>$this->input->post ('mk_tahun')
				);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_kepangkatan','modify') == true ){
				$message = $this->riwayat_kepangkatan_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/riwayat_kepangkatan/index','refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/riwayat_kepangkatan/index','refresh');
			}
		} else {
			$query = $this->riwayat_kepangkatan_model->fetchById($nip,$seq_no);
			foreach ($query as $row){
				$this->template->admin_render('setup/riwayat_kepangkatan/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($nip=null,$seq_no=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_kepangkatan','delete') == true ){
			$message = $this->riwayat_kepangkatan_model->delete($nip,$seq_no);
			$this->session->set_flashdata('message', $message);
			redirect ('setup/riwayat_kepangkatan/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect('setup/riwayat_kepangkatan/index','refresh');
		}
	}
	
	public function find(){
		
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else {
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */
		
			$config = array ();
			$config ["base_url"] = base_url () . "setup/riwayat_kepangkatan/find";
			$config ["total_rows"] = $this->riwayat_kepangkatan_model->search_count($column,$query);
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
				
			$this->data ['riwayat'] = $this->riwayat_kepangkatan_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/riwayat_kepangkatan/index', $this->data);
		}
	}
	
	public function getChild(){
		
	}
	
}