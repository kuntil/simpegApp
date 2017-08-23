<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class tupoksi extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_tupoksi'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('setup/tupoksi_model' );
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('kd_position','lang:tupoksi_kd_position','max_length[50]');
		$this->form_validation->set_rules('kd_skpd','lang:tupoksi_kd_skpd','max_length[50]');
		$this->form_validation->set_rules('id_tupoksi','lang:tupoksi_id_tupoksi','max_length[50]');
		$this->form_validation->set_rules('aktif', 'lang:pegawai_nama','max_length[1]');
		
		return $this->form_validation->run();
	}
	
	/* Setup Property column */
	public function inputSetting($data){
		$this->data['kd_position'] = array(
				'name'  => 'kd_position',
				'id'    => 'kd_position',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'kode jabatan',
				'value' => $data['kd_position'],
		);
		$this->data['kd_skpd'] = array(
				'name'  => 'kd_skpd',
				'id'    => 'kd_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'kode SKPD',
				'value' => $data['kd_skpd'],
		);
		$this->data['id_tupoksi'] = array(
				'name'  => 'id_tupoksi',
				'id'    => 'id_tupoksi',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'id tupoksi',
				'value' => $data['id_tupoksi'],
		);
		$this->data['tupoksi'] = array(
				'name'  => 'tupoksi',
				'id'    => 'tupoksi',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'tupoksi',
				'value' => $data['tupoksi'],
		);
		$this->data['tahun'] = array(
				'name'  => 'tahun',
				'id'    => 'tahun',
				'type'  => 'number',
				'class' => 'form-control',
				'placeholder'=>'tahun aktif',
				'value' => $data['tahun'],
		);
		$this->data['aktif'] = array(
				'name'  => 'aktif',
				'id'    => 'aktif',
				'class' => 'form-control',
				'placeholder'=>'aktif',
				'value' => $data['aktif'],
		);
		return $this->data;
	}
	
	public function index() {
		
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */

			$config = array ();
			$config ["base_url"] = base_url () . "setup/tupoksi/index";
			$config ["total_rows"] = $this->tupoksi_model->record_count ();
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
			
			$this->data ['tupoksi'] = $this->tupoksi_model->fetchAll($config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/tupoksi/index', $this->data);
		}
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'kd_position'=>$this->input->post('kd_position'),
						'kd_skpd'=>$this->input->post('kd_skpd'),
						'id_tupoksi'=>$this->input->post('id_tupoksi'),
						'tupoksi'=>$this->input->post('tupoksi'),
						'tahun'=>$this->input->post('tahun'),
						'aktif'=>$this->input->post ('aktif')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'tupoksi','add') == true ){
					$message = $this->tupoksi_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/tupoksi/index','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/tupoksi/index','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/tupoksi/add', 'refresh');
			}
			
		} else {
			$data = array(
					'kd_position'=>null,
					'kd_skpd'=>null,
					'id_tupoksi'=>null,
					'tupoksi'=>null,
					'dasar_hukum'=>null,
					'tahun'=>null,
					'aktif'=>null
			);
			$this->template->admin_render('setup/tupoksi/form',$this->inputSetting($data));
		}
	}
	
	public function modify($id=null,$id2=null,$id3=null) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'kd_position'=>$this->input->post('kd_position'),
					'kd_skpd'=>$this->input->post('kd_skpd'),
					'id_tupoksi'=>$this->input->post('id_tupoksi'),
					'tupoksi'=>$this->input->post('tupoksi'),
					'tahun'=>$this->input->post('tahun'),
					'aktif'=>$this->input->post ('aktif')
				);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'tupoksi','modify') == true ){
				$message = $this->tupoksi_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/tupoksi','refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/tupoksi/index','refresh');
			}
		} else {
			$query = $this->tupoksi_model->fetchById($id,$id2,$id3);
			foreach ($query as $row){
				$this->template->admin_render('setup/tupoksi/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($id=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'tupoksi','add') == true ){
			$message = $this->tupoksi_model->delete($id);
			$this->session->set_flashdata('message', $message);
			redirect ('setup/tupoksi/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect('setup/tupoksi/index','refresh');
		}
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
			$config ["base_url"] = base_url () . "setup/tupoksi/find";
			$config ["total_rows"] = $this->tupoksi_model->search_count($column,$query);
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
				
			$this->data ['tupoksi'] = $this->tupoksi_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/tupoksi/index', $this->data);
		}
	}
	
	public function uploadImgae(){
		
	}
	
}