<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="<?= base_url()?>/assets/img/logo.png" style="width: 80px;">
        </div>
        <div class="sidebar-brand-text mx-3">Informasi Karyawan</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (uri_string() == '/dashboard' ? 'active' : '') ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Karyawan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Tables -->
    <li class="nav-item <?= (uri_string() == '/extention' ? 'active' : '') ?>">
        <a class="nav-link" href="<?= base_url('extention') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Extention</span></a>
    </li>
    <?php if(!empty(user())){ ?>
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master</span>
        </a>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= (uri_string() == '/deputi' ? 'active' : '') ?>" href="<?= base_url('deputi') ?>">Direktorat</a>
                <a class="collapse-item <?= (uri_string() == '/unit' ? 'active' : '') ?>" href="<?= base_url('unit') ?>">Unit</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>