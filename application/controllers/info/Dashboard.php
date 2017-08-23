<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct(){
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
        $this->load->model('member/staff_model');
        $this->load->model('setup/skpd_model');
        $this->load->model('setup/position_model');
        $this->load->model('setup/pegawai_model');
    }

	public function index(){
        if ( !$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
        	if(!$this->ion_auth->is_admin()){
        		$this->page_title->push(lang('menu_dashboard'));
				$this->data['pagetitle'] = $this->page_title->show();
					
				/* Breadcrumbs */
				$this->data['breadcrumb'] = $this->breadcrumbs->show();
					
				$config = array ();
				$config ["base_url"] = base_url () . "info/dashboard/bpkad";
				$config ["total_rows"] = $this->staff_model->recordCountPenilaianBulananBPKAD ();
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
					
				$this->data['links'] = $this->pagination->create_links ();
				
				/* Data */
				$this->data['list'] = $this->staff_model->penilaianBulananBPKAD();
					
				/* Load Template */
				$this->template->info_render('info/dashboard/index', $this->data);
        	}else{
        		redirect('admin','refresh');
        	}
        }
	}
	
}
