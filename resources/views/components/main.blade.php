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
            <h5 style="color: white; margin: 0;"><span style="font-size: 10px;">KEY PERFORMANCE INDICATOR</span><br>QUBAH GROUP</h5>
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


</header>

<body>
    <div class="background-full" style="background:  url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
    </div>
    <div class="card mb-3 " style="border-radius: 12px;  margin: 2rem auto; height:80vh; background-color: transparent ">

        <div class="card-img-overlay d-flex align-items-center justify-content-center" style="text-align: center; background-color: transparent !important;">
            <div>
                <div style="position: relative;" style="width: auto; height: auto; object-fit: cover; background-color: transparent">

                    <div class="cardcostum">
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