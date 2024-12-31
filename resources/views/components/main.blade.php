@extends('components.header')
@section('title', 'dashboard')
@section('content')

<div class="card -mb-3" >
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" style="background-color:darkblue;">
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <div>
                <h5  style=" color: white;">
                   ADMINISTRASI
                </h5>
            </div>
        </a>
        
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/dashboard" class="nav-link" style="color: white;">Home</a></li>
        <!-- selesai sisa laporan dan tampilan    -->
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Costumer Prespective
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/indexbarging">Barging</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/indexmproduction"> Monthly Production</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/indexCSmining">Mining Readines</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item " href="/indexPembebasanLahanCs">Pembebasan Lahan</a></li>
            <li><hr class="dropdown-divider"></li>
            


            <li><a class="dropdown-item" href="/indexdeadlineCostumers">Deadline Compentations</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>


        
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Finansial Persprektif
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="/index">Laba Rugi</a></li>
          <li><a class="dropdown-item" href="">RKAB Laba Rugi</a></li>
          <li><a class="dropdown-item" href="/indexhpp">HPP RKAB</a></li>
          <li><a class="dropdown-item" href="/indexneraca">Neraca</a></li>
          <li><a class="dropdown-item" href="">RAKB Neraca</a></li>
          <li><hr class="dropdown-divider"></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Internal Process Prespective          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/indexpaua">PA & UA</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>


            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Learning & Growth Prespective
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/indexPeople">People Readiness</a></li>
            <li><a class="dropdown-item" href="/indexInfrastructureReadiness">Infrastructure Readiness</a></li>
            <li><a class="dropdown-item" href="/indexmining">Mining Readiness</a></li>
            <li><a class="dropdown-item" href="/indexdeadline">Deadline Compensation</a></li>
            <li><a class="dropdown-item" href="/indexPembebasanLahan">Pembebasan Lahan</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>
        
        </ul>



        
        <div class="flex-shrink-0 dropdown">
            <a href="#" class="d-block link-dark text-decoration-none dropdown" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li>
                    @auth
                    <p class="dropdown-item"  >{{ Auth::user()->username }}</p>   
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
        <div style="position: relative;">
            <img src="{{asset('')}}" class="card-img-top" alt="..." style="height: 700px;">
            <div class="card-img-overlay d-flex align-items-center justify-content-center" style="position: absolute; top:0; left: 0; right: 0; bottom:  0; background: rgba(44, 40, 40, 0.7);">
                <div>
                <ul class="nav justify-content-center" >
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">
                      <h4 class="" style="color: dark;"><strong>IUP</strong></h4>
                    </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/kontraktor">
                      <h4 class="" style="color: dark;"><strong>Kontraktor</strong></h4>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/nonenergi">
                      <h4 class="" style="color: dark;"><strong>Non Energi</strong></h4>
                      </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/mineral">
                    <h4 class="" style="color: dark;"><strong>Mineral</strong></h4>
                      </a>
                    </li>
                  </ul>
                  <h1 class="card-title" style="color: dark;"><strong>ADMINISTRASI</strong></h1>
                  
                    <p class="card-text" style="color: dark;">
                        
                    <!-- <h3>
                        <strong>Arsip Surat Masuk & Surat Keluar</strong></p>
                    </h3> -->
                </div>
            </div>
        </div>
    </div>
</body>
