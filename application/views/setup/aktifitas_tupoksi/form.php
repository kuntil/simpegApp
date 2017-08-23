<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Tambah Data Aktifitas</h3>
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
				echo form_open('setup/aktifitas_tupoksi/add'.'/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/aktifitas_tupoksi/modify/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
			}else{
				echo form_open('setup/aktifitas_tupoksi/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >Tupoksi</label>
							<?php echo form_textarea($tupoksi)?>
						</div>
						<div class="form-group">
							<label >ID Aktifitas</label>
							<?php echo form_input($id_aktifitas)?>
						</div>
						<div class="form-group">
						<label >Kategori</label>
						<?php $option = array(
							'administrasi'=>'Administrasi',
							'operasional'=>'Operasional',
							); 
							echo form_dropdown($kategori,$option,$kategori['value'],'class="form-control"');?>
						</div>
						<div class="form-group">
							<label >Lama Waktu [menit]</label>
							<?php echo form_input($lama_waktu)?>
						</div>
						<div class="form-group">
							<label >Bobot</label>
							<?php echo form_input($bobot)?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Uraian Tupoksi</label>
							<?php echo form_textarea($uraian_tupoksi)?>
						</div>
						<div class="form-group">
							<label >Nama Aktifitas</label>
							<?php echo form_input($nama_aktifitas)?>
						</div>
						<div class="form-group">
							<label >Satuan Output</label>
							<?php echo form_input($satuan_output)?>
						</div>
						<div class="form-group">
							<label >Tingkat Kesulitan</label>
							<?php echo form_input($tingkat_kesulitan)?>
						</div>
					</div>
					<div class="col-lg-12">
					</div>
					
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('setup/aktifitas_tupoksi/index/'.$this->uri->segment(4).'/'.$this->uri->segment(5), 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>