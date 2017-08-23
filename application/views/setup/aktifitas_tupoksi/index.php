<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Uraian Tupoksi
		</h3>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<div class="col-sm-12">
			<div class=row>
				<div class="panel-body">
				<div class="box-body">
					<div class="col-lg-12">
						<div class="form-group">
							<label >Tupoksi</label>
							<?php echo form_textarea($tupoksi)?>
						</div>
						<div class="form-group">
							<label >Tupoksi</label>
							<?php echo form_textarea($uraian_tupoksi)?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
					<?php echo anchor('setup/aktifitas_tupoksi/add/'.$this->uri->segment(4).'/'.$this->uri->segment(5), 
					'<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Aktifitaas"><i class="fa fa-plus"></i> Tambah Aktifitas</button>' );?>
					&nbsp;
					<?php echo anchor('setup/aktifitas_tupoksi/index/'.$this->uri->segment(4).'/'.$this->uri->segment(5), 
					'<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php echo form_open("setup/tupoksi/find");?>
				<div class="col-md-5 col-sm-4 col-xs-4">
					<div class='col-md-5'>
					<?php $option = array(
							'aktifitas'=>'Aktifitas',
							'kategori'=>'Kategori',
							'satuan'=>'Satuan',
							'waktu'=>'Waktu',
							'bobot'=>'Bobot',
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
				<th  class="col-md-4">Aktifitas</th>
				<th  class="col-md-1">Kategori</th>
				<th  class="col-md-1">Satuan Waktu</th>
				<th  class="col-md-1">Lama Waktu</th>
				<th  class="col-md-1">Tingkat Kesulitan</th>
				<th  class="col-md-1">Bobot</th>
				<th class="col-md-1"></th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($aktifasi_tupoksi){
	    		$i=1;
				foreach ( $aktifasi_tupoksi as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->nama_aktifitas?></td>
		        <td ><?php echo $row->kategori?></td>
		        <td ><?php echo $row->satuan_output?></td>
		        <td ><?php echo $row->lama_waktu?></td>
		        <td ><?php echo $row->tingkat_kesulitan?></td>
		        <td ><?php echo $row->bobot?></td>
		        <td ><center>
		        <a href="<?php echo base_url('setup/aktifitas_tupoksi/modify/'.$row->id_tupoksi.'/'.$row->id_uraian.'/'.$row->id_aktifitas) ?>"><button class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/aktifitas_tupoksi/remove/'.$row->id_tupoksi.'/'.$row->id_uraian.'/'.$row->id_aktifitas) ?>" onclick="return confirm('Anda Yakin ?');"><button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button></a>
				</center></td>
				</tr>
	        <?php 
	        	$i++;
				} 
	    	}else{
	        	echo "<tr class=\"gradeX\"><td colspan='8'>No Record</td></tr>";
	        }?>
	    	</tbody>
			</table>
			</div>
			<div align="right"><?php echo $links?> </div>
		</div>
	</div>
</div>
</div>
</div>
</section>
</div>
