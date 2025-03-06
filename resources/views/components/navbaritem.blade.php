@extends('components.header')
@extends('components.style')
@section('title', '')
<style>
    .nav-item:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu .dropdown-item {
        text-transform: uppercase;
        font-optical-sizing: auto;
        font-size: 14px;
        font-style: normal;
        font-weight: ;
        color: rgb(255, 255, 255);
    }

    .dropdown-menu {
        background: rgba(62, 61, 61, 0.47) !important;
        backdrop-filter: blur(10px);
        border-radius: 8px;
        border: 2px solid rgba(0, 0, 0, 0.3);
    }
</style>

<nav class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color: transparent; flex-wrap: nowrap;">
    <div class="d-flex align-items-center ms-3">
        <!-- Logo Bulat -->
        <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center; background-color: white; margin-right: 10px;">
            <img src="{{ asset('img/qubahGroup.jpeg') }}" alt="Logo"
                style="width: 90%; height: 90%; object-fit: contain;">
        </div>

        <!-- Teks -->
        <h5 style="color: white; margin: 0;">KPI</span><br>QUBAH GROUP</h5>
    </div>
    <a href="/historylog" class="d-flex align-items-center text-decoration-none">
        <div class="ms-3">
            <H6 style="color: white; margin: 0;">History Log</H6>
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
                <li><a class="dropdown-item" href="/indexovercoal">OverBUrden & Coal getting</a></li>
                <li><a class="dropdown-item" href="/picaobc">PICA OverBUrden & Coal getting</a></li>
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
                <li><a class="dropdown-item" href="/struktur">Organizational Structure</a></li>
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
            <li>
                <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#updatePasswordModal" style="gap: 0.5rem;">
                    <i class="fas fa-key"></i>
                    Update Password
                </button>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
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
<div class="card w-100" style="background-color:transparent ; border-bottom: 2px solid white; margin-top: -24px;">
    <div class="d-flex justify-content-start align-items-center ms-3 me-3 py-2">
        <i onclick="history.back()" class="fa fa-arrow-left" style="cursor: pointer; font-size: 20px; color: white; margin-right: 7px;"></i>
        <i onclick="history.forward()" class="fa fa-arrow-right" style="cursor: pointer; font-size: 20px; color: white; margin-right: 7px;"></i>
        <i onclick="location.reload()" class="fa fa-sync" style="cursor: pointer; font-size: 20px; color: white;"></i>
    </div>
</div>
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('updatePassword') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Old Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>