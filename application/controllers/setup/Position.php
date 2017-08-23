<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class position extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_position'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('setup/position_model' );
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('kd_skpd','lang:position_kd_position','max_length[50]');
		$this->form_validation->set_rules('kd_position', 'lang:position_nama','max_length[50]');
		$this->form_validation->set_rules('nama', 'lang:position_nama','max_length[2000]');
		$this->form_validation->set_rules('parent_position', 'lang:position_nama','max_length[50]');
		
		
		return $this->form_validation->run();
	}
	
	/* Setup Property column */
	public function inputSetting($data){
		$this->data['kd_skpd'] = array(
				'name'  => 'kd_skpd',
				'id'    => 'kd_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'kode skpd',
				'value' => $data['kd_skpd'],
		);
		$this->data['nama_skpd'] = array(
				'name'  => 'nama_skpd',
				'id'    => 'nama_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=> 'readonly',
				'placeholder'=>'nama skpd',
				'value' => $data['nama_skpd'],
		);
		$this->data['kd_position'] = array(
				'name'  => 'kd_position',
				'id'    => 'kd_position',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'kode position',
				'value' => $data['kd_position'],
		);
		$this->data['nama'] = array(
				'name'  => 'nama',
				'id'    => 'nama',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'nama jabatan',
				'value' => $data['nama'],
		);
		$this->data['parent_position'] = array(
				'name'  => 'parent_position',
				'id'    => 'parent_position',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'jabatan di bawah',
				'value' => $data['parent_position'],
		);
		$this->data['parent_name'] = array(
				'name'  => 'parent_name',
				'id'    => 'parent_name',
				'type'  => 'text',
				'readonly' => 'readonly',
				'class' => 'form-control',
				'placeholder'=>'nama position',
				'value' => $data['parent_name']
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
			$config ["base_url"] = base_url () . "setup/position/index";
			$config ["total_rows"] = $this->position_model->record_count ();
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
			
			$this->data ['position'] = $this->position_model->fetchAll($config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/position/index', $this->data);
		}
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'kd_skpd'=>$this->input->post('kd_skpd'),
						'kd_position'=>$this->input->post ('kd_position'),
						'nama'=>$this->input->post ('nama'),
						'parent_position'=>$this->input->post ('parent_position'),
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'position','add') == true ){
					$message = $this->position_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/position','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/position/add','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/position/add', 'refresh');
			}
			
		} else {
			$data = array(
					'kd_skpd'=>null,
					'nama_skpd'=>null,
					'kd_position'=>null,
					'nama'=>null,
					'parent_position'=> null,
					'parent_name'=>null
			);
			$this->template->admin_render('setup/position/form',$this->inputSetting($data));
		}
	}
	
	public function modify($id=null,$id2=null) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'kd_skpd'=>$this->input->post('kd_skpd'),
					'nama_skpd'=>null,
					'kd_position'=>$this->input->post ('kd_position'),
					'nama'=>$this->input->post ('nama'),
					'parent_position'=>$this->input->post ('parent_position'),
					'parent_name'=>null
				);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'position','modify') == true ){
				$message = $this->position_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/position','refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/position/modify/'.$id.'/'.$id2,'refresh');
			}
		} else {
			$query = $this->position_model->fetchById($id,$id2);
			foreach ($query as $row){
				$this->template->admin_render('setup/position/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($id=null,$id2=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'position','delete') == true ){
			$message = $this->position_model->delete($id,$id2);
			$this->session->set_flashdata('message', $message);
			redirect ('setup/position/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect ('setup/position/index','refresh');
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
			$config ["base_url"] = base_url () . "setup/position/find";
			$config ["total_rows"] = $this->position_model->search_count($column,$query);
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
				
			$this->data ['position'] = $this->position_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/position/index', $this->data);
		}
	}
	
	public function uploadImgae(){
		
	}
	
}