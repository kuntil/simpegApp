<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class kegiatan extends Admin_Controller {
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
		$this->load->model ('member/staff_model');
		$this->load->model ('setup/tupoksi_model');
		$this->load->model ('member/penilaian_tupoksi_model');
		$this->load->model ('member/penilaian_prilaku_model');
		$this->load->model ('setup/skpd_model');
		$this->load->model ('setup/pegawai_model');
		$this->load->model ('setup/position_model');
		$this->load->model ('member/kegiatan_model');
		
	}
	
	public function validationData(){
		
		$this->form_validation->set_rules('nip','lang:pegawai_nip','max_length[50]');
		
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
		$this->data['kd_skpd'] = array(
				'name'  => 'kd_skpd',
				'id'    => 'kd_skpd',
				'type'  => 'text',
				'class' => 'form-control',
				'placeholder'=>'gelar di depan',
				'value' => $data['kd_skpd'],
		);
		$this->data['kd_position'] = array(
				'name'  => 'kd_position',
				'id'    => 'kd_position',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kd_position'],
		);
		$this->data['kd_tupoksi'] = array(
				'name'  => 'kd_tupoksi',
				'id'    => 'kd_tupoksi',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kd_tupoksi'],
		);
		$this->data['kd_uraian'] = array(
				'name'  => 'kd_uraian',
				'id'    => 'kd_uraian',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['kd_uraian'],
		);
		$this->data['kd_kegiatan'] = array(
				'name'  => 'nama_position',
				'id'    => 'nama_position',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['nama_position'],
		);
		$this->data['tgl_kegiatan'] = array(
				'name'  => 'tgl_kegiatan',
				'id'    => 'tgl_kegiatan',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['tgl_kegiatan'],
		);
		$this->data['uraian_kegiatan'] = array(
				'name'  => 'uraian_kegiatan',
				'id'    => 'uraian_kegiatan',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['uraian_kegiatan'],
		);
		$this->data['nilai'] = array(
				'name'  => 'nilai',
				'id'    => 'nilai',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $data['nilai'],
		);
		return $this->data;
	}
	
	public function index() {
		
		if ( ! $this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */

			$config = array ();
			$config ["base_url"] = base_url () . "member/staff/index";
			$config ["total_rows"] = $this->staff_model->record_count ();
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
			
			$this->data ['staff'] = $this->staff_model->fetchAll($config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->member_render('member/staff/index', $this->data);
		}
	}
	
	public function find(){
		
		
		if ( ! $this->ion_auth->logged_in() )
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
			$config ["base_url"] = base_url () . "member/staff/find";
			$config ["total_rows"] = $this->staff_model->search_count($column,$query);
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
				
			$this->data ['staff'] = $this->staff_model->search($column,$query,$config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->member_render('member/staff/index', $this->data);
		}
	}
	
	public function detail($nip=null,$skpd=null,$position=null){
		
		if ( ! $this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
			/* Get all users */
		
			$config = array ();
			$config ["base_url"] = base_url () . "member/staff/detail";
			$config ["total_rows"] = $this->staff_model->record_count ();
			$config ["per_page"] = 25;
			$config ["uri_segment"] = 7;
			$choice = $config ["total_rows"] / $config ["per_page"];
			$config ["num_links"] = 8;
				
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
				
			$this->data ['bln'] = $this->penilaian_tupoksi_model->fetchByMonth($nip,$skpd,$position,date('m')-1);
			$this->data ['harian'] = $this->penilaian_tupoksi_model->fetchByDate($nip,$skpd,$position,date('m')-1, $config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			$this->template->member_render('member/staff/detail', $this->data);
		}
	}
	
	public function kinerja($nip=null,$skpd=null,$position=null){
		if($this->input->post('submit')){
			$data = null;
			$qid = $this->input->post('qid');
			$nilai = $this->input->post('nilai');
			for($i=0;$i<count($qid);$i++){
				$data =array('qid'=>$qid[$i],'nilai'=>$nilai[$i]);
				$this->penilaian_tupoksi_model->updateByQid($data);
				redirect('member/staff/index');
			}
		}else{
			$this->data ['list_tupoksi'] = $this->penilaian_tupoksi_model->penilaianKinerja($nip,date('Y-m-d'),$skpd,$position);
			$this->template->member_render('member/staff/kinerja', $this->data);
		}
	}
	
	public function prilaku($nip=null,$skpd=null,$position=null){
		if($this->input->post('submit')){
			$data= array(
				'nip'=>$nip,
				'kd_skpd'=>$skpd,
				'kd_position'=>$position,
				'tanggal'=>date('Y-m-d'),
				'orientasi_pelayanan'=>$this->input->post('orientasi_pelayanan'),
				'integritas'=>$this->input->post('integritas'),
				'komitmen'=>$this->input->post('komitmen'),
				'disiplin'=>$this->input->post('disiplin'),
				'kerjasama'=>$this->input->post('kerjasama'),
				'kepemimpinan'=>$this->input->post('kepemimpinan'),
				'guidance'=>$this->input->post('guidance')
			);
			$this->penilaian_prilaku_model->create($data);
			redirect('member/staff/index');
		}else{
			$this->data['skpd'] = $this->skpd_model->getName($skpd);
			$this->data['nama'] = $this->pegawai_model->getName($nip);
			$this->data['jabatan'] = $this->position_model->getPositionByNip($nip,$skpd);
			$this->template->member_render('member/staff/prilaku',$this->data);
		}
	}
	
	public function add(){
		
		if($this->input->post('submit')){
			if($this->validationData()==TRUE){
				$data = array(
						'nip'=>$this->session->userdata('ss_nip'),
						'kd_skpd'=>$this->session->userdata('ss_skpd'),
						'kd_position'=>$this->session->userdata('ss_position'),
						'kd_tupoksi'=>$this->input->post ('kd_tupoksi'),
						'kd_uraian'=>$this->input->post ('kd_uraian'),
						'tgl_kegiatan'=>date('Y-m-d'),
						'kd_kegiatan'=>$this->kegiatan_model->generateKegiatan($this->session->userdata('ss_nip')),
						'uraian_kegiatan'=>$this->input->post ('uraian_kegiatan')
				);
				if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'kegiatan','add') == true ){
					$message = $this->kegiatan_model->create($data);
					$this->session->set_flashdata('message', $message);
					redirect('member/dashboard','refresh');
				}else{
					$this->session->set_flashdata('message',"The user can not access to perform actions.");
					redirect('member/dashboard','refresh');
				}
			}else{
				$this->session->set_flashdata('message', validation_errors());
				redirect('member/dashboard','refresh');
			}
				
		} else {
			$data = array(
					'nip'=>null,
					'kd_skpd'=>null,
					'kd_position'=>null,
					'kd_tupoksi'=>null,
					'kd_uraian'=>null,
					'kd_kegiatan'=>null,
					'tgl_kegiatan'=>null,
					'uraian_kegiatan'=>null,
					'nilai'=>null
			);
			$this->template->member_reader('setup/pegawai/form',$this->inputSetting($data));
		}
	}
	
	public function delete($qid=null){
		if($this->user_operation_model->userSecurity($this->session->userdata('ss_user'),'kegiatan','delete') == true ){
			$message = $this->kegiatan_model->delete($qid);
			$this->session->set_flashdata('message', $message);
			redirect('member/dashboard/index','refresh');
		}else{
			$this->session->set_flashdata('message',"The user can not access to perform actions.");
			redirect('member/dashboard/index','refresh');
		}
	}
	
}