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
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="col-sm-12">
			<div class=row>
				<div class="col-md-6 col-sm-4 col-xs-4">
					<div class="btn-group">
					<?php echo anchor('setup/uraian_tupoksi/add/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6), 
					'<button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data tupoksi"><i class="fa fa-plus"></i> Tambah Uraian</button>' );?>
					&nbsp;
					<?php echo anchor('setup/uraian_tupoksi/index/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6), 
					'<button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php echo form_open("setup/tupoksi/find");?>
				<div class="col-md-5 col-sm-4 col-xs-4">
					<div class='col-md-5'>
					<?php $option = array(
							'id_tupoksi'=>'Kode Tupoksi',
							'tahun'=>'Tahun',
							'aktif'=>'Aktif',
							'jenis_tupoksi'=>'Jenis Tupoksi'
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
				<th  class="col-md-8">Uraian Tupoksi</th>
				<th class="col-md-1">Jenis </th>
				<th  class="col-md-1"><center>Aktif</center></th>
				<th class="col-md-1"></th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($data_uraian){
	    		$i=1;
				foreach ($data_uraian as $row ) :
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->uraian_tupoksi?></td>
		        <td><?php echo $row->jenis_tupoksi?></td>
		        <td ><center><?php echo $row->aktif?></center></td>
		        <td>
		        <a href="<?php echo base_url('setup/uraian_tupoksi/modify/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$row->id_uraian) ?>"><button class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></button></a>
		        &nbsp;
		        <a href="<?php echo base_url('setup/uraian_tupoksi/remove/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$row->id_uraian) ?>" onclick="return confirm('Anda Yakin ?');"><button class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button></a>
				</center></td>
				</tr>
	        <?php 
	        	$i++;
				endforeach;
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
