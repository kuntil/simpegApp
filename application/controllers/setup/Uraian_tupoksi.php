<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class uraian_tupoksi extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_uraian_tupoksi'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('setup/uraian_tupoksi_model' );
		$this->load->model ('setup/tupoksi_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('id_tupoksi','lang:tupoksi_id_tupoksi','max_length[50]');
		$this->form_validation->set_rules('uraian_tupoksi', 'lang:tupoksi_uraian_tupoksi','max_length[2000]');
		return $this->form_validation->run();
	}
	
	/* Setup Property column */
	public function inputSetting($data){
		$this->data['kd_position'] = array(
				'name'  => 'kd_position',
				'id'    => 'kd_position',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=> 'readonly',
				'placeholder'=>'kode jabatan',
				'value' => $data['kd_position'],
		);
		$this->data['kd_skpd'] = array(
				'name'  => 'kd_skpd',
				'id'    => 'kd_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=> 'readonly',
				'placeholder'=>'kode SKPD',
				'value' => $data['kd_skpd'],
		);
		$this->data['id_tupoksi'] = array(
				'name'  => 'id_tupoksi',
				'id'    => 'id_tupoksi',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=>'readonly',
				'placeholder'=>'id tupoksi',
				'value' => $data['id_tupoksi'],
		);
		$this->data['id_tupoksi'] = array(
				'name'  => 'id_tupoksi',
				'id'    => 'id_tupoksi',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=>'readonly',
				'placeholder'=>'id tupoksi',
				'value' => $data['id_tupoksi'],
		);
		$this->data['tupoksi'] = array(
				'name'  => 'tupoksi',
				'id'    => 'tupoksi',
				'type'  => 'text',
				'class' => 'form-control',
				'readonly'=>'readonly',
				'placeholder'=>'Tupoksi',
				'value' => $data['tupoksi'],
		);
		$this->data['id_uraian'] = array(
				'name'  => 'id_uraian',
				'id'    => 'id_uraian',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'id uraian tupoksi',
				'value' => $data['id_uraian'],
		);
		$this->data['uraian_tupoksi'] = array(
				'name'  => 'uraian_tupoksi',
				'id'    => 'uraian_tupoksi',
				'type'  => 'number',
				'class' => 'form-control',
				'placeholder'=>'uraian tupoksi',
				'value' => $data['uraian_tupoksi'],
		);
		$this->data['aktif'] = array(
				'name'  => 'aktif',
				'id'    => 'aktif',
				'class' => 'form-control',
				'placeholder'=>'aktif',
				'value' => $data['aktif'],
		);
		$this->data['jenis_tupoksi'] = array(
				'name'  => 'jenis_tupoksi',
				'id'    => 'jenis_tupoksi',
				'class' => 'form-control',
				'placeholder'=>'jenis tupksi',
				'value' => $data['jenis_tupoksi'],
		);
		return $this->data;
	}
	
	public function index($id=null,$id2=null,$id3=null) {
		
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
			$config ["base_url"] = base_url () . "setup/uraian_tupoksi/index/".$id.'/'.$id2.'/'.$id3;
			$config ["total_rows"] = $this->uraian_tupoksi_model->record_count($id,$id2,$id3);
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
			
			if ($this->uri->segment ( 7 ) == "") {
				$data ['number'] = 0;
			} else {
				$data ['number'] = $this->uri->segment ( 7 );
			}
			
			$this->pagination->initialize ( $config );
			$page = ($this->uri->segment ( 7 )) ? $this->uri->segment ( 7 ) : 0;
			
			$this->data ['data_uraian'] = $this->uraian_tupoksi_model->fetchAll($id,$id2,$id3,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			
			$this->data['kd_position'] = array(
					'name'  => 'kd_position',
					'id'    => 'kd_position',
					'type'  => 'text',
					'class' => 'form-control',
					'required'=> 'required',
					'placeholder'=>'kode jabatan',
					'value' => $id3,
			);
			$this->data['kd_skpd'] = array(
					'name'  => 'kd_skpd',
					'id'    => 'kd_skpd',
					'type'  => 'text',
					'class' => 'form-control',
					'required'=> 'required',
					'placeholder'=>'kode SKPD',
					'value' => $id2,
			);
			
			$this->data['id_tupoksi'] = array(
					'name'  => 'id_uraian_tupoksi',
					'id'    => 'id_uraian_tupoksi',
					'type'  => 'text',
					'class' => 'form-control',
					'readonly'=>'readonly',
					'placeholder'=>'id uraian_tupoksi',
					'value' => $id,
			);
			$this->data['tupoksi'] = array(
					'name'  => 'tupoksi',
					'id'    => 'tupoksi',
					'type'  => 'text',
					'class' => 'form-control',
					'readonly'=>'readonly',
					'placeholder'=>'Tupoksi',
					'value' => $this->tupoksi_model->getName($id,$id2,$id3),
			);
			
			$this->template->admin_render('setup/uraian_tupoksi/index', $this->data);
		}
	}
	
	public function add($id=null,$id2=null,$id3=null){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'kd_skpd'=>$this->input->post('kd_skpd'),
						'kd_position'=>$this->input->post('kd_position'),
						'id_tupoksi'=>$this->input->post('id_tupoksi'),
						'id_uraian'=>$this->input->post('id_uraian'),
						'uraian_tupoksi'=>$this->input->post('uraian_tupoksi'),
						'jenis_tupoksi'=>$this->input->post('jenis_tupoksi'),
						'aktif'=>$this->input->post('aktif')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'uraian_tupoksi','add') == true ){
					$message = $this->uraian_tupoksi_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/uraian_tupoksi/index/'.$id.'/'.$id2.'/'.$id3,'refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/uraian_tupoksi/index','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/uraian_tupoksi/add/'.$id.'/'.$id2.'/'.$id3, 'refresh');
			}
			
		} else {
			$data = array(
					'kd_skpd'=>$id2,
					'kd_position'=>$id3,
					'id_tupoksi'=>$id,
					'tupoksi'=>$this->tupoksi_model->getName($id,$id2,$id3),
					'id_uraian'=>null,
					'uraian_tupoksi'=>null,
					'jenis_tupoksi'=>null,
					'aktif'=>null
			);
			$this->template->admin_render('setup/uraian_tupoksi/form',$this->inputSetting($data));
		}
	}
	
	public function modify($id=null,$id2=null,$id3=null,$id4=null) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'kd_skpd'=>$this->input->post('kd_skpd'),
						'kd_position'=>$this->input->post('kd_position'),
						'id_tupoksi'=>$this->input->post('id_tupoksi'),
						'id_uraian'=>$this->input->post('id_uraian'),
						'uraian_tupoksi'=>$this->input->post('uraian_tupoksi'),
						'jenis_tupoksi'=>$this->input->post('jenis_tupoksi'),
						'aktif'=>'Y'
						);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'uraian_tupoksi','modify') == true ){
				$message = $this->uraian_tupoksi_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/uraian_tupoksi/index/'.$id.'/'.$id2.'/'.$id3,'refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/uraian_tupoksi/index','refresh');
			}
		} else {
			$query = $this->uraian_tupoksi_model->fetchById($id,$id2,$id3,$id4);
			foreach ($query as $row){
				$this->template->admin_render('setup/uraian_tupoksi/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($id=null,$id2=null,$id3=null,$id4=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'riwayat_penghargaan','delete') == true ){
			$message = $this->uraian_tupoksi_model->delete($id,$id2,$id3,$id4);
			$this->session->set_flashdata('message', $message);
			redirect('setup/uraian_tupoksi/index/'.$id.'/'.$id2.'/'.$id3,'refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect('setup/uraian_tupoksi/index','refresh');
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
			$config ["base_url"] = base_url () . "setup/uraian_tupoksi/find";
			$config ["total_rows"] = $this->uraian_uraian_tupoksi_model->search_count($column,$query);
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
				
			$this->data ['uraian_tupoksi'] = $this->uraian_tupoksi_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/uraian_tupoksi/index', $this->data);
		}
	}
	
	public function uploadImgae(){
		
	}
	
}