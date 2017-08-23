<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>
			<i class="fa fa-user"></i> Master Tupoksi / Daftar Staff
		</h3>
	</div>
	<!-- /.panel-heading -->
	<div class="panel-body">
		<div class="col-sm-12">
				<div class="box box-solid box-default">
				<div class="box-body">
				<?php foreach ($bln as $row) :?>
						<div class="col-lg-6">
							<div class="form-group">
								<label >Nip.</label>
								<input type="text" readonly="readonly" class="form-control" value="<?php echo $row->nip?>">
							</div>
							<div class="form-group">
								<label >Bulan.</label>
								<input type="text" readonly="readonly" class="form-control" value="<?php echo $row->bulan?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
									<label >Nama.</label>
									<input type="text" readonly="readonly" class="form-control" value="<?php echo $row->nama?>">
								</div>
							<div class="form-group">
								<label >Pencapaian Bulanan [%] </label>
								<input type="text" readonly="readonly" class="form-control" value="<?php echo $row->persentase?>">
							</div>
						</div>
						<div class="col-lg-12">
						</div>
				<?php endforeach;?>
				</div>
				</div>
		</div>
	</div>
	<div class="panel-body">
	<div class="col-sm-12">
		<div class="box box-solid box-default">
		<div class="box-body">
		<div class="dataTable_wrapper">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th><center>#</center></th>
				<th class="col-md-2">Tgl. Kegiatan</th>
				<th class="col-md-4">Uraian Tupoksi </th>
				<th class="col-md-4">Kegiatan </th>
				<th class="col-md-1">Nilai</th>
				<th class="col-md-1"><center>%</center></th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($harian){
	    		$i=1;
				foreach ( $harian as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->tgl_kegiatan?></td>
		        <td ><?php echo $row->uraian_tupoksi?></td>
		        <td ><?php echo $row->uraian_kegiatan?></td>
		        <td ><?php echo $row->nilai?></td>
		        <td ><?php echo $row->persentase?></td>
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
	</div>
</div>
</div>
</section>
</div>
