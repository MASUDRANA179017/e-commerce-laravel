@extends('layouts.master')
@section('title','Dashboard')
@section('content')
<style>
    /* Adding some specific styles for the dashboard elements */
    .timeline {
        list-style: none;
        padding: 0;
        position: relative;
    }
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 20px;
        border-left: 2px solid #e9ecef;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -9px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid var(--primary-color, #7367F0);
    }
    .timeline-item:last-child {
        border-left: 2px solid transparent;
        padding-bottom: 0;
    }
    .saved-item-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: var(--app-border-radius);
    }
</style>

<div class="page-header">
    <h3 class="fw-bold mb-3">Dashboard</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="#"><i class="bx bxs-home"></i></a></li>
        <li class="separator"><i class="bx bx-chevron-right"></i></li>
        <li class="nav-item"><a href="#">Dashboard</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card card-stats card-round">
            <div class="card-body"><div class="d-flex align-items-center"><div class="icon-big text-center icon-primary bubble-shadow-small me-3"><i class="bx bxs-folder-open"></i></div><div class="numbers"><p class="card-category">Project Count</p><h4 class="card-title">15</h4></div></div></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
         <div class="card card-stats card-round">
            <div class="card-body"><div class="d-flex align-items-center"><div class="icon-big text-center icon-info bubble-shadow-small me-3"><i class="bx bx-customize"></i></div><div class="numbers"><p class="card-category">Components</p><h4 class="card-title">120</h4></div></div></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
         <div class="card card-stats card-round">
            <div class="card-body"><div class="d-flex align-items-center"><div class="icon-big text-center icon-success bubble-shadow-small me-3"><i class="bx bx-plug"></i></div><div class="numbers"><p class="card-category">Plugins Installed</p><h4 class="card-title">8</h4></div></div></div>
        </div>
    </div>
     <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
         <div class="card card-stats card-round">
            <div class="card-body"><div class="d-flex align-items-center"><div class="icon-big text-center icon-danger bubble-shadow-small me-3"><i class='bx bxs-save'></i></div><div class="numbers"><p class="card-category">Saved Items</p><h4 class="card-title">42</h4></div></div></div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title"><i class="bx bx-list-ul me-2"></i>Active Projects</h4>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm"><i class="bx bx-plus me-1"></i> New Project</button>
                        <button class="btn btn-info btn-sm"><i class="bx bx-upload me-1"></i> Upload Component</button>
                        <button class="btn btn-warning btn-sm text-dark"><i class="bx bx-plug me-1"></i> Add Plugin</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr><th>Project Name</th><th>Status</th><th>Last Edited</th><th class="text-end">Actions</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>E-commerce Website</td><td><span class="badge bg-success">Live</span></td><td>2 hours ago</td><td class="text-end"><a href="#" class="btn btn-sm btn-light">Edit</a> <a href="#" class="btn btn-sm btn-primary">View</a></td></tr>
                            <tr><td>CRM Dashboard</td><td><span class="badge bg-warning text-dark">In Progress</span></td><td>1 day ago</td><td class="text-end"><a href="#" class="btn btn-sm btn-light">Edit</a> <a href="#" class="btn btn-sm btn-primary">View</a></td></tr>
                            <tr><td>Mobile App UI Kit</td><td><span class="badge bg-danger">Paused</span></td><td>3 days ago</td><td class="text-end"><a href="#" class="btn btn-sm btn-light">Edit</a> <a href="#" class="btn btn-sm btn-primary">View</a></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7 mb-4">
        <div class="card h-100">
            <div class="card-header"><h4 class="card-title"><i class="bx bx-time-five me-2"></i>Recent Activity</h4></div>
            <div class="card-body">
                <ul class="timeline">
                    <li class="timeline-item"><h6 class="timeline-title">New component saved</h6><p class="timeline-text">"Hero Section v2" was added to your library.</p><small class="timeline-time">5 minutes ago</small></li>
                    <li class="timeline-item"><h6 class="timeline-title">Project "CRM Dashboard" updated</h6><p class="timeline-text">You pushed 3 new commits.</p><small class="timeline-time">1 hour ago</small></li>
                    <li class="timeline-item"><h6 class="timeline-title">Plugin "AI Assistant" installed</h6><p class="timeline-text">The plugin is now active on your projects.</p><small class="timeline-time">Yesterday</small></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card h-100">
            <div class="card-header"><h4 class="card-title"><i class="bx bxs-star me-2"></i>Saved Items Preview</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-sm-4 mb-3"><div class="saved-item-preview"><img src="https://via.placeholder.com/300x200/7367F0/FFFFFF?text=Hero" alt="Saved Item"></div></div>
                    <div class="col-6 col-sm-4 mb-3"><div class="saved-item-preview"><img src="https://via.placeholder.com/300x200/28C76F/FFFFFF?text=Navbar" alt="Saved Item"></div></div>
                    <div class="col-6 col-sm-4 mb-3"><div class="saved-item-preview"><img src="https://via.placeholder.com/300x200/FF9F43/FFFFFF?text=Card" alt="Saved Item"></div></div>
                    <div class="col-6 col-sm-4 mb-3"><div class="saved-item-preview"><img src="https://via.placeholder.com/300x200/EA5455/FFFFFF?text=Footer" alt="Saved Item"></div></div>
                    <div class="col-6 col-sm-4 mb-3"><div class="saved-item-preview"><img src="https://via.placeholder.com/300x200/00CFE8/FFFFFF?text=Table" alt="Saved Item"></div></div>
                    <div class="col-6 col-sm-4 mb-3"><div class="saved-item-preview"><img src="https://via.placeholder.com/300x200/82868B/FFFFFF?text=Chart" alt="Saved Item"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')



@endpush
@endsection
