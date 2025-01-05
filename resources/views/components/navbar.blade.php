@extends('components.header')
@section('title', '')
<nav class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color: darkblue;">
    <a href="/" class="d-flex align-items-center text-decoration-none">
        <div class="ms-3">
            <h5 style="color: white; margin: 0;">ADMINISTRASI</h5>
        </div>
    </a>

    <ul class="nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Costumer Prespective</a>
            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item " href="/indexbarging">Barging</a></li>
<!-- 
                <li><a class="dropdown-item " href="/indexmproduction">Monthly Production</a></li>


                <li><a class="dropdown-item " href="/indexPembebasanLahanCs">Pembebasan Lahan</a></li>

                <li><a class="dropdown-item " href="/indexdeadlineCostumers">Deadline Compensations</a></li>
 -->

            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Finansial Perspektif</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/index">Profit and Loss</a></li>
                <li><a class="dropdown-item" href="">Work Plan and Budget Income Statement</a></li>
                <li><a class="dropdown-item" href="/indexneraca">Balance Sheet </a></li>
                <li><a class="dropdown-item" href="">Work Plan, Budget and Financial Statements</a></li>

            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Internal Process Perspective</a>
            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item " href="/indexpaua">PA & UA</a></li>
                <li><a class="dropdown-item " href="/indexCSmining">Mining Readiness</a></li>

            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Learning & Growth Perspective</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/indexPeople">People Readiness</a></li>
                <li><a class="dropdown-item" href="/indexInfrastructureReadiness">Infrastructure Readiness</a></li>

                <li><a class="dropdown-item" href="/indexdeadline">Deadline Compensation</a></li>
                <li><a class="dropdown-item" href="/indexPembebasanLahan">Land Acquisition</a></li>

              </ul>
        </li>

        <li class="nav-item"><a href="/dashboard" class="nav-link text-white">Home</a></li>
    </ul>

    <div class="flex-shrink-0 dropdown me-3">
        <a href="#" class="d-block link-light text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="img/profile.png" alt="Profile" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li>
                @auth
                <p class="dropdown-item">{{ Auth::user()->name }}</p>
                @endauth
            </li>
            <li>
                <form action="{{ url('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">Sign out</a>
                </form>
            </li>
        </ul>
    </div>

</nav>
<div class="card w-100" style="background-color: darkblue; border-bottom: 2px solid black; margin-top: -24px;">
    <div class="d-flex justify-content-start align-items-center ms-3 me-3 py-2">
        <i onclick="history.back()" class="fa fa-arrow-left" style="cursor: pointer; font-size: 20px; color: gray; margin-right: 7px;"></i>
        <i onclick="history.forward()" class="fa fa-arrow-right" style="cursor: pointer; font-size: 20px; color: gray; margin-right: 7px;"></i>
        <i onclick="location.reload()" class="fa fa-sync" style="cursor: pointer; font-size: 20px; color: gray;"></i>
    </div>
</div>
