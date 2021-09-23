<li class="nav-item {{ Nav::isRoute('member.konsumen') }}">
    <a class="nav-link" href="{{ route('member.konsumen') }}">
        <i class="fas fa-fw fa-user-plus"></i>
        <span>Data Konsumen</span>
    </a>
</li>

<li class="nav-item {{ Nav::isRoute('member.tasks') }}">
    <a class="nav-link" href="{{ route('member.tasks') }}">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>DB Task Client</span>
    </a>
</li>
