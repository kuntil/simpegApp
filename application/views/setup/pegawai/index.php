<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Data Pegawai
		</h3>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<div class="col-sm-12">
			<div class=row>
				<?php if($this->session->flashdata('message')){ ?>
				<div class="box-body">
				<div class="alert alert-info alert-dismissible">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
				<?php echo $this->session->flashdata('message'); ?>
				</div>
				</div>
				<?php }?>
				<div class="col-md-6 col-sm-4 col-xs-4">
					<div class="btn-group">
					<?php echo anchor('setup/pegawai/add', 
					'<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data Pegawai"><i class="fa fa-plus"></i> Tambah Pegawai</button>' );?>
					&nbsp;
					<?php echo anchor('setup/pegawai', 
					'<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php echo form_open("setup/pegawai/find");?>
				<div class="col-md-5 col-sm-4 col-xs-4">
					<div class='col-md-5'>
					<?php $option = array(
							'nip'=>'NIP',
							'nip_lama'=>'NIP Lama',
							'nama'=>'Nama',
							'gelar_depan'=>'Gelar Depan',
							'gelar_belakang'=>'Gelar Belakang',
							'tempat_lahir'=>'Tempat Lahir',
							'telp'=>'Telp',
							'kelamin'=>'Jenis Kelamin',
							'agama'=>'Agama',
							'alamat'=>'Alamat',
							'kode_pos'=>'Kode Pos',
							'gol_darah'=>'Gol. Darah',
							'no_kartu_pegawai'=>'Kartu Pegawai',
							'no_taspen'=>'Taspen',
							'npwp'=>'npwp'
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
	<div class="panel-body">
		<div class="dataTable_wrapper">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th class="col-md-1"><center>#</center></th>
				<th class="col-md-2">NIP/NIP Lama</th>
				<th class="col-md-3">Nama</th>
				<th class="col-md-2">TTL</th>
				<th class="col-md-3">Alamat</th>
				<th class="col-md-1">Status</th>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($pegawai){
	    		$i=1;
				foreach ( $pegawai as $row ) {
			?>
		        <tr class="gradeX">
		        <td><?php echo $i?></td>
		        <td><?php echo $row->nip." / ".$row->nip_lama?></td>
		        <td><?php echo $row->nama?></td>
		        <td><?php echo $row->tempat_lahir.", ".$row->tgl_lahir?></td>
		        <td><?php echo $row->alamat?></td>
		        <td><?php echo $row->status?></td>
		        <td >
		        <a href="<?php echo base_url('setup/pegawai/modify/'.$row->nip) ?>"><button class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/pegawai/remove/'.$row->nip) ?>" onclick="return confirm('Anda Yakin ?');"><button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button></a>
				</td>
				</tr>
	        <?php 
	        	$i++;
				} 
	    	}else{
	        	echo "<tr class=\"gradeX\"><td colspan='4'>No Record</td></tr>";
	        }?>
	    	</tbody>
			</table>
			</div>
			<div align="right"><?php echo $links?> </div>
		</div>
	</div>
</div>
</div>
</section>
</div>
