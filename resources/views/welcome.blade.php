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


    <link href="{{asset('css/signin.css')}}" rel="stylesheet">
    

</header>

<body style="font-family: 'Arial', sans-serif; background-color: rgba(116, 199, 101, 0.06); min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">

<div class="d-flex justify-content-center position-relative" style="width: 100%;">
    <div class="card text-center border-0 shadow-lg p-3 position-relative" style="border-radius: 16px; background: white; width: 1500px;">
        
        <!-- Gambar Latar -->
        <img src="{{ asset('img/alatberat.jpg') }}" class="card-img-top img-fluid" alt="Administrasi" style="border-radius: 12px; width: 100%; height: auto; object-fit: cover;">
        
        <!-- Form Login di Tengah Gambar -->
        <div class="position-absolute top-50 start-50 translate-middle p-4 rounded shadow"
     style="width: 400px; background-color: rgba(122, 129, 122, 0.79);">

            <h3 class="text-center" style="color:white;"><strong>WELCOME TO <br> QUBAH GROUP</strong></h3>
            <form action="{{ url('signin') }}" method="post">
                @csrf
                <div class="mb-3 form-floating">
                <input type="text"  class="form-control" id="floatingInput" name="username" placeholder="Username">
          <label for="floatingInput">Username</label>
                </div>
                <div class="mb-3 form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
          <label for="floatingPassword">Password</label>
                </div>
                <div class="d-flex justify-content-end">
            <button class="w-10 btn btn-primary" type="submit">Sign in</button>
          </div>
            </form>
        </div>
    </div>
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