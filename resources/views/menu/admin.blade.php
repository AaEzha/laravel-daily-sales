<li class="nav-item {{ Nav::isRoute('member.index') }}">
    <a class="nav-link" href="{{ route('member.index') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Daftar Sales</span>
    </a>
</li>

<li class="nav-item {{ Nav::isRoute('admin.tasks') }}">
    <a class="nav-link" href="{{ route('admin.tasks') }}">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>DB Client</span>
    </a>
</li>

{{-- <li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Kehadiran</span>
    </a>
</li> --}}

{{-- <li class="nav-item {{ Nav::isRoute('admin.pengumuman') }}">
    <a class="nav-link" href="{{ route('admin.pengumuman') }}">
        <i class="fas fa-fw fa-bell"></i>
        <span>Pengumuman</span>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Lainnya</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Master Data:</h6>
            <a class="collapse-item" href="{{ route('admin.posisi') }}">Posisi</a>
        </div>
    </div>
</li> --}}
