<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
        $this->load->model('member/staff_model');
        $this->load->model('setup/skpd_model');
        $this->load->model('setup/position_model');
        $this->load->model('setup/pegawai_model');
    }


	public function index()
	{
        if ( !$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
        	if(!$this->ion_auth->is_admin()){
        		/* Title Page */
        		$this->page_title->push(lang('menu_dashboard'));
        		$this->data['pagetitle'] = $this->page_title->show();
        	
        		/* Breadcrumbs */
        		$this->data['breadcrumb'] = $this->breadcrumbs->show();
        	
        		/* Data */
        		$this->data['list'] = $this->staff_model->penilaianBulanan();
        		$this->data['unit']		= $this->skpd_model->getName($this->session->userdata('ss_skpd'));
        		$this->data['jabatan']	= $this->position_model->getName($this->session->userdata('ss_skpd'),$this->session->userdata('ss_position'));
        		$this->data['kegiatan'] = $this->skpd_model->getAktifitas($this->session->userdata('ss_nip'), date('Y-m-d'));
        		$this->data['tupoksi'] = $this->skpd_model->getUraianTupoksi($this->session->userdata('ss_skpd'),$this->session->userdata('ss_position'));
        	
        		/* Load Template */
        		if($this->pegawai_model->getGroupByUserId()==3){
        			$this->template->info_render('info/dashboard/index', $this->data);
        		}else if($this->pegawai_model->getGroupByUserId()==2){
        			$this->template->member_render('member/dashboard/index', $this->data);
        		}
        	}else{
        		redirect('admin','refresh');
        	}
        }
	}
	
	public function bpkad()
	{
		if ( !$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			if(!$this->ion_auth->is_admin()){
				/* Title Page */
				$this->page_title->push(lang('menu_dashboard'));
				$this->data['pagetitle'] = $this->page_title->show();
				 
				/* Breadcrumbs */
				$this->data['breadcrumb'] = $this->breadcrumbs->show();
				 
				/* Data */
				$this->data['list'] = $this->staff_model->penilaianBulananBPKAD();
				 
				/* Load Template */
				$this->template->member_render('member/dashboard/bpkad', $this->data);
			}else{
				redirect('admin','refresh');
			}
		}
	}
	
	public function bkd()
	{
		if ( !$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			if(!$this->ion_auth->is_admin()){
				/* Title Page */
				$this->page_title->push(lang('menu_dashboard'));
				$this->data['pagetitle'] = $this->page_title->show();
					
				/* Breadcrumbs */
				$this->data['breadcrumb'] = $this->breadcrumbs->show();
					
				/* Data */
				$this->data['list'] = $this->staff_model->penilaianBulananBPKAD();
					
				/* Load Template */
				$this->template->member_render('member/dashboard/bkd', $this->data);
			}else{
				redirect('admin','refresh');
			}
		}
	}
}
