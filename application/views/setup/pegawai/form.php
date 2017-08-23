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
				echo form_open('setup/pegawai/add');
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/pegawai/modify/'.$this->uri->segment(4));
			}else{
				echo form_open('setup/pegawai/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >NIP.</label>
							<?php echo form_input($nip)?>
						</div>
						<div class="form-group">
							<label >NIP Lama.</label>
							<?php echo form_input($nip_lama)?>
						</div>
						<div class="form-group">
							<label >Gelar Depan.</label>
							<?php echo form_input($gelar_depan)?>
						</div>
						<div class="form-group">
							<label >Tempat Lahir.</label>
							<?php echo form_input($tempat_lahir)?>
						</div>
						<div class="form-group">
							<label >No. Kartu Pegawai.</label>
							<?php echo form_input($no_kartu_pegawai)?>
						</div>
						<div class="form-group">
							<label >Jenis Kelamin.</label>
							<?php $option = array(
									'1'=>'Pria',
									'2'=>'Wanita'
							); 
							echo form_dropdown($kelamin,$option,$kelamin['value']);?>
						</div>
						<div class="form-group">
							<label >Alamat.</label>
							<?php echo form_textarea($alamat)?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Nama Pegawai.</label>
							<?php echo form_input($nama)?>
						</div>
						<div class="form-group">
							<label >No. Telp.</label>
							<?php echo form_input($telp)?>
						</div>
						<div class="form-group">
							<label >Gelar Belakang.</label>
							<?php echo form_input($gelar_belakang)?>
						</div>
						<div class="form-group">
							<label >Tanggal Lahir.</label>
							<div class="input-group date" data-provide="datepicker">
								<?php echo form_input($tgl_lahir)?>
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</div>
						<div class="form-group">
							<label >No. Tabungan Pensiun.</label>
							<?php echo form_input($no_taspen)?>
						</div>
						<div class="form-group">
							<label >No Pokok Wajib Pajak.</label>
							<?php echo form_input($npwp)?>
						</div>
						<div class="form-group">
							<label >Agama.</label>
							<?php $option = array(
									'1'=>'Islam',
									'2'=>'Katolik',
									'3'=>'Protestan',
									'4'=>'Hindu',
									'5'=>'Budha',
									'6'=>'Sinto',
									'7'=>'Konghucu',
									'8'=>'Lain-lain'
							); 
							echo form_dropdown($agama,$option,$agama['value']);?>
						</div>
						<div class="form-group">
							<label >Golongan Darah.</label>
							<?php $option = array(
									'1'=>'A',
									'2'=>'B',
									'3'=>'AB',
									'4'=>'O'
							); 
							echo form_dropdown($gol_darah,$option,$gol_darah['value']);?>
						</div>
						<div class="form-group">
							<label >Status.</label>
							<?php $option = array(
									'1'=>'Lajang',
									'2'=>'Nikah',
									'3'=>'Cerai'
							); 
							echo form_dropdown($status,$option,$status['value']);?>
						</div>
					</div>
					<div class="col-lg-12">
					</div>
					
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('setup/pegawai', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>