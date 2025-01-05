@extends('components.header')
@extends('components.style')
@section('title', 'dashboard')
@section('content')

<div class="card mb-3">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" style="background-color:darkblue;">
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <div>
                <h5 style="color: white;">
                   ADMINISTRASI
                </h5>
            </div>
        </a>
        
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/dashboard" class="nav-link" style="color: white;">Home</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Customer Perspective
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/indexbarging">Barging</a></li>

                <li><a class="dropdown-item" href="/indexmproduction">Monthly Production</a></li>

                <li><a class="dropdown-item" href="/indexCSmining">Mining Readiness</a></li>

                <li><a class="dropdown-item" href="/indexPembebasanLahanCs">Pembebasan Lahan</a></li>

                <li><a class="dropdown-item" href="/indexdeadlineCostumers">Deadline Compensations</a></li>

              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Financial Perspective
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/index">Profit and Loss</a></li>
                <li><a class="dropdown-item" href="">Work Plan and Budget Income Statement</a></li>
                <li><a class="dropdown-item" href="/indexneraca">Balance Sheet </a></li>
                <li><a class="dropdown-item" href="">Work Plan, Budget and Financial Statements</a></li>

              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Internal Process Perspective
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/indexpaua">PA & UA</a></li>
                <li><a class="dropdown-item" href="/indexmining">Mining Readiness</a></li>

              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" style="color: white;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Learning & Growth Perspective
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/indexPeople">People Readiness</a></li>
                <li><a class="dropdown-item" href="/indexInfrastructureReadiness">Infrastructure Readiness</a></li>

                <li><a class="dropdown-item" href="/indexdeadline">Deadline Compensation</a></li>
                <li><a class="dropdown-item" href="/indexPembebasanLahan">Land Acquisition</a></li>

              </ul>
            </li>
        </ul>

        <div class="flex-shrink-0 dropdown">
            <a href="#" class="d-block link-dark text-decoration-none dropdown" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
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
    <div style="position: relative;">
      
        <img src="{{ asset('img/qubahGroup.jpeg') }}" class="card-img-top" alt="..." style="height: 500px; width: auto;">
        <div class="card-img-overlay d-flex align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; right: 0; bottom:  0; background: rgba(44, 40, 40, 0.7); z-index: 2;">
            <div>
              <div class="cardcostum">
                <div class="cardcost">
                  <h4><b>Qubah Group </b></h4>
                  <div class="percentage-box" >
                    98%
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center gap-3">
                <div class="cardcostum">
                  <a href="/iup" class="cardcost text-decoration-none">
                    <h4 style="color: white;"><strong>IUP</strong></h4>
                    <div class="percentage-box">100%</div>
                  </a>
                </div>
                
                <div class="cardcostum">
                  <a href="/kontraktor" class="cardcost text-decoration-none">
                    <h4 style="color: white;"><strong>Kontraktor</strong></h4>
                    <div class="percentage-box">85%</div>
                  </a>
                </div>
                
                <div class="cardcostum">
                  <a href="/nonenergi" class="cardcost text-decoration-none">
                    <h4 style="color: white;"><strong>Non Energi</strong></h4>
                    <div class="percentage-box">90%</div>
                  </a>
                </div>
                
                <div class="cardcostum">
                  <a href="/mineral" class="cardcost text-decoration-none">
                    <h4 style="color: white;"><strong>Mineral</strong></h4>
                    <div class="percentage-box">95%</div>
                  </a>
                </div>
              </div>
              
              
              
              
              
            </div>
          </div>
        </div>
      </div>
    </body>
    


