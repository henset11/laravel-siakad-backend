<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">SIAKAD</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SKD</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ $type_menu === '' ? 'active' : '' }}">
                <a href="/" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Management</li>
            <li class="nav-item dropdown {{ $type_menu === 'user' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('siswa') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('siswa.index') }}">Siswa</a>
                    </li>
                    <li class="{{ Request::is('tutor') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tutor.index') }}">Tutor</a>
                    </li>
                    <li class="{{ Request::is('karyawan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('karyawan.index') }}">Karyawan</a>
                    </li>
                    <li class="{{ Request::is('admin') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="far fa-square"></i> <span>Kelas</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="far fa-square"></i> <span>Mata
                        Pelajaran</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="far fa-square"></i>
                    <span>Ruangan</span></a>
            </li>

            <div class="hide-sidebar-mini mt-4 mb-4 p-3">
                <a href="#" class="btn btn-primary btn-lg btn-block btn-icon-split">
                    <i class="fas fa-rocket"></i> Documentation
                </a>
            </div>
    </aside>
</div>
