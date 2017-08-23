<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Penilaian Prilaku Tanggal : <?php echo date('j F Y')?> </h3>
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
				echo form_open('member/staff/prilaku/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >SKPD</label>
							<input type="text" name="nip" readonly="readonly" value="<?php echo $skpd;?>" class="form-control">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Jabatan</label>
							<input type="text" name="jabatan" readonly="readonly" value="<?php echo $jabatan ?>" class="form-control">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >NIP</label>
							<input type="text" name="nip" readonly="readonly" value="<?php echo $this->uri->segment(4);?>" class="form-control">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Nama</label>
							<input type="text" name="nip" readonly="readonly" value="<?php echo $nama ?>" class="form-control">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Orientasi Pelayanan</label>
							<input type="number" name="orientasi_pelayanan" class="form-control" min="0" max="100">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Integritas</label>
							<input type="number" name="integritas" class="form-control" min="0" max="100">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Komitmen</label>
							<input type="number" name="komitmen" class="form-control" min="0" max="100">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Disiplin</label>
							<input type="number" name="disiplin" class="form-control" min="0" max="100">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Kerjasama</label>
							<input type="number" name="kerjasama" class="form-control" min="0" max="100">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Kepemimpinan</label>
							<input type="number" name="kepemimpinan" class="form-control" min="0" max="100">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label >Guidance Prilaku</label>
							<input type="number" name="guidance" class="form-control" min="0" max="100">
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan" onclick="return confirm('Data yang telah di kirim tidak bisa diubah, apakah data anda sudah benar. Anda Yakin ?');"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('member/staff/index', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>