@extends('components.header')
@extends('components.style')
@section('title', 'Dashboard')
@section('content')

<header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color:transpant;">
    <a href="/dashboard" class="d-flex align-items-center text-decoration-none">
    <div class="d-flex align-items-center ms-3">
    <!-- Logo Bulat -->
    <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center; background-color: white; margin-right: 10px;">
        <img src="{{ asset('img/qubahGroup.jpeg') }}" alt="Logo" 
             style="width: 90%; height: 90%; object-fit: contain;">
    </div>

    <!-- Teks -->
    <h5 style="color: white; margin: 0;">ADMINISTRATION <br>QUBAH GROUP</h5>
</div>
    <div class="d-flex align-items-center ms-auto">
        @if (Auth::user()->role === 'admin')
            <a href="/register" class="d-flex align-items-center text-decoration-none me-3">
                <div>
                    <h5 style="color: white; margin: 0;">Add User</h5>
                </div>
            </a>
        @endif
        <a href="/historylog" class="d-flex align-items-center text-decoration-none">
            <div class="me-3">
                <h5 style="color: white; margin: 0;">History Log</h5>
            </div>
        </a>
    </div>
    

        <div class="flex-shrink-0 dropdown me-3">
            <a href="#" class="d-block link-light text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 0.5rem;">
                <img src="{{asset('storage/gambar/profil.jpg')}}" alt="Profile" width="32" height="32" class="rounded-circle border border-2 border-light">
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
<div class="background-full" style="background:  url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="card mb-3 "  style="border-radius: 12px;  margin: 2rem auto; height:80vh; background-color: transparent ">

    <div class="card-img-overlay d-flex align-items-center justify-content-center" style="text-align: center; background-color: transparent !important;">
                    <div>
<div style="position: relative;" style="width: auto; height: auto; object-fit: cover; background-color: transparent">

    <div class="cardcostum" >
        <div class="cardcost">
            <h4><b>QUBAH GROUP </b></h4>
            <div class="percentage-box">98%</div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3" style="margin: 80px auto; ">
        <div class="cardcostum">
            <a href="/iup" class="cardcost text-decoration-none">
                <h4 class="text-black"><strong>IUP</strong></h4>
                <div class="percentage-box">100%</div>
            </a>
        </div>

        <div class="cardcostum">
            <a href="/kontraktor" class="cardcost text-decoration-none">
                <h4 class="text-black"><strong>Kontraktor</strong></h4>
                <div class="percentage-box">85%</div>
            </a>
        </div>

        <div class="cardcostum">
            <a href="/nonenergi" class="cardcost text-decoration-none">
                <h4 class="text-black"><strong>Non Energi</strong></h4>
                <div class="percentage-box">90%</div>
            </a>
        </div>

        <div class="cardcostum">
            <a href="/mineral" class="cardcost text-decoration-none">
                <h4 class="text-black"><strong>Marketing</strong></h4>
                <div class="percentage-box">95%</div>
            </a>
        </div>
    </div>
    </div>
    </div>
    </div>
</body>
