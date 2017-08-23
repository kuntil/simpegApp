<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <aside class="main-sidebar">
                <section class="sidebar">
<?php if ($admin_prefs['user_panel'] == TRUE): ?>
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url($avatar_dir . '/m_001.png'); ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $user_login['firstname'].$user_login['lastname']; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('menu_online'); ?></a>
                        </div>
                    </div>

<?php endif; ?>
<?php if ($admin_prefs['sidebar_form'] == TRUE): ?>
                    <!-- Search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="<?php echo lang('menu_search'); ?>...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
<?php endif; ?>
                    <!-- Sidebar menu -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="<?php echo site_url('/'); ?>">
                                <i class="fa fa-home text-primary"></i> <span><?php echo lang('menu_access_website'); ?></span>
                            </a>
                        </li>

                        <li class="header text-uppercase"><?php echo lang('menu_main_navigation'); ?></li>
                        <li class="<?=active_link_controller('dashboard')?>">
                            <a href="<?php echo site_url('admin/dashboard'); ?>">
                                <i class="fa fa-dashboard"></i> <span><?php echo lang('menu_dashboard'); ?></span>
                            </a>
                        </li>
                        
                        <li class="treeview <?=active_link_controller('prefs')?>">
                            <a href="">
                                <i class="fa fa-database"></i>
                                <span><?php echo lang('menu_kepegawaian'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/pegawai'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_pegawai'); ?></a></li>
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/riwayat_pendidikan'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_pendidikan'); ?></a></li>
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/riwayat_kepangkatan'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_kepangkatan'); ?></a></li>
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/riwayat_jabatan'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_jabatan'); ?></a></li>
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/riwayat_penghargaan'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_penghargaan'); ?></a></li>
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/riwayat_hukuman'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_hukuman'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?=active_link_controller('files')?>">
                        	<a href="">
                                <i class="fa fa-cogs"></i>
                                <span><?php echo lang('menu_setup'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            	<li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/skpd'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_skpd'); ?></a></li>
                            	<li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/position'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_position'); ?></a></li>
                                <li class="<?=active_link_function('interfaces')?>"><a href="<?php echo site_url('setup/tupoksi'); ?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_tupoksi'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?=active_link_controller('database')?>">
                        	<a href="<?php echo site_url('member/report_collection/index'); ?>">
                                <i class="fa fa-file"></i>
                                <span><?php echo lang('menu_report'); ?></span>
                            </a>
                        </li>

                        <li class="header text-uppercase"><?php echo lang('menu_administration'); ?></li>
                        <li class="<?=active_link_controller('users')?>">
                            <a href="<?php echo site_url('admin/users'); ?>">
                                <i class="fa fa-user"></i> <span><?php echo lang('menu_users'); ?></span>
                            </a>
                        </li>
                        <li class="<?=active_link_controller('groups')?>">
                            <a href="<?php echo site_url('admin/groups'); ?>">
                                <i class="fa fa-shield"></i> <span><?php echo lang('menu_security_groups'); ?></span>
                            </a>
                        </li>
                        
                    </ul>
                </section>
            </aside>
