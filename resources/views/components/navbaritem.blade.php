@extends('components.header')
@section('title', '')
<style>
.nav-item:hover .dropdown-menu {
    display: block;
}

</style>

<nav class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color: #07a43b;">
    <a href="/dashboard" class="d-flex align-items-center text-decoration-none">
        <div class="ms-3">
            <h5 style="color: white; margin: 0;">ADMINISTRATION</h5>
        </div>
    </a>
    <a href="/historylog" class="d-flex align-items-center text-decoration-none">
        <div class="ms-3">
            <h5 style="color: white; margin: 0;">History Log</h5>
        </div>
    </a>
    
    

    <ul class="nav">
        <li class="nav-item dropdown">
            <a a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" aria-expanded="false">Costumer Prespective</a>
            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item " href="/indexbarging">Barging</a></li>
            <li><a class="dropdown-item " href="/indexpicabarging">PICA Barging</a></li>
            <li><a class="dropdown-item " href="/dashboardstockjt">Stock Jetty</a></li>
            <li><a class="dropdown-item " href="/picastockjt">PICA Stock Jetty</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" aria-expanded="false">Finansial Perspektif</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/labarugi">Profit and Loss</a></li>
                <li><a class="dropdown-item" href="/indexfinancial">Balance Sheet </a></li>
                <li><a class="dropdown-item" href="/picalr">PICA Financial</a></li>

                 

            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" aria-expanded="false">Internal Process Perspective</a>
            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/indexovercoal">Over Barden & Coal </a></li>
                <li><a class="dropdown-item" href="/picaobc">PICA Over Barden & Coal </a></li>
                <li><a class="dropdown-item " href="/indexpaua">PA & UA</a></li>
                <li><a class="dropdown-item " href="/picapaua">PICA PA & UA</a></li>
                <li><a class="dropdown-item " href="/indexewhfuel">EWH & FUEL</a></li>
                <li><a class="dropdown-item " href="/picaewhfuel">PICA EWH & FUEL</a></li>
                <li><a class="dropdown-item " href="/indexmining">Mining Readiness</a></li>
                <li><a class="dropdown-item " href="/picamining">PICA Mining Readiness</a></li>
                <li><a class="dropdown-item " href="/indexhse">HSE</a></li>
                <li><a class="dropdown-item " href="/picahse">PICA HSE</a></li>
                
            </ul>
        </li>
        

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" aria-expanded="false">Learning & Growth Perspective</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/struktur">Struktur Organisasi</a></li>
            <li><a class="dropdown-item" href="/indexPeople">People Readiness</a></li>
            <li><a class="dropdown-item" href="/indexpicapeople">PICA People Readiness</a></li>
                <li><a class="dropdown-item" href="/indexInfrastructureReadiness">Infrastructure Readiness</a></li>
                <li><a class="dropdown-item" href="/picainfrastruktur">PICA Infrastructure Readiness</a></li>
                
                <li><a class="dropdown-item" href="/indexdeadline">Deadline Compensation</a></li>
                <li><a class="dropdown-item" href="/picadeadline">PICA Deadline Compensation</a></li>
                <li><a class="dropdown-item" href="/indexPembebasanLahan">Land Acquisition</a></li>
                <li><a class="dropdown-item" href="/picapl">PICA Land Acquisition</a></li>
                
            </ul>
        </li>
        
        <li class="nav-item"><a href="/dashboard" class="nav-link text-white">Home</a></li>
    </ul>
    
    
    <div class="flex-shrink-0 dropdown me-3">
    <a href="#" class="d-block link-light text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 0.5rem;">
        <img src="img/profil.jpg" alt="Profile" width="32" height="32" class="rounded-circle border border-2 border-light">
        <i class="bi bi-chevron-down text-white"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser2" style="min-width: 200px; border-radius: 8px; overflow: hidden;">
        <li class="dropdown-item text-muted px-3">
            <i class="bi bi-person-circle me-2 text-primary"></i>
            {{ Auth::user()->name }}
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ url('logout') }}" method="POST" id="logout-form">
                @csrf
                <button class="dropdown-item text-danger d-flex align-items-center" style="gap: 0.5rem;" type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    Sign out
                </button>
            </form>
        </li>
    </ul>
</div>


</nav>
<div class="card w-100" style="background-color: #07a43b; border-bottom: 2px solid white; margin-top: -24px;">
    <div class="d-flex justify-content-start align-items-center ms-3 me-3 py-2">
        <i onclick="history.back()" class="fa fa-arrow-left" style="cursor: pointer; font-size: 20px; color: white; margin-right: 7px;"></i>
        <i onclick="history.forward()" class="fa fa-arrow-right" style="cursor: pointer; font-size: 20px; color: white; margin-right: 7px;"></i>
        <i onclick="location.reload()" class="fa fa-sync" style="cursor: pointer; font-size: 20px; color: white;"></i>
    </div>
</div>
