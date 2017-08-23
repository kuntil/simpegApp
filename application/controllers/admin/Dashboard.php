<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
        $this->load->model('setup/pegawai_model');
        $this->load->model('member/kegiatan_model');
        $this->load->model('setup/riwayat_hukuman_model');
    }

	public function index()
	{
        if ( !$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
        	if($this->ion_auth->is_admin()){
	            /* Title Page */
	            $this->page_title->push(lang('menu_dashboard'));
	            $this->data['pagetitle'] = $this->page_title->show();
	
	            /* Breadcrumbs */
	            $this->data['breadcrumb'] = $this->breadcrumbs->show();
	
	            /* Data */
	            $this->data['count_users']       = $this->dashboard_model->get_count_record('users');
	            $this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');
	            $this->data['disk_totalspace']   = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
	            $this->data['disk_freespace']    = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
	            $this->data['disk_usespace']     = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
	            $this->data['disk_usepercent']   = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, FALSE);
	            $this->data['memory_usage']      = $this->dashboard_model->memory_usage();
	            $this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(TRUE);
	            $this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(TRUE, FALSE);
	            $this->data['jml_pegawai']		 = $this->pegawai_model->record_count();
	            $this->data['jml_kegiatan']		 = $this->kegiatan_model->record_count();
	            $this->data['jml_pelanggaran']	 = $this->riwayat_hukuman_model->recordCountAll();
	
	            /* Load Template */
	            $this->template->admin_render('admin/dashboard/index', $this->data);
        	}else{
        		if($this->pegawai_model->getGroupByUserId()==3){
        			redirect('info','refresh');
        		}else if($this->pegawai_model->getGroupByUserId()==2){
        			redirect('member','refresh');
        		}
        	}
        }
	}
}
