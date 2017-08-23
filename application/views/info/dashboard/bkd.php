<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="content-wrapper">
	<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Laporan bulan <?php echo date('F');?>.
		</h3>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<div class="col-sm-12">
			<div class=row>
				<div class="col-md-6 col-sm-4 col-xs-4">
					<div class="btn-group">
					<?php echo anchor('member/staff', 
					'<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php /* echo form_open("member/staff/find"); */?>
<!-- 				<div class="col-md-5 col-sm-4 col-xs-4"> -->
<!-- 					<div class='col-md-5'> -->
					<?php /* $option = array(
							'p.nip'=>'NIP',
							'p.nama'=>'Nama',
							'pt.nama_position'=>'Jabatan'
					 ); 
					echo form_dropdown('column',$option,'1','class="form-control"'); */?>
<!-- 					</div> -->
<!-- 					<div class="col-md-7"><input type="text" class="form-control" name="data" placeholder="Cari"></div> -->
<!-- 				</div> -->
<!-- 				<div class="btn-group"> -->
<!-- 					<input type="submit" name="submit" class="btn btn-info" title="Cari Data" value="Go"> -->
<!-- 				</div> -->
				<?php /* echo form_close(); */?>
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
				<th class="col-md-2">NIP</th>
				<th class="col-md-2">Nama </th>
				<th class="col-md-3">Jabatan</th>
				<th class="col-md-1">Nilai Absensi</th>
				<th class="col-md-1">Nilai Pola</th>
				<th class="col-md-1">Nilai Prilaku</th>
				<th class="col-md-1">Nilai Kinerja</th>
				<th class="col-md-1">Nilai Total</th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($list){
	    		$i=1;
				foreach ($list as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->nip?></td>
		        <td ><?php echo $row->nama?></td>
		        <td ><?php echo $row->nama_position?></td>
		        <td ><?php echo $row->nilai_absensi?></td>
		        <td ><?php echo $row->nilai_pola?></td>
		        <td ><?php echo $row->nilai_prilaku?></td>
		        <td ><?php echo $row->nilai_kinerja?></td>
		        <td ><?php echo $row->total?></td>
				</tr>
	        <?php 
	        	$i++;
				} 
	    	}else{
	        	echo "<tr class=\"gradeX\"><td colspan='5'>No Record</td></tr>";
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
