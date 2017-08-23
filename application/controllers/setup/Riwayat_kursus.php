<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class riwayat_kursus extends Admin_Controller {
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
		$this->load->model ('setup/riwayat_kursus_model' );
		$this->load->model ('setup/pegawai_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:riwayat_nip','max_length[50]');
		$this->form_validation->set_rules('valid_from', 'lang:riwayat_valid_from','max_length[1]');
		$this->form_validation->set_rules('valid_to', 'lang:riwayat_valid_to','max_length[50]');
		$this->form_validation->set_rules('unit_kerja', 'lang:riwayat_unit_kerja','max_length[50]');
		$this->form_validation->set_rules('jenis_jabatan', 'lang:riwayat_jenis_jabatan','max_length[50]');
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
		$this->data['nama_kursus'] = array(
				'name'  => 'nama_kursus',
				'id'    => 'nama_kursus',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'nama kursus',
				'value' => $data['nama_kursus'],
		);
		$this->data['tempat_kursus'] = array(
				'name'  => 'tempat_kursus',
				'id'    => 'tempat_kursus',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'tempat kursus',
				'value' => $data['tempat_kursus'],
		);
		$this->data['nama_penyelenggara'] = array(
				'name'  => 'nama_penyelenggara',
				'id'    => 'nama_penyelenggara',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'nama penyelenggara',
				'value' => $data['nama_penyelenggara'],
		);
		$this->data['angkatan'] = array(
				'name'  => 'angkatan',
				'id'    => 'angkatan',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'angkatan kursus',
				'value' => $data['angkatan'],
		);
		$this->data['valid_from'] = array(
				'name'  => 'valid_from',
				'id'    => 'valid_from',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'mulai kursus',
				'value' => $data['valid_from'],
		);
		$this->data['valid_to'] = array(
				'name'  => 'valid_to',
				'id'    => 'valid_to',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'akhir kursus',
				'value' => $data['valid_to'],
		);
		$this->data['jml_jam'] = array(
				'name'  => 'jml_jam',
				'id'    => 'jml_jam',
				'type'  => 'number',
				'class' => 'form-control',
				'placeholder'=>'jumlah jam',
				'value' => $data['jml_jam'],
		);
		$this->data['no_sertifikat'] = array(
				'name'  => 'no_sertifikat',
				'id'    => 'no_sertifikat',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'akhir kursus',
				'value' => $data['no_sertifikat'],
		);
		$this->data['tgl_sertifikat'] = array(
				'name'  => 'tgl_sertifikat',
				'id'    => 'tgl_sertifikat',
				'type'  => 'date',
				'class' => 'form-control',
				'placeholder'=>'tanggal sertifikat',
				'value' => $data['tgl_sertifikat'],
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
			$this->template->admin_render('setup/riwayat_kursus/index', $this->data);
		}
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
		/* Get all users */
		
		$config = array ();
		$config ["base_url"] = base_url () . "setup/riwayat_kursus/index";
		$config ["total_rows"] = $this->riwayat_kursus_model->record_count($nip);
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
		
		$this->data ['riwayat'] = $this->riwayat_kursus_model->fetchAll($config ["per_page"], $page,$nip);
		$this->data ['links'] = $this->pagination->create_links ();
		$this->template->admin_render('setup/riwayat_kursus/index', $this->data);
		
	}
	
	public function add(){
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>$this->input->post('nip'),
						'seq_no'=>$this->riwayat_kursus_model->generateSeqNo($this->input->post('nip')),
						'nama_kursus'=>$this->input->post ('nama_kursus'),
						'tempat_kursus'=>$this->input->post ('tempat_kursus'),
						'nama_penyelenggara'=>$this->input->post ('nama_penyelenggara'),
						'angkatan'=>$this->input->post ('angkatan'),
						'valid_from'=>$this->input->post ('valid_from'),
						'valid_to'=>$this->input->post ('valid_to'),
						'jml_jam'=>$this->input->post ('jml_jam'),
						'no_sertifikat'=>$this->input->post ('no_sertifikat'),
						'tgl_sertifikat'=>$this->input->post ('tgl_sertifikat')
				);
				$this->riwayat_kursus_model->create($data);
				redirect('setup/riwayat_kursus','refresh');
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('setup/riwayat_kursus/add', 'refresh');
			}
			
		} else {
			$data = array(
					'nip'=>$this->session->userdata('nip'),
					'nama'=>$this->pegawai_model->getName($this->session->userdata('nip')),
					'seq_no'=>null,
					'nama_kursus'=>null,
					'tempat_kursus'=>null,
					'nama_penyelenggara'=>null,
					'angkatan'=>null,
					'valid_from'=>null,
					'valid_to'=>null,
					'jml_jam'=>null,
					'no_sertifikat'=>null,
					'tgl_sertifikat'=>null
			);
			$this->template->admin_render('setup/riwayat_kursus/form',$this->inputSetting($data));
		}
	}
	
	public function modify($nip,$seq_no) {
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
					'nip'=>$this->input->post('nip'),
					'seq_no'=>$this->input->post('seq_no'),
					'nama_kursus'=>$this->input->post ('nama_kursus'),
					'tempat_kursus'=>$this->input->post ('tempat_kursus'),
					'nama_penyelenggara'=>$this->input->post ('nama_penyelenggara'),
					'angkatan'=>$this->input->post ('angkatan'),
					'valid_from'=>$this->input->post ('valid_from'),
					'valid_to'=>$this->input->post ('valid_to'),
					'jml_jam'=>$this->input->post ('jml_jam'),
					'no_sertifikat'=>$this->input->post ('no_sertifikat'),
					'tgl_sertifikat'=>$this->input->post ('tgl_sertifikat')
				);
			}
			$this->riwayat_kursus_model->update($data);
			redirect('setup/riwayat_kursus/index','refresh');
		} else {
			$query = $this->riwayat_kursus_model->fetchById($nip,$seq_no);
			foreach ($query as $row){
				$this->template->admin_render('setup/riwayat_kursus/form',$this->inputSetting($row));
			}
		}
	}
	
	public function remove($nip=null,$seq_no=null) {
		$this->riwayat_kursus_model->delete($nip,$seq_no);
		redirect ('setup/riwayat_kursus/index','refresh');
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
			$config ["base_url"] = base_url () . "setup/riwayat_kursus/find";
			$config ["total_rows"] = $this->riwayat_kursus_model->search_count($column,$query);
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
				
			$this->data ['riwayat'] = $this->riwayat_kursus_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->admin_render('setup/riwayat_kursus/index', $this->data);
		}
	}
	
	public function getChild(){
		
	}
	
}