<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Tambah Data Uraian Tupoksi</h3>
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
				echo form_open('setup/uraian_tupoksi/add'.'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/uraian_tupoksi/modify/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7));
			}else{
				echo form_open('setup/tupoksi/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >ID SKPD</label>
							<?php echo form_input($kd_skpd)?>
						</div>
						<div class="form-group">
							<label >ID Tupoksi</label>
							<?php echo form_input($id_tupoksi)?>
						</div>
						<div class="form-group">
							<label >Tupoksi</label>
							<?php echo form_textarea($tupoksi)?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >ID Jabatan</label>
							<?php echo form_input($kd_position)?>
						</div>
						<div class="form-group">
							<label >ID Uraian Tupoksi</label>
							<?php echo form_input($id_uraian)?>
						</div>
						<div class="form-group">
							<label >Jenis Tupoksi.</label>
							<?php $option = array(
									'pokok'=>'Pokok',
									'tambahan'=>'Tambahan',
									'kreatifitas'=>'Kreatifitas'
							); 
							echo form_dropdown($jenis_tupoksi,$option,$jenis_tupoksi['value']);?>
						</div>
						<div class="form-group">
							<label >Uraian Tupoksi</label>
							<?php echo form_textarea($uraian_tupoksi)?>
						</div>
					</div>
					<div class="col-lg-12">
					</div>
					
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('setup/uraian_tupoksi/index/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6), 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>