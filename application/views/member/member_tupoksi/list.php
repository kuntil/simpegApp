<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Tambah Data SKPD</h3>
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
			if($this->uri->segment(3)=="add"){
				echo form_open('member/member_tupoksi/generate/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/skpd/modify/'.$this->uri->segment(4));
			}else{
				echo form_open('setup/skpd/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-12">
					<div class="col-lg-1"></div>
					<div class="col-lg-5">
						<div class="form-group">
							<label >Tanggal Aktifitas</label>
							<div class="input-group date" data-provide="datepicker">
						    	<input type="text" name="tgl_kegiatan" class="form-control" >
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>
					</div>
					<?php if($list_tupoksi){ $i=0; foreach ($list_tupoksi as $row ) : $i++; ?>
					<div class="col-lg-12">
					<div class="col-lg-1">
						<div class="form-group">
							<label><?php echo $i?>.</label>
						</div>
					</div>
					<div class="col-lg-10">
						<div class="form-group">
							<textarea class="form-control" readonly="readonly"><?php echo $row->uraian_tupoksi?></textarea>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<input type="checkbox" name="qid[]" value="<?php echo $row->qid?>" checked="checked"> 
						</div>
					</div>
					</div>
					<?php endforeach; }?>
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('member/staff', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>