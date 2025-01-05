@extends('components.header')
@section('title', '')

    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" style="background:rgba(7, 164, 59, 0.7);">
      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <div>
  
                <h5  style=" color: white; text-align: center;">
                ADMINISTRASI</h5>

            </div>
            </a>            
            
    </header>
<body>
    
<div class="card mb-3 text-center">
        <div style="position: relative;">
            <img src="{{asset('img/qubahGroup.jpeg')}}" class="card-img-top" alt="..." style="height: 500px; width: auto;">
            <div class="card-img-overlay d-flex align-items-center justify-content-center" style="position: absolute; top:0; left: 0; right: 0; bottom:  0; background: rgba(100, 100, 100, 0.7);">
                <div>
                    <h1 class="card-title" style="color: dark;"><strong></strong></h1>
                    <p class="card-text" style="color: dark;"> 
                        
                    <!-- <h3>
                        <strong>ADMINISTRASI</strong></p>
                    </h3> -->
                    <p>
                    <a href="/login" class="btn btn-lg btn-outline-primary">Login</a>

                    </p>
                </div>
            </div>
        </div>
</body>
