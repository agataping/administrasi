@extends('components.header')
@section('title', 'ADMINISTRATION')

<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" style="background: rgba(7, 164, 59, 0.8);">
    <a href="/" class="d-flex align-items-center text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>
        <div class="text-center">
            <h5 style="color: white; margin: 0;">ADMINISTRATION</h5>
        </div>
    </a>
</header>

<body style="font-family: 'Arial', sans-serif; background-color:rgb(255, 246, 246); width: auto; height: auto; object-fit: cover;">
    <div class="card mb-3 text-center border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; margin: 2rem auto;">
        <div style="position: relative;">
            <img src="{{asset('storage/gambar/qubahGroup.jpeg')}}" class="card-img-top" alt="Administrasi" style="width: 400px; height: auto; object-fit: cover;">
            <div class="card-img-overlay d-flex align-items-center justify-content-center" style="background: color: white; text-align: center; ">
                <div>
                    <!-- <h1 class="card-title fw-bold">Selamat Datang</h1>
                    <p class="card-text mb-4" style="font-size: 1.2rem;">
                        Kelola Administrasi dengan Mudah dan Cepat.
                    </p> -->
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center" >

    <a href="/login" class="btn btn-lg text-white" style="background-color: #07a43b; padding: 0.75rem 2rem; border-radius: 30px;">
                        Login
                    </a>
                    </div>

</body>
