@extends('components.header')
@extends('components.style')
@section('title', 'Dashboard')
@section('content')
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Registrasi</title>
  <link href="{{asset ('style/assets/dist/css/bootstrap.min.css')}}" rel="stylesheet">
</head>


<header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom" style="background-color: transparent; flex-wrap: nowrap;">
  <a href="/dashboard" class="d-flex align-items-center text-decoration-none">
    <div class="d-flex align-items-center ms-3">
      <!-- Logo Bulat -->
      <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center; background-color: white; margin-right: 10px;">
        <img src="{{ asset('img/qubahGroup.jpeg') }}" alt="Logo"
          style="width: 90%; height: 90%; object-fit: contain;">
      </div>

      <!-- Teks -->
      <h5 style="color: white; margin: 0;"><span style="font-size: 10px;">KEY PERFORMANCE INDICATOR</span><br>QUBAH GROUP</h5>
    </div>
  </a>
  <div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
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
      <img src="img/profil.jpg" alt="Profile" width="32" height="32" class="rounded-circle border border-2 border-light">
      <i class="bi bi-chevron-down text-white"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser2" style="min-width: 200px; border-radius: 8px; overflow: hidden;">
      <li class="dropdown-item text-muted px-3">
        <i class="bi bi-person-circle me-2 text-primary"></i>
        {{ Auth::user()->name }}
      </li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li>
        <form action="{{ url('logout') }}" method="POST" id="logout-form">
          @csrf
          <button class="dropdown-item text-danger d-flex align-items-center" style="gap: 0.5rem;" type="submit">
          <i class="fa-solid fa-right-from-bracket"></i> 
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
  <div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
      <div class="card-body">
        <div class="col-12">

          <div class="d-flex align-items-center ms-auto mb-4">
            <div class="col-auto">
              <button class="btn btn-success btn-lg gradient-custom-4 d-flex align-items-center"
                data-bs-toggle="modal" data-bs-target="#addUserModal" style="gap: 0.5rem; margin-right: 16px;">
                <i class="fa-solid fa-user-plus"></i>
                Add User
              </button>
            </div>
          </div>

          <!-- Modal Add User -->
          <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true ">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addUserModalLabel">Create an Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ url('/daftar') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                      <label for="kategori" class="form-label">Select Company:</label>
                      <select id="kategori" name="id_company" class="form-select">
                        <option value="" disabled selected>-- Select Company --</option>
                        <option value="direksi">Direksi</option>
                        <option value="pimpinan">Pimpinan</option>
                        @foreach($data as $d)
                        <option value="{{ $d->id }}">{{ $d->induk }} | {{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="role" class="form-label">Select Role:</label>
                      <select id="role" name="role" class="form-select">
                        <option value="" disabled selected>-- Select Role --</option>
                        <option value="direksi">Direksi</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="name" class="form-label">Your Name</label>
                      <input type="text" name="name" id="name" class="form-control" />
                    </div>

                    <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" id="username" name="username" class="form-control" autocomplete="off" />
                    </div>

                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" id="password" name="password" class="form-control" autocomplete="off" />
                    </div>

                    <div class="d-flex justify-content-end ">
                      <button type="submit" class="btn btn-success">Register</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <!-- table Add User -->
          <div class="table-responsive" style="max-height: 400px; overflow-y:auto; mt-3">
            <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
              <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                <tr>
                  <th rowspan="2" style="vertical-align: middle;">No</th>
                  <th rowspan="2" style="vertical-align: middle;">Name</th>
                  <th rowspan="2" style="vertical-align: middle;">Username</th>
                  <th rowspan="2" style="vertical-align: middle;">Company</th>
                  <th rowspan="2" style="vertical-align: middle;">Last Active</th>
                  <th rowspan="2" colspan="3" style="vertical-align: middle;">Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username }}</td>
                  <td style="padding-right: 8px;">{{ $user->nama }} &nbsp; ({{ $user->induk }}) </td>
                  <td>{{ $user->hari_tidak_aktif }} days ago </td>
                </tr>
                @endforeach

            </table>
          </div>
        </div>
      </div>
    </div>



</body>

</html>