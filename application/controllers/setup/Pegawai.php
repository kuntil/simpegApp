<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class pegawai extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_pegawai'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('setup/pegawai_model' );
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:pegawai_nip','max_length[50]');
		$this->form_validation->set_rules('nip_lama', 'lang:pegawai_nip_lama','max_length[50]');
		$this->form_validation->set_rules('nama', 'lang:pegawai_nama','max_length[100]');
		$this->form_validation->set_rules('gelar_depan', 'lang:gelar_depan', 'max_length[25]');
		$this->form_validation->set_rules('gelar_belakang', 'lang:gelar_belakang', 'max_length[25]');
		$this->form_validation->set_rules('tempat_lahir', 'lang:pegawai_tempat_lahir', 'required|max_length[50]');
		$this->form_validation->set_rules('telp', 'lang:pegawai_telp', 'max_length[50]');
		$this->form_validation->set_rules('kelamin', 'lang:pegawai_kelamin', 'required|max_length[1]');
		$this->form_validation->set_rules('agama', 'lang:pegawai_agama', 'required|max_length[1]');
		$this->form_validation->set_rules('alamat', 'lang:pegawai_alamat', 'max_length[2000]');
		$this->form_validation->set_rules('kode_pos', 'lang:pegawai_kode_pos', 'max_length[11]');
		$this->form_validation->set_rules('gol_darah', 'lang:pegawai_gol_darah', 'max_length[1]');
		$this->form_validation->set_rules('status', 'lang:pegawai_status', 'max_length[1]');
		
		return $this->form_validation->run();
	}
	
	/* Setup Property column */
	public function inputSetting($data){
		$this->data['nip'] = array(
				'name'  => 'nip',
				'id'    => 'nip',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'nomor induk pegawai',
				'value' => $data['nip'],
		);
		$this->data['nip_lama'] = array(
				'name'  => 'nip_lama',
				'id'    => 'nip_lama',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'nomor induk pegawai lama ',
				'value' => $data['nip_lama'],
		);
		$this->data['nama'] = array(
				'name'  => 'nama',
				'id'    => 'nama',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'gelar di depan',
				'value' => $data['nama'],
		);
		$this->data['gelar_depan'] = array(
				'name'  => 'gelar_depan',
				'id'    => 'gelar_depan',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'gelar di depan',
				'value' => $data['gelar_depan'],
		);
		$this->data['gelar_belakang'] = array(
				'name'  => 'gelar_belakang',
				'id'    => 'gelar_belakang',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'gelar di belakang',
				'value' => $data['gelar_belakang'],
		);
		$this->data['tempat_lahir'] = array(
				'name'  => 'tempat_lahir',
				'id'    => 'tempat_lahir',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'placeholder'=>'Tempat kelahiran sesuai ktp',
				'value' => $data['tempat_lahir'],
		);
		$this->data['tgl_lahir'] = array(
				'name'  => 'tgl_lahir',
				'id'    => 'tgl_lahir',
				'type'  => 'text',
				'class' => 'form-control',
				'required'=> 'required',
				'value' => $data['tgl_lahir'],
		);
		$this->data['telp'] = array(
				'name'  => 'telp',
				'id'    => 'telp',
				'type'  => 'number',
				'class' => 'form-control',
				'pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$',
				'placeholder'=>'nomor yang bisa di hubungi',
				'value' => $data['telp'],
		);
		$this->data['kelamin'] = array(
				'name'  => 'kelamin',
				'id'    => 'kelamin',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kelamin'],
		);
		$this->data['agama'] = array(
				'name'  => 'agama',
				'id'    => 'agama',
				'class' => 'form-control',
				'value' => $data['agama'],
		);
		$this->data['alamat'] = array(
				'name'  => 'alamat',
				'id'    => 'alamat',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'Alamat sesuai dengan ktp',
				'value' => $data['alamat'],
		);
		$this->data['kode_pos'] = array(
				'name'  => 'kode_pos',
				'id'    => 'kode_pos',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'kode pos sesuai dengan ktp',
				'value' => $data['kode_pos'],
		);
		$this->data['gol_darah'] = array(
				'name'  => 'gol_darah',
				'id'    => 'gol_darah',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['gol_darah'],
		);
		$this->data['status'] = array(
				'name'  => 'status',
				'id'    => 'status',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['status'],
		);
		$this->data['no_kartu_pegawai'] = array(
				'name'  => 'no_kartu_pegawai',
				'id'    => 'no_kartu_pegawai',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'nomor kartu pegawai',
				'value' => $data['no_kartu_pegawai'],
		);
		$this->data['no_taspen'] = array(
				'name'  => 'no_taspen',
				'id'    => 'no_taspen',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'Nomor tabungan pensiun',
				'value' => $data['no_taspen'],
		);
		$this->data['npwp'] = array(
				'name'  => 'npwp',
				'id'    => 'npwp',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'Nomor pokok wajib pajak',
				'value' => $data['npwp'],
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
			$config ["base_url"] = base_url () . "setup/pegawai/index";
			$config ["total_rows"] = $this->pegawai_model->record_count ();
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
			
			$this->data ['pegawai'] = $this->pegawai_model->fetchAll($config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/pegawai/index', $this->data);
		}
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>$this->input->post('nip'),
						'nip_lama'=>$this->input->post ('nip_lama'),
						'nama'=>$this->input->post ('nama'),
						'gelar_depan'=>$this->input->post ('gelar_depan'),
						'gelar_belakang'=>$this->input->post ('gelar_belakang'),
						'tempat_lahir'=>$this->input->post ('tempat_lahir'),
						'tgl_lahir'=>$this->input->post ('tgl_lahir'),
						'telp'=>$this->input->post ('telp'),
						'kelamin'=>$this->input->post ('kelamin'),
						'agama'=>$this->input->post ('agama'),
						'alamat'=>$this->input->post ('alamat'),
						'kode_pos'=>$this->input->post ('kode_pos'),
						'gol_darah'=>$this->input->post ('gol_darah'),
						'status'=>$this->input->post ('status'),
						'no_kartu_pegawai'=>$this->input->post ('no_kartu_pegawai'),
						'no_taspen'=>$this->input->post ('no_taspen'),
						'no_kk'=>$this->input->post ('no_kk'),
						'npwp'=>$this->input->post ('npwp')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'pegawai','add') == true ){
					$message = $this->pegawai_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('setup/pegawai','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('setup/pegawai','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/pegawai/add', 'refresh');
			}
			
		} else {
			$data = array(
					'nip'=>null,
					'nip_lama'=>null,
					'nama'=>null,
					'gelar_depan'=>null,
					'gelar_belakang'=>null,
					'tempat_lahir'=>null,
					'tgl_lahir'=>null,
					'telp'=>null,
					'kelamin'=>null,
					'agama'=>null,
					'alamat'=>null,
					'kode_pos'=>null,
					'gol_darah'=>null,
					'status'=>null,
					'no_kartu_pegawai'=>null,
					'no_taspen'=>null,
					'no_kk'=>null,
					'npwp'=>null
			);
			$this->template->admin_render('setup/pegawai/form',$this->inputSetting($data));
		}
	}
	
	public function modify($id=null) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>$this->input->post('nip'),
						'nip_lama'=>$this->input->post('nip_lama'),
						'nama'=>$this->input->post('nama'),
						'gelar_depan'=>$this->input->post('gelar_depan'),
						'gelar_belakang'=>$this->input->post('gelar_belakang'),
						'tempat_lahir'=>$this->input->post('tempat_lahir'),
						'tgl_lahir'=>$this->input->post ('tgl_lahir'),
						'telp'=>$this->input->post('telp'),
						'kelamin'=>$this->input->post('kelamin'),
						'agama'=>$this->input->post('agama'),
						'alamat'=>$this->input->post('alamat'),
						'kode_pos'=>$this->input->post('kode_pos'),
						'gol_darah'=>$this->input->post('gol_darah'),
						'status'=>$this->input->post('status'),
						'no_kartu_pegawai'=>$this->input->post('no_kartu_pegawai'),
						'no_taspen'=>$this->input->post('no_taspen'),
						'npwp'=>$this->input->post('npwp')
				);
			}
			if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'pegawai','modify') == true ){
				$message = $this->pegawai_model->update($data);
				$this->session->set_flashdata('message', $message);
				redirect('setup/pegawai','refresh');
			}else{
				$this->session->set_flashdata('message',"The user can not access to perform actions.");
				redirect('setup/pegawai','refresh');
			}
		} else {
			$query = $this->pegawai_model->fetchById($id);
			foreach ($query as $row){
				$this->template->admin_render('setup/pegawai/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($id=null) {
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'pegawai','delete') == true ){
			$message = $this->pegawai_model->delete($id);
			$this->session->set_flashdata('message', $message);
			redirect('setup/pegawai/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect('setup/pegawai/index','refresh');
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
			$config ["base_url"] = base_url () . "setup/pegawai/find";
			$config ["total_rows"] = $this->pegawai_model->search_count($column,$query);
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
				
			$this->data ['pegawai'] = $this->pegawai_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/pegawai/index', $this->data);
		}
	}
	
	public function upload(){
		
		$config['upload_path']          =  realpath('C:\xampp\htdocs\simpegApp\upload\pegawai');
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$config['file_name']			= trim($this->session->userdata('ss_nip'))."".date('dmyHis');
		
		
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('userfile')){
			$message = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('message', $message['error']);
			redirect('member/dashboard/','refresh');
		}
		else{
			$ext = $this->upload->data('file_ext');
			$data = array (
				'nama'=>$config['file_name'].''.$ext,
				'nip'=>$this->session->userdata('ss_nip')
			);
			$this->pegawai_model->upload($data);
			$this->session->set_flashdata('message', "successful upload");
			redirect('member/dashboard/','refresh');
		}
	}
	
}