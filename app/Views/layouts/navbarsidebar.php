<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= base_url(); ?>/assets/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ba musren</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>/assets/dist/img/<?= user()->user_image; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= user()->username; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item li-dashboard">
                    <a href="#" class="nav-link ahref-dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/" class="nav-link ahref-home">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/gantipassword" class="nav-link ahref-gantipassword">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ganti Password</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item li-datamaster">
                        <a href="#" class="nav-link ahref-datamaster">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Data Master
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/masterusers" class="nav-link ahref-users">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Users</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/mastervisi" class="nav-link ahref-visi">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Visi</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/mastermisi" class="nav-link ahref-misi">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Misi</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/mastertujuan" class="nav-link ahref-tujuan">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tujuan</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/mastersasaran" class="nav-link ahref-sasaran">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sasaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item li-datamaster-cetak">
                        <a href="#" class="nav-link ahref-datamaster-cetak">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Cetak (admin)
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/masterprinttujuanpd" class="nav-link ahref-cetaktujuanpd">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print Tujuan PD</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/masterprintsasaranpd" class="nav-link ahref-cetaksasaranpd">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print Sasaran PD</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_groups('user')) : ?>
                    <li class="nav-item li-form">
                        <a href="#" class="nav-link ahref-form">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Forms
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/entrytujuanpd" class="nav-link ahref-entrypd">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Entri Tujuan PD</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/entrysasaranpd" class="nav-link ahref-entrysaspd">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Entri Sasaran PD</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/programopd" class="nav-link ahrefprogramopd">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Program OPD</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Cetak
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/viewprintpdftujuanpd" class="nav-link" target="_blank">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print Tujuan PD</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/printsipd" class="nav-link" target="_blank">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print SIPD Scraping</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/viewprintpdfsasaranpd" class="nav-link" target="_blank">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print Sasaran PD</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_groups('bidangadmin')) : ?>
                    <li class="nav-item liformbidangadmin">
                        <a href="#" class="nav-link ahrefformbidangdamin">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Forms
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/entryusulan" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Entri Penandatanganan</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/entryusulan" class="nav-link ahrefbidangadmin">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Entri Usulan</p>
                                </a>
                            </li>
                        </ul>                        
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Cetak
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/viewprintpdftujuanpd" class="nav-link" target="_blank">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print BA</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/printsipd" class="nav-link" target="_blank">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Print Lampiran BA</p>
                                </a>
                            </li>
                        </ul>                        
                    </li>
                <?php endif; ?>

                <!-- <li class="nav-item li-tables">
                    <a href="#" class="nav-link a-href-tables">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/table" class="nav-link a-href-tables">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tabel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/komik" class="nav-link a-href-komik">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Komik</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="nav-item">
                    <a href="<?= base_url('logout'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            log out
                            <!-- <i class="fas fa-angle-left right"></i> -->
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>