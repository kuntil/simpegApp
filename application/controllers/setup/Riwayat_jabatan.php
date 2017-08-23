<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_jabatan extends Admin_Controller {
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
		$this->load->model ('setup/riwayat_jabatan_model' );
		$this->load->model ('setup/pegawai_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:riwayat_nip','max_length[50]');
		$this->form_validation->set_rules('valid_from', 'lang:riwayat_valid_from','max_length[50]');
		$this->form_validation->set_rules('valid_to', 'lang:riwayat_valid_to','max_length[50]');
		$this->form_validation->set_rules('kd_skpd', 'lang:riwayat_kd_skpd','max_length[50]');
		$this->form_validation->set_rules('position', 'lang:riwayat_position','max_length[50]');
		$this->form_validation->set_rules('esselon', 'lang:riwayat_esselon','max_length[50]');
		$this->form_validation->set_rules('no_sk', 'lang:riwayat_no_sk','max_length[50]');
		$this->form_validation->set_rules('tgl_sk', 'lang:riwayat_tgl_sk','max_length[50]');
		$this->form_validation->set_rules('valid_jabatan', 'lang:riwayat_valid_jabatan','max_length[1]');
		
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
		$this->data['valid_from'] = array(
				'name'  => 'valid_from',
				'id'    => 'valid_from',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal mulai di tetapkan',
				'value' => $data['valid_from'],
		);
		$this->data['valid_to'] = array(
				'name'  => 'valid_to',
				'id'    => 'valid_to',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal akhir di tetapkan',
				'value' => $data['valid_from'],
		);
		$this->data['jenis_jabatan'] = array(
				'name'  => 'jenis_jabatan',
				'id'    => 'jenis_jabatan',
				'class' => 'form-control',
				'placeholder'=>'jenis jabatan',
				'value' => $data['jenis_jabatan'],
		);
		$this->data['kd_skpd'] = array(
				'name'  => 'kd_skpd',
				'id'    => 'kd_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'unit kerja',
				'value' => $data['kd_skpd'],
		);
		$this->data['position'] = array(
				'name'  => 'position',
				'id'    => 'position',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'jabatan',
				'value' => $data['position'],
		);
		$this->data['position_name'] = array(
				'name'  => 'position_name',
				'id'    => 'position_name',
				'type'  => 'text',
				'readonly' => 'readonly',
				'class' => 'form-control',
				'placeholder'=>'nama jabatan',
				'value' => $data['position_name'],
		);
		$this->data['esselon'] = array(
				'name'  => 'esselon',
				'id'    => 'esselon',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'esselon',
				'value' => $data['esselon'],
		);
		$this->data['no_sk'] = array(
				'name'  => 'no_sk',
				'id'    => 'no_sk',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'no surat keputusan',
				'value' => $data['no_sk'],
		);
		$this->data['tgl_sk'] = array(
				'name'  => 'tgl_sk',
				'id'    => 'tgl_sk',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'tanggal surat keputusan',
				'value' => $data['tgl_sk'],
		);
		$this->data['valid_jabatan'] = array(
				'name'  => 'valid_jabatan',
				'id'    => 'valid_jabatan',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'valid',
				'value' => $data['valid_jabatan'],
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
			$this->template->admin_render('setup/riwayat_jabatan/index', $this->data);
		}
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
		/* Get all users */
		
		$config = array ();
		$config ["base_url"] = base_url () . "setup/riwayat_jabatan/index";
		$config ["total_rows"] = $this->riwayat_jabatan_model->record_count($nip);
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
		
		$this->data ['riwayat'] = $this->riwayat_jabatan_model->fetchAll($config ["per_page"], $page,$nip);
		$this->data ['links'] = $this->pagination->create_links ();
		$this->template->admin_render('setup/riwayat_jabatan/index', $this->data);
		
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>trim($this->input->post('nip')),
						'seq_no'=>$this->riwayat_jabatan_model->generateSeqNo(trim($this->input->post('nip'))),
						'valid_from'=>$this->input->post ('valid_from'),
						'valid_to'=>$this->input->post ('valid_to'),
						'kd_skpd'=>$this->input->post ('kd_skpd'),
						'position'=>$this->input->post ('position'),
						'esselon'=>$this->input->post ('esselon'),
						'no_sk'=>$this->input->post ('no_sk'),
						'tgl_sk'=>$this->input->post ('tgl_sk'),
						'valid_jabatan'=>$this->input->post ('valid_jabatan')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_jabatan','add') == true ){
					$message = $this->riwayat_jabatan_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/riwayat_jabatan','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/riwayat_jabatan','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/riwayat_jabatan/add', 'refresh');
			}
			
		} else {
			$data = array(
					'nip'=>$this->session->userdata('nip'),
					'nama'=>$this->pegawai_model->getName($this->session->userdata('nip')),
					'seq_no'=>null,
					'valid_from'=>null,
					'valid_to'=>null,
					'kd_skpd'=>null,
					'position'=>null,
					'jenis_jabatan'=>null,
					'position_name'=>null,
					'esselon'=>null,
					'no_sk'=>null,
					'tgl_sk'=>null,
					'valid_jabatan'=>null
			);
			$this->template->admin_render('setup/riwayat_jabatan/form',$this->inputSetting($data));
		}
	}
	
	public function modify($nip,$seq_no) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'nip'=>$this->input->post('nip'),
					'seq_no'=>$seq_no,
					'valid_from'=>$this->input->post ('valid_from'),
					'valid_to'=>$this->input->post ('valid_to'),
					'kd_skpd'=>$this->input->post ('kd_skpd'),
					'position'=>$this->input->post ('position'),
					'jenis_jabatan'=>$this->input->post('jenis_jabatan'),
					'esselon'=>$this->input->post ('esselon'),
					'no_sk'=>$this->input->post ('no_sk'),
					'tgl_sk'=>$this->input->post ('tgl_sk'),
					'valid_jabatan'=>$this->input->post ('valid_jabatan')
				);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_jabatan','modify') == true ){
				$message = $this->riwayat_jabatan_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/riwayat_jabatan/index','refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/riwayat_jabatan/index','refresh');
			}
		} else {
			$query = $this->riwayat_jabatan_model->fetchById($nip,$seq_no);
			foreach ($query as $row){
				$this->template->admin_render('setup/riwayat_jabatan/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($nip=null,$seq_no=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_jabatan','delete') == true ){
			$message = $this->riwayat_jabatan_model->delete($nip,$seq_no);
			$this->session->set_flashdata('message', $message);
			redirect ('setup/riwayat_jabatan/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect('setup/riwayat_jabatan/index','refresh');
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
			$config ["base_url"] = base_url () . "setup/riwayat_jabatan/find";
			$config ["total_rows"] = $this->riwayat_jabatan_model->search_count($column,$query);
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
				
			$this->data ['riwayat'] = $this->riwayat_jabatan_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/riwayat_jabatan/index', $this->data);
		}
	}
	
	public function getValidPosition($id){
		$this->riwayat_jabatan_model->getValidPosition($id);
	}
	
	public function getChild(){
		
	}
	
}