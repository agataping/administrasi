@extends('components.header')
@extends('components.style')
@section('title', 'Dashboard')
@section('content')

    <header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color: #07a43b;">
    <a href="/dashboard" class="d-flex align-items-center text-decoration-none">
        <div class="ms-3">
            <h5 style="color: white; margin: 0;">ADMINISTRASI</h5>
        </div>
    </a>


        <ul class="nav nav-pills">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Customer Perspective
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/indexbarging">Barging</a></li>
                    <li><a class="dropdown-item " href="/indexpicabarging">PICA Barging</a></li>
                    <li><a class="dropdown-item " href="/stockjt">Stock JT</a></li>
                    <li><a class="dropdown-item " href="/picastockjt">PICA Stock JT</a></li>


                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Financial Perspective
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/labarugi">Profit and Loss</a></li>
                <li><a class="dropdown-item" href="/indexfinancial">Balance Sheet</a></li>
                <li><a class="dropdown-item" href="/picalr">PICA Financial</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Internal Process Perspective
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/indexovercoal">Over Barden & Coal </a></li>
                    <li><a class="dropdown-item" href="/picaobc">PICA Over Barden & Coal </a></li>
                    <li><a class="dropdown-item" href="/indexpaua">PA & UA</a></li>
                    <li><a class="dropdown-item " href="/picapaua">PICA PA & UA</a></li>
                    <li><a class="dropdown-item" href="/indexmining">Mining Readiness</a></li>
                    <li><a class="dropdown-item " href="/picamining">PICA Mining Readiness</a></li>
                    <li><a class="dropdown-item " href="/indexhse">HSE</a></li>
                    <li><a class="dropdown-item " href="/picahse">PICA HSE</a></li>
                    
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    
                    Learning & Growth Perspective
                </a>
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
        </ul>

        <div class="flex-shrink-0 dropdown me-3">
            <a href="#" class="d-block link-light text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 0.5rem;">
                <img src="img/profile.png" alt="Profile" width="32" height="32" class="rounded-circle border border-2 border-light">
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
        

    </header>

<body>
<div class="card mb-3 text-center align-items-center justify-content-center"  style="border-radius: 12px; overflow: hidden; margin: 2rem auto; height:80vh; ">
<div style="position: relative;" style="width: auto; height: auto; object-fit: cover;">
    <div class="cardcostum">
        <div class="cardcost">
            <h4><b>Qubah Group</b></h4>
            <div class="percentage-box">98%</div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <div class="cardcostum">
            <a href="/iup" class="cardcost text-decoration-none">
                <h4 class="text-white"><strong>IUP</strong></h4>
                <div class="percentage-box">100%</div>
            </a>
        </div>

        <div class="cardcostum">
            <a href="/kontraktor" class="cardcost text-decoration-none">
                <h4 class="text-white"><strong>Kontraktor</strong></h4>
                <div class="percentage-box">85%</div>
            </a>
        </div>

        <div class="cardcostum">
            <a href="/nonenergi" class="cardcost text-decoration-none">
                <h4 class="text-white"><strong>Non Energi</strong></h4>
                <div class="percentage-box">90%</div>
            </a>
        </div>

        <div class="cardcostum">
            <a href="/mineral" class="cardcost text-decoration-none">
                <h4 class="text-white"><strong>Marketing</strong></h4>
                <div class="percentage-box">95%</div>
            </a>
        </div>
    </div>
    </div>
    </div>
</body>
