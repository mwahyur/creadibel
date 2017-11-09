<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('asset/images/creadiblehead.png') ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('nama'); ?></p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            </li>
            <li class="treeview">
                <a href="<?php echo site_url('admin/Home') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-suitcase"></i> <span>Produk</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo site_url('admin/Kategori_barang') ?>"><i class="fa fa-circle-o"></i>Kategori Produk</a></li>
                <li><a href="<?php echo site_url('admin/Subkategori_barang') ?>"><i class="fa fa-circle-o"></i>Sub Kategori Produk</a></li>
                    <li><a href="<?php echo site_url('admin/Barang') ?>"><i class="fa fa-circle-o"></i>Data Produk</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-group"></i> <span>Akun</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo site_url('admin/User_admin') ?>"><i class="fa fa-circle-o"></i>Privillages User Admin</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">