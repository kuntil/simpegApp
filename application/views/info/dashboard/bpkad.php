<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="content-wrapper">
	<section class="content-header">
    <?php echo $pagetitle; ?>
    <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
    	<div class="row">
    		<?php 
    		if($list){
    		foreach ($list as $row ) :
    		?>
			<div class="col-md-4">
			<!-- Profile Image -->
          	<div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>upload/avatar/m_001.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $row->nama?></h3>

              <p class="text-muted text-center"><?php echo $row->nama_position?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Kinerja Bulanan [%]</b> <a class="pull-right"><?php echo $row->nilai_kinerja?></a>
                </li>
                <li class="list-group-item">
                  <b>Prilaku Bulanan [%]</b> <a class="pull-right"><?php echo $row->nilai_prilaku?></a>
                </li>
                <li class="list-group-item">
                  <b>Absensi [%]</b> <a class="pull-right"><?php echo $row->nilai_absensi?></a>
                </li>
                <li class="list-group-item">
                  <b>Seragam [%]</b> <a class="pull-right"><?php echo $row->nilai_pola?></a>
                </li>
                <li class="list-group-item">
                  <b>Total [K.40% + A.40% + S.10% ]</b> <a class="pull-right"><?php echo $row->total?></a>
                </li>
                
                
<!--                 <li class="list-group-item"> -->
<!--                   <b>Absen Pagi</b> <a class="pull-right"><input type="checkbox" name="absen1" disabled></a> -->
<!--                 </li> -->
<!--                  <li class="list-group-item"> -->
<!--                   <b>Absen Siang</b> <a class="pull-right"><input type="checkbox" name="absen2" disabled></a> -->
<!--                 </li> -->
<!--                 <li class="list-group-item"> -->
<!--                   <b>Absen Sore</b> <a class="pull-right"><input type="checkbox" name="absen3" disabled></a> -->
<!--                 </li> -->
                <li class="list-group-item">
                  <b>TKD</b> <a class="pull-right">Rp.<?php echo number_format($row->thp,2)?></a>
                </li>
              </ul>
<!--               <a href="#" class="btn btn-primary btn-block"><b>Detail</b></a> -->
            </div>
            <!-- /.box-body -->
			</div>
			</div>
			<?php 
			endforeach; } ?>
			</div>
         </div>
    </section>
</div>
