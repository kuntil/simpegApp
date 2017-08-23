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
				echo form_open('setup/riwayat_kepangkatan/add');
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/riwayat_kepangkatan/modify/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
			}else{
				echo form_open('setup/riwayat_kepangkatan/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >NIP.</label>
							<?php echo form_input($nip)?>
						</div>
						<div class="form-group">
							<label >No. Surat Kerja</label>
							<?php echo form_input($no_surat_kerja)?>
						</div>
						<div class="form-group">
							<label >Masa Kerja Tahun</label>
							<?php echo form_input($mk_tahun)?>
						</div>
						<div class="form-group">
							<label >Golongan</label>
							<?php 
							$option = array (
								'gol_1a'=>'Golongan I.a',
								'gol_1b'=>'Golongan I.b',
								'gol_1c'=>'Golongan I.c',
								'gol_1d'=>'Golongan I.d',
								'gol_2a'=>'Golongan II.a',
								'gol_2b'=>'Golongan II.b',
								'gol_2c'=>'Golongan II.c',
								'gol_2d'=>'Golongan II.d',
								'gol_3a'=>'Golongan III.a',
								'gol_3b'=>'Golongan III.b',
								'gol_3c'=>'Golongan III.c',
								'gol_3d'=>'Golongan III.d',
								'gol_4a'=>'Golongan IV.a',
								'gol_4b'=>'Golongan IV.b',
								'gol_4c'=>'Golongan IV.c',
								'gol_4d'=>'Golongan IV.d'
							);
							echo form_dropdown($golongan,$option,$golongan['value'])?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Nama Pegawai.</label>
							<?php echo form_input($nama)?>
						</div>
						<div class="form-group">
							<label >Tgl Surat Kerja</label>
							<div class="input-group date" data-provide="datepicker">
								<?php echo form_input($tgl_surat_kerja)?>
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</div>
						<div class="form-group">
							<label >Masa Kerja Bulan</label>
							<?php 
							$option = array(
									1 => 1,
									2 => 2,
									3 => 3,
									4 => 4,
									5 => 5,
									6 => 6,
									7 => 7,
									8 => 8,
									9 => 9,
									10 => 10,
									11 => 11,
									12 => 12
							);
							
							echo form_dropdown($mk_bulan,$option,$mk_bulan['value'])?>
						</div>
						<div class="form-group">
							<label >Tanggal Mulai Ditetapkan</label>
							<div class="input-group date" data-provide="datepicker">
								<?php echo form_input($tmt_pangkat)?>
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
					<?php echo anchor('setup/riwayat_kepangkatan/index', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>