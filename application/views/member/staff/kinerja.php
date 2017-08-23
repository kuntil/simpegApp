<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Penilaian Kinerja Tanggal : <?php echo date('j F Y')?></h3>
</div>
</section>
<?php if($list_tupoksi){?>
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
				echo form_open('member/staff/kinerja/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6));
			?>
				<div class="box-body">
					<div class="col-lg-12">
					</div>
					<?php $i=0; foreach ($list_tupoksi as $row ) : $i++; ?>
					<div class="col-lg-12">
					<div class="col-lg-1">
						<div class="form-group">
							<label><?php echo $i?>.</label>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="form-group">
							<textarea class="form-control" readonly="readonly"><?php echo $row->uraian_kegiatan?></textarea>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Nilai</label>
							<?php if($row->nilai){?>
							<input type="number" name="nilai[]" class="form-control" value="<?php echo $row->nilai?>" max="5" min="1" readonly="readonly"> 
							<?php }else{ ?>
							<input type="number" name="nilai[]" class="form-control" value="<?php echo $row->nilai?>" max="5" min="1"> 
							<?php } ?>
							<input type="hidden" name="qid[]" value="<?php echo $row->qid?>"> 
						</div>
					</div>
					</div>
					<?php endforeach;?>
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
<?php } ?>
</div>
