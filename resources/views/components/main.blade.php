@extends('components.header')
@extends('components.style')
@section('title', 'Dashboard')
@section('content')

<!-- <div class="card mb-3"> -->
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" style="background-color: darkblue;">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
            <div>
                <h5 style="color: white;">ADMINISTRASI</h5>
            </div>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/dashboard" class="nav-link text-white">Home</a></li>
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
                <li><a class="dropdown-item" href="/picalr">PICA Financial</a></li>
                    <li><a class="dropdown-item" href="#">Work Plan and Budget Income Statement</a></li>
                    <li><a class="dropdown-item" href="/indexneraca">Balance Sheet</a></li>
                    <li><a class="dropdown-item" href="#">Work Plan, Budget and Financial Statements</a></li>
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

        <div class="flex-shrink-0 dropdown">
            <a href="#" class="d-block link-dark text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li>
                    @auth
                        <p class="dropdown-item">{{ Auth::user()->username }}</p>
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
    </header>
</div>

<body>
<div class="card mb-3 text-center">
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
</body>
