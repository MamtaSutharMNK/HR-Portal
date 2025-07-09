<div class="sidebar-sticky-wrapper"> 

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->  
        <a class="sidebar-brand d-flex align-items-center justify-content-right" href="{{route('index')}}">
            <div class="sidebar-brand-icon ml-2">
                 <img src="{{ asset('static/img/MNK group Logo.svg') }}" alt="MNK Group Logo" style="height: 20px; width: 50px; background-color:white; border-radius:2px; ">
            </div>
            <div class="sidebar-brand-text ml-2" style="text-transform: none;">{{  str_replace('_', ' ', config('app.name')) }} </div>
        </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="{{route('index')}}">
            <i class="fas fa-home fa-fw"></i>
            <span>Dashboard</span></a>
    </li>

     <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{route('fte_request.index')}}">
            <i class="fas fa-file-alt fa-fw"></i>
            <span>FTE Request Form</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{route('fte_request.create',['view' => 'manager']) }}">
            <i class="fas fa-user-tie fa-fw"></i>
            <span>Manager Level List</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{route('fte_request.create',['view' => 'hr']) }}">
            <i class="fas fa-users fa-fw"></i>
            <span>HR Level List</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-ticket-alt fa-fw"></i>
            <span>Support Tickets</span></a>
    </li>
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Toggle sidebar" ></button>
    </div> -->
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
  <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Toggle sidebar"></i>
</button>
</div>
</ul>
</div>

