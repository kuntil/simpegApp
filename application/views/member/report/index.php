<div class="content-wrapper">
<section class="content-header">
</section>
<section class="content">
<div class="row">
<div class="panel panel-primary">
<div class="panel-heading">
<h3>
<i class="fa fa-user"></i> Report Collection
</h3>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
<div class="col-sm-12">
<div class=row>
<div class="col-md-6 col-sm-4 col-xs-4">
<div class="btn-group">
<?php echo anchor('member/report_collection',
		'<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i> Refresh </button>' );?>
					</div>
				</div>
				<?php echo form_open("member/report_collection/find");?>
				<div class="col-md-5 col-sm-4 col-xs-4">
					<div class='col-md-5'>
					<?php $option = array(
							'report_name'=>'Report Name'
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
				<th class="col-md-10">Report Name</th>
				<th class="col-md-2"><center>Ket</center></th>
			</tr>
			</thead>
			<tbody>
	    	<?php
	    	if($list_report){
	    		$i=1;
				foreach ( $list_report as $row ) {
			?>
		        <tr class="gradeX">
		        <td ><center><?php echo $i?>.</center></td>
		        <td ><?php echo $row->report_name?></td>
		        <td ><center>
				<a href="<?php echo base_url($row->report_link) ?>" onclick="return confirm('Anda Yakin ?');">To Report</a>
				</center></td>
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
