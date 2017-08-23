<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="content-wrapper">
	<section class="content-header">
    <?php echo $pagetitle; ?>
    <?php echo $breadcrumb; ?>
    </section>
     <section class="content">
	  <?php if($this->session->flashdata('message')){ ?>
			<div class="box-body">
			<div class="alert alert-danger alert-dismissible">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<?php echo $this->session->flashdata('message'); ?>x
			</div>
			</div>
			<?php }?>
      <div class="row">
        <div class="col-md-3">
		  <?php if ($admin_prefs['user_menu'] == TRUE): ?>
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('/upload/pegawai/'.$user_login['foto']); ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $user_login['username']; ?></h3>

              <p class="text-muted text-center"><?php echo $user_login['firstname'].$user_login['lastname']; ?></p>
              <p class="text-muted text-center"><small>Penilaian : <?php echo date('d/m/Y')?></small></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Kinerja</b> <a class="pull-right"><?php echo $user_login['kinerja']; ?>%</a>
                </li>
                <li class="list-group-item">
                  <b>Prilaku</b> <a class="pull-right"><?php echo $user_login['prilaku']; ?>%</a>
                </li>
                <li class="list-group-item">
                  <b>Absensi</b> <a class="pull-right"><?php echo $user_login['absensi']; ?></a>
                </li>
              </ul>
              <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Upload</button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  <?php endif; ?>
          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Profil</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i>Unit Kerja</strong>

              <p class="text-muted">
                <?php echo $unit?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i>Jabatan</strong>

              <p class="text-muted"> <?php echo $jabatan?></p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i>Informasi Lainnya</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
              
              <li ><a href="#timeline" data-toggle="tab">Timeline</a></li>
            </ul>
            <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <?php 
                  if($kegiatan){
                  $jenis= null;
                  foreach ($kegiatan as $row) :
                  if($row->jenis_tupoksi!=$jenis){
                  	$jenis = $row->jenis_tupoksi;
                  	echo '<li class="time-label">';
                  	echo '<span class="bg-green">';
                  	echo $row->jenis_tupoksi;
                  	echo '</span></li>';
                  }
                  ?>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-aqua"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                      <h3 class="timeline-header"><a href="#"></a> <?php echo $row->uraian_tupoksi?></h3>
                      <div class="timeline-body">
                        <?php echo $row->uraian_kegiatan?>
                      </div>
                      <div class="timeline-footer">
                        <a  href="<?php echo base_url('member/kegiatan/delete/'.$row->qid) ?>" onclick="return confirm('Anda Yakin ?');" class="btn btn-danger btn-xs">Hapus</a>
                      </div>
                    </div>
                  </li>
                  <?php endforeach; }?>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
                &nbsp;
               <form class="form-horizontal">
               <div class="form-group">
               		<div class="col-md-2"><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#kegiatanModal"><i class="fa fa-plus"></i> Kegiatan</button>
               		</div>	
               </div>
               </form>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Foto</h4>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('setup/pegawai/upload'); ?>
        <div class="form-group">
			<label >File input</label>
			<input type="file" name="userfile">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-info" value="Submit" name="submit">
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

<div id="kegiatanModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Foto</h4>
      </div>
      <div class="modal-body">
      <?php echo form_open('member/kegiatan/add'); 
      $nilai = null;
	  if($tupoksi){
      foreach ($tupoksi as $rew) :
		$nilai = $rew->id_tupoksi ;
	  endforeach;
	  }
      ?>
      	<input type="hidden" name="kd_tupoksi" value="<?php echo $nilai; ?>"\>
		<div class="form-group">
			<label >Uraian Tupoksi.</label>
			<select name="kd_uraian" class="form-control">
			<?php 
			if($tupoksi){
			foreach ($tupoksi as $rew) : ?>
				<option value="<?php echo $rew->id_uraian?>"><?php echo $rew->uraian_tupoksi ?></option>
			<?php endforeach;}?>
			</select>
		</div>
		<div class="form-group">
			<label >Kegiatan.</label>
			<textarea rows="10" name='uraian_kegiatan' class="form-control"></textarea>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-info" value="Submit" name="submit">
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

