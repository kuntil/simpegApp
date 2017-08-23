<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Data skpd
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
					<?php echo anchor('setup/skpd/add', 
					'<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data skpd"><i class="fa fa-plus"></i> Tambah skpd</button>' );?>
					&nbsp;
					<?php echo anchor('setup/skpd', 
					'<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php echo form_open("setup/skpd/find");?>
				<div class="col-md-5 col-sm-4 col-xs-4">
					<div class='col-md-5'>
					<?php $option = array(
							'kd_skpd'=>'Kode SKPD',
							'Nama'=>'NIP Lama'
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
				<th><center>#</center></th>
				<th  class="col-md-2">KD. SKPD</th>
				<th  class="col-md-8">Nama SKPD</th>
				<th>&nbsp;&nbsp;</th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($skpd){
	    		$i=1;
				foreach ( $skpd as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->kd_skpd?></td>
		        <td ><?php echo $row->nama?></td>
		        <td ><center>
		        <a href="<?php echo base_url('setup/skpd/modify/'.$row->kd_skpd) ?>"><button class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/skpd/remove/'.$row->kd_skpd) ?>" onclick="return confirm('Anda Yakin ?');"><button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button></a>
				</center></td>
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
