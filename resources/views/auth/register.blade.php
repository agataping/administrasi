@extends('components.header')
@extends('components.style')
@section('title', 'Dashboard')
@section('content')
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Registrasi</title>
    <link href="{{asset ('style/assets/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  </head>
  
  
  <header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color: #07a43b;">
    <a href="/dashboard" class="d-flex align-items-center text-decoration-none">
      <div class="ms-3">
        <h5 style="color: white; margin: 0;">ADMINISTRATION</h5>
      </div>
    </a>
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
  
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  
  
  
  <body class="">
    <section >
      <div class="mask d-flex align-items-center h-47 gradient-custom-3">
        <div class="container h-47">
          <div class="row d-flex justify-content-center align-items-center h-47">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
              <div class="card" style="border-radius: 15px;">
                <div class="card-body p-5">
                  <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                  
                  <form method="POST" action="{{ url('/daftar') }}" autocomplete="off">
                    @csrf
                    
                    <div style="margin-bottom: 1rem;">
                      <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Companyy:</label>
                      <select id="kategori" name="id_company" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                        <option value="" disabled selected>-- Select Companyy--</option>
                        <option value="direksi">Direksi</option>
                        <option value="pimpinan">Pimpinan</option>
                        @foreach($data as $d)
                        <option value="{{ $d->id }}">{{ $d->induk }} | {{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                      <label for="role" style="font-weight: bold; font-size: 1rem;">Select Role:</label>
                      <select id="role" name="role" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                        <option value="" disabled selected>-- Select Role --</option>
                        <option value="direksi">Direksi</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                      </select> 
                    </div>
                    
                    
                    <div class="form-outline mb-4">
                      <label class="form-label" for="form3Example1cg">Your Name</label>
                      <input type="text" name="name" id="form3Example1cg" class="form-control form-control-lg" />
                    </div>
                    
                    <div class="form-outline mb-4">
                      <label class="form-label" for="" autocomplete="off">username</label>
                      <input type="text" id="" name="username" class="form-control form-control-lg" autocomplete="off"/>
                    </div>
                    
                    <div class="form-outline mb-4">
                      
                      <label class="form-label" for="" autocomplete="off">Password</label>
                      <input type="password" id="" name="password" class="form-control form-control-lg" autocomplete="off"/>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    <div class="d-flex justify-content-center">
                      <button type="submit"
                      class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                    </div>
                    
                    <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="/login"
                    class="fw-bold text-body"><u>Login here</u></a></p>
                    
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
  </body>
  </html>
  
  