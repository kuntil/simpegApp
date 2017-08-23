<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Riwayat Kepangkatan
		</h3>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<div class="col-sm-12">
		<?php if($this->session->flashdata('message')){ ?>
		<div class="box-body">
		<div class="alert alert-info alert-dismissible">
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<?php echo $this->session->flashdata('message'); ?>
		</div>
		</div>
		<?php }?>
		</div>
		<div class="col-sm-12">
			<div class="row">
			<?php echo form_open("setup/riwayat_kepangkatan/index",array('method'=>'POST'));?>
					<div class="box-body">
					<div class="col-sm-3">
						<div class="form-group">
							<label >NIP.</label>
							<input type="text" name="nip" class="form-control" value="<?php echo $this->session->userdata('nip')?>">
						</div>
					</div>
					<div class="col-sm-7">
						<div class="form-group">
							<label >Nama.</label>
							<input type="text" name="nama" class="form-control" readonly>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label >&nbsp;</label>
							<input type="submit" name="submit" class="form-control btn btn-info" title="Cari Data" value="Go">
						</div>
					</div>
					</div>
			<?php echo form_close();?>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="dataTable_wrapper">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th class="col-md-1">No</th>
				<th class="col-md-1">Golongan</th>
				<th class="col-md-1">Tmt. Pangkat</th>
				<th class="col-md-1">No. SK</th>
				<th class="col-md-1">Tgl SK</th>
				<th class="col-md-1">MK. Bulan</th>
				<th class="col-md-1">MK. Tahun</th>
				<th class="col-md-1"><center>#</center></th>			
			</tr>
			</thead>
			<tbody>
			<?php if($riwayat){ ?>
	    	<?php
	    		$i=1;
				foreach ( $riwayat as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><?php echo $i?></td>
		        <td ><?php echo $row->golongan?></td>
		        <td ><?php echo $row->tmt_pangkat?></td>
		        <td ><?php echo $row->no_surat_kerja?></td>
		        <td ><?php echo $row->tgl_surat_kerja?></td>
		        <td ><?php echo $row->mk_bulan?></td>
		        <td ><?php echo $row->mk_tahun?></td>
		        <td ><center>
		        <a href="<?php echo base_url('setup/riwayat_kepangkatan/modify/'.trim($row->nip).'/'.$row->seq_no) ?>"><button class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/riwayat_kepangkatan/remove/'.trim($row->nip).'/'.$row->seq_no) ?>" onclick="return confirm('Anda Yakin ?');"><button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button></a>
				</center></td>
				</tr>
	        <?php $i++; 
				}
			}else{
	        	echo "<tr class=\"gradeX\"><td colspan='8'>No Record</td></tr>";
	        }?> 
	    	</tbody>
			</table>
			</div>
			<div align="right"><?php echo $links?> </div>
		</div>
		<div class=row>
			<div class="col-md-6 col-sm-4 col-xs-4">
				<div class="btn-group">
				<?php echo anchor('setup/riwayat_kepangkatan/add', 
				'<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Riwayat Pangkat"><i class="fa fa-plus"></i> Tambah Riwayat</button>' );?>
				&nbsp;
				<?php echo anchor('setup/riwayat_kepangkatan', 
				'<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
				</div>
			</div>
			<?php echo form_open("setup/pegawai/find");?>
			<div class="col-md-5 col-sm-4 col-xs-4">	
				<div class='col-md-5'>
				<?php $option = array(
						'jenis_pendidikan'=>'Jenis Pendidikan',
						'jurusan'=>'Jurusan',
						'nama_sekolah'=>'Nama Sekolah',
						'kepala_sekolah'=>'Nama Kepala Sekolah',
						'no_ijazah'=>'Nomor Ijazah',
						'tahun_ijazah'=>'Tahun Ijazah'
				); 
				echo form_dropdown('column',$option,'1','class="form-control"');?>
				</div>
				<div class="col-md-7"><input type="text" class="form-control" name="data" placeholder="Cari"></div>
			</div>
			<div class="btn-group">
				<input type="submit" name="submit" class="btn btn-info" title="Cari Data" value="Go">
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>
</div>
</section>
</div>
