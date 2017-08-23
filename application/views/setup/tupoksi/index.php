<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Data Tupoksi
		</h3>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<div class="col-sm-12">
			<div class=row>
				<div class="col-md-6 col-sm-4 col-xs-4">
					<div class="btn-group">
					<?php echo anchor('setup/tupoksi/add', 
					'<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data tupoksi"><i class="fa fa-plus"></i> Tambah tupoksi</button>' );?>
					&nbsp;
					<?php echo anchor('setup/tupoksi', 
					'<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php echo form_open("setup/tupoksi/find");?>
				<div class="col-md-5 col-sm-4 col-xs-4">
					<div class='col-md-5'>
					<?php $option = array(
							'id_tupoksi'=>'Kode Tupoksi',
							'dasar_hukum'=>'Dasar Hukum',
							'tahun'=>'Tahun',
							'aktif'=>'Aktif'
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
				<th  class="col-md-2">SKPD</th>
				<th  class="col-md-2">Jabatan</th>
				<th  class="col-md-5">Tupoksi</th>
				<th  class="col-md-1">Tahun</th>
				<th class="col-md-2"></th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($tupoksi){
	    		$i=1;
				foreach ( $tupoksi as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->nama_skpd?></td>
		        <td ><?php echo $row->nama_position?></td>
		        <td ><?php echo $row->tupoksi?></td>
		        <td ><?php echo $row->tahun?></td>
		        <td ><center>
		        <a href="<?php echo base_url('setup/uraian_tupoksi/index/'.$row->id_tupoksi.'/'.$row->kd_skpd.'/'.$row->kd_position) ?>"><button class="btn btn-success btn-xs" title="Uraian Tupoksi"><i class="fa fa-reorder "></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/tupoksi/modify/'.$row->id_tupoksi.'/'.$row->kd_skpd.'/'.$row->kd_position) ?>"><button class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/tupoksi/remove/'.$row->id_tupoksi.'/'.$row->kd_skpd.'/'.$row->kd_position) ?>" onclick="return confirm('Anda Yakin ?');"><button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button></a>
				</center></td>
				</tr>
	        <?php 
	        	$i++;
				} 
	    	}else{
	        	echo "<tr class=\"gradeX\"><td colspan='6'>No Record</td></tr>";
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
