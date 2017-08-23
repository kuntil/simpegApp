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
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('/upload/pegawai/'.$row->picture); ?>" alt="User profile picture">

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
                  <b>Seragam [%]</b> <a class="pull-right"><?php echo $row->nilai_pola?></a>
                </li>
                <li class="list-group-item">
                  <b>Total [K.60% + P.40% ]</b> <a class="pull-right"><?php echo $row->total?></a>
                </li>
                <li class="list-group-item">
                  <b>Reward & Punishment : </b>
                </li>
                 <li class="list-group-item">
                  <b><?php 
                  if($row->total > 95){
                  	echo "<span class='text-green'>Kompensansi, Penghargaan, Promosi Jabatan</span>";
                  }else if($row->total > 90){
                  	echo "<span class='text-green'>Kompensasi, Pemberian Tugas Khusus/ Tambahan</span>";
                  }else if($row->total > 80){
                  	echo "<span class='text-green'>Kompensasi, Diklat Lanjutan</span>"; 
                  }else if($row->total > 70){
                  	echo "<span class='text-green'>Diklat Lanjutan</span>"; 
                  }else if($row->total > 60){
                  	echo "<span class='text-red'>Teguran Lisan</span>"; 
                  }else if($row->total > 50){
                  	echo "<span class='text-red'>Teguran Tertulis</span>"; 
                  }else if($row->total > 40){
                  	echo "<span class='text-red'>Sanksi / Pensiun Dini</span>"; 
                  }else{
                  	echo "<span class='text-red'>Pemberhentian</span>"; 
                  }
                  ?></b>
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
