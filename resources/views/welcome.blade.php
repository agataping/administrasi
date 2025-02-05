@extends('components.header')
@section('title', 'ADMINISTRATION')

<header class="container-fluid d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" style="background: rgba(7, 164, 59, 0.8);">
    <a href="/" class="d-flex align-items-center text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>
        <div class="text-center">
            <h5 style="color: white; margin: 0;">ADMINISTRATION</h5>
        </div>
    </a>
</header>

<body style="font-family: 'Arial', sans-serif; background-color: rgba(116, 199, 101, 0.06); min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">

    <div class="d-flex justify-content-center w-100">
        <div class="card text-center border-0 shadow-lg p-3" style="border-radius: 16px; max-width: 450px; background: white;">
            <div style="position: relative;">
                <img src="{{ asset('storage/gambar/qubahGroup.jpeg') }}" class="card-img-top img-fluid" alt="Administrasi" style="border-radius: 12px; object-fit: cover;">
            </div>
            <div class="card-body">
                <h5 class="card-title text-success fw-bold">Welcome to Administration Qubah Group</h5>
                <p class="card-text text-muted">Manage everything efficiently with our system.</p>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-center mt-3">
        <a href="/login" class="btn btn-lg text-white shadow-lg border-0 " style="background-color: #07a43b; padding: 0.75rem 2rem; border-radius: 30px;">
            Login
        </a>
    </div>

</body>
<style>
    @media (max-width: 768px) {
    .card {
        max-width: 100%;
        padding: 1rem;
    }

    .btn {
        padding: 0.5rem 1.5rem;
    }
}

</style>