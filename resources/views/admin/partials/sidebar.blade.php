<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Contents</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.company') }}">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Company</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.employees') }}">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">Employees</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Jobs Contents</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.jobs') }}">Jobs</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('jobs.category') }}">Job Category</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('jobs.roles') }}">Job Roles</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('jobs.types') }}">Job Types</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('jobs.industries') }}">Job Industries</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
