<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class report_collection extends Admin_Controller {
	public function __construct() {
		parent::__construct ();
		
		/* Load Library */
		$this->load->library('form_validation');
		$this->load->library('session');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_skpd'));
		$this->data['pagetitle'] = $this->page_title->show();
		
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/users');
		$this->load->helper(array('form', 'url'));
		$this->load->model ('member/report_collection_model' );
		
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
			$config ["base_url"] = base_url () . "report/index";
			$config ["total_rows"] = $this->report_collection_model->record_count();
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
			
			$this->data ['list_report'] = $this->report_collection_model->fetchAll($config ["per_page"], $page);
			$this->data ['links'] = $this->pagination->create_links ();
			if(!$this->ion_auth->is_admin()){
				$this->template->member_render('member/report/index', $this->data);
			}else{
				$this->template->admin_render('member/report/index', $this->data);
			}
		}
	}
	
	
	public function rekap_absen_bulanan(){
		if($this->input->post('submit')){
			$data = array(
				'bulan'=>$this->input->post('bulan'),
				'tahun'=>$this->input->post('tahun'),
				'tanggal'=>$this->input->post('tanggal')
			);
// 			$this->report_collection_model->rekap_absen_bulanan($data);
			$this->generateReportRekapAbsenBulanan();
		}else{
			if(!$this->ion_auth->is_admin()){
				$this->template->member_render('member/rekap_absen_bulanan/form', $this->data);
			}else{
				$this->template->admin_render('member/rekap_absen_bulanan/form', $this->data);
			}
		}
	}
	
	public function generateReportRekapAbsenBulanan(){
		
		$this->load->library('excel');
		
		//load PHPExcel library
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Rekap Absen Bulan'.date('d-F-Y'));
		
		//STYLING
		$styleArray = array(
				'borders' => array('vertical' =>
						array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' =>
								array('argb' => '0000'),
						),
				),
		);
			
		//STYLING
		$styleArray2 = array(
				'borders' => array('allborders' =>
						array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' =>
								array('argb' => '0000'),
						),
				),
		);
			
		//STYLING
		$styleArray3 = array(
				'borders' => array('bottom' =>
						array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' =>
								array('argb' => '0000'),
						),
				),
		);
			
		$styleArray4 = array(
				'borders' => array('right' =>
						array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' =>
								array('argb' => '0000'),
						),
				),
		);
		
		$styleArray5 = array(
				'borders' => array('left' =>
						array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' =>
								array('argb' => '0000'),
						),
				),
		);
		
		//SET DIMENSI TABEL
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(56);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
			
		//set KOP
		$this->excel->getActiveSheet()->mergeCells('A1:K1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'DAFTAR URUT KEPANGKATAN PEGAWAI NEGERI SIPIL LINGKUP PEMERINTAH KOTA KENDARI ');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			
		$this->excel->getActiveSheet()->mergeCells('A2:K2');
		$this->excel->getActiveSheet()->setCellValue('A2', ''.strtoupper($data['nama_skpd2']->nama));
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			
		//SET NO
		$this->excel->getActiveSheet()->mergeCells('A5:A6');
		$this->excel->getActiveSheet()->setCellValue('A5', 'NO');
		$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(11);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setName('Calibri');
		
		//SET NIP BARU
		$this->excel->getActiveSheet()->mergeCells('B5:B6');
		$this->excel->getActiveSheet()->getStyle('B5:B6')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->setCellValue('B5', 'NAMA / NIP                        						TEMPAT TANGGAL LAHIR');
		$this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(11);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setName('Calibri');
		
		ob_end_clean();
		$filename='DUK.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		
		$objWriter->save('php://output');
	}
}