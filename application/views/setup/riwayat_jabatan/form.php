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
				echo form_open('setup/riwayat_jabatan/add');
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/riwayat_jabatan/modify/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
			}else{
				echo form_open('setup/riwayat_jabatan/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >NIP.</label>
							<?php echo form_input($nip)?>
						</div>
						<div class="form-group">
							<label >Jenis Jabatan</label>
							<?php $option = array(
									'fungsional'=>'Fungsional',
									'struktural'=>'Struktural'
							); 
							echo form_dropdown($jenis_jabatan,$option,$jenis_jabatan['value']);?>
						</div>
						<div class="form-group">
							<label >Unit Kerja</label>
							<?php echo form_input($kd_skpd)?>
						</div>
						<div class="form-group">
							<label >No. SK</label>
							<?php echo form_input($no_sk)?>
						</div>
						<div class="form-group">
							<label >Tanggal Di tetapkan</label>
							<div class="input-group date" data-provide="datepicker">
								<?php echo form_input($valid_from)?>
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Nama Pegawai.</label>
							<?php echo form_input($nama)?>
						</div>
						<div class="form-group">
							<label >Jabatan</label>
							<?php echo form_input($position)?>
						</div>
						<div class="form-group">
							<label >Esselon</label>
							<?php echo form_input($esselon)?>
						</div>
						<div class="form-group">
							<label >Tgl. SK</label>
							<div class="input-group date" data-provide="datepicker">
								<?php echo form_input($tgl_sk)?>
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
					</div>
					
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('setup/riwayat_jabatan/index', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>