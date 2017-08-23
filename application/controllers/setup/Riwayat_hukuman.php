<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_hukuman extends Admin_Controller {
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
		$this->load->model ('setup/riwayat_hukuman_model' );
		$this->load->model ('setup/pegawai_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:riwayat_nip','max_length[50]');
		$this->form_validation->set_rules('hukuman', 'lang:riwayat_hukuman','max_length[50]');
		$this->form_validation->set_rules('uraian_hukum', 'lang:riwayat_uraian_hukum','max_length[50]');
		$this->form_validation->set_rules('no_surat_kerja', 'lang:riwayat_no_surat_kerja','max_length[50]');
		$this->form_validation->set_rules('tql_surat_kerja', 'lang:riwayat_tql_surat_kerja','max_length[50]');
		$this->form_validation->set_rules('pejabat', 'lang:riwayat_pejabat','max_length[50]');
		
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
		$this->data['hukuman'] = array(
				'name'  => 'hukuman',
				'id'    => 'hukuman',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'hukuman',
				'value' => $data['hukuman'],
		);
		$this->data['uraian_hukum'] = array(
				'name'  => 'uraian_hukum',
				'id'    => 'uraian_hukum',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'uraian hukuman',
				'value' => $data['uraian_hukum'],
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
		$this->data['pejabat'] = array(
				'name'  => 'pejabat',
				'id'    => 'pejabat',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'pejabat',
				'value' => $data['pejabat'],
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
			$this->template->admin_render('setup/riwayat_hukuman/index', $this->data);
		}
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
		/* Get all users */
		
		$config = array ();
		$config ["base_url"] = base_url () . "setup/riwayat_hukuman/index";
		$config ["total_rows"] = $this->riwayat_hukuman_model->record_count($nip);
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
		
		$this->data ['riwayat'] = $this->riwayat_hukuman_model->fetchAll($config ["per_page"], $page,$nip);
		$this->data ['links'] = $this->pagination->create_links ();
		$this->template->admin_render('setup/riwayat_hukuman/index', $this->data);
		
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>$this->input->post('nip'),
						'seq_no'=>$this->riwayat_hukuman_model->generateSeqNo($this->input->post('nip')),
						'hukuman'=>$this->input->post ('hukuman'),
						'uraian_hukum'=>$this->input->post ('uraian_hukum'),
						'no_surat_kerja'=>$this->input->post ('no_surat_kerja'),
						'tgl_surat_kerja'=>$this->input->post ('tgl_surat_kerja'),
						'pejabat'=>$this->input->post ('pejabat')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_hukuman','add') == true ){
					$message = $this->riwayat_hukuman_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/riwayat_hukuman','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/riwayat_hukuman/add','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/riwayat_hukuman/add', 'refresh');
			}
			
		} else {
			$data = array(
					'nip'=>$this->session->userdata('nip'),
					'nama'=>$this->pegawai_model->getName($this->session->userdata('nip')),
					'seq_no'=>null,
					'hukuman'=>null,
					'uraian_hukum'=>null,
					'no_surat_kerja'=>null,
					'tgl_surat_kerja'=>null,
					'pejabat'=>null
			);
			$this->template->admin_render('setup/riwayat_hukuman/form',$this->inputSetting($data));
		}
	}
	
	public function modify($nip=null,$seq_no=null) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'nip'=> $this->session->userdata('nip'),
					'seq_no'=>$seq_no,
					'hukuman'=>$this->input->post ('hukuman'),
					'uraian_hukum'=>$this->input->post ('uraian_hukum'),
					'no_surat_kerja'=>$this->input->post ('no_surat_kerja'),
					'tgl_surat_kerja'=>$this->input->post ('tgl_surat_kerja'),
					'pejabat'=>$this->input->post ('pejabat')
				);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_hukuman','modify') == true ){
				$message = $this->riwayat_hukuman_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/riwayat_hukuman/index','refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/riwayat_hukuman/index','refresh');
			}
		} else {
			$query = $this->riwayat_hukuman_model->fetchById( $this->session->userdata('nip'),$seq_no);
			foreach ($query as $row){
				$this->template->admin_render('setup/riwayat_hukuman/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($nip=null,$seq_no=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_hukuman','delete') == true ){
			$message = $this->riwayat_hukuman_model->delete($nip,$seq_no);
			$this->session->set_flashdata('message', $message);
			redirect ('setup/riwayat_hukuman/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect ('setup/riwayat_hukuman/index','refresh');
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
			$config ["base_url"] = base_url () . "setup/riwayat_hukuman/find";
			$config ["total_rows"] = $this->riwayat_hukuman_model->search_count($column,$query);
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
				
			$this->data ['riwayat'] = $this->riwayat_hukuman_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/riwayat_hukuman/index', $this->data);
		}
	}
	
	public function getChild(){
		
	}
	
}