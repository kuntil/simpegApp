<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Tambah Data Pegawai</h3>
</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="box box-solid box-default">
			<?php if($this->session->flashdata('message')){ ?>
			<div class="box-body">
			<div class="alert alert-danger alert-dismissible">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<?php echo $this->session->flashdata('message'); ?>
			</div>
			</div>
			<?php }?>
			<div class="panel-body">
			<?php 
			if($this->uri->segment(3)=="add"){
				echo form_open('setup/riwayat_pendidikan/add');
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/riwayat_pendidikan/modify/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
			}else{
				echo form_open('setup/riwayat_pendidikan/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >NIP.</label>
							<?php echo form_input($nip)?>
						</div>
						<div class="form-group">
							<label >Jenis Kelamin.</label>
							<?php $option = array(
									'1'=>'TK',
									'2'=>'Sekolah Dasar',
									'3'=>'Sekolah Menengah Pertama',
									'4'=>'Sekolah Menengah Atas',
									'5'=>'Strata 1',
									'6'=>'Strata 2',
									'7'=>'Doktor'
							); 
							echo form_dropdown($jenis_pendidikan,$option,$jenis_pendidikan['value']);?>
						</div>
						<div class="form-group">
							<label >Nama Kepala Seklah</label>
							<?php echo form_input($kepala_sekolah)?>
						</div>
						<div class="form-group">
							<label >No. Ijazah</label>
							<?php echo form_input($no_ijazah)?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Nama Pegawai.</label>
							<?php echo form_input($nama)?>
						</div>
						<div class="form-group">
							<label >Nama Sekolah</label>
							<?php echo form_input($nama_sekolah)?>
						</div>
						<div class="form-group">
							<label >Tahun</label>
							<?php echo form_input($tahun_ijazah)?>
						</div>
					</div>
					<div class="col-lg-12">
					</div>
					
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('setup/riwayat_pendidikan/index', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>