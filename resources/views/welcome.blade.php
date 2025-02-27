@extends('components.header')
@section('title', 'KPI')
<link href="{{asset('css/signin.css')}}" rel="stylesheet">


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; font-family: 'Arial', sans-serif; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="d-flex justify-content-center position-relative" style="width: 100%;">
        
        <!-- Gambar Latar -->
        
        <!-- Form Login di Tengah Gambar -->
        <div class="position-absolute top-50 start-50 translate-middle p-4 rounded shadow"
     style="width: 400px; background-color: rgba(122, 129, 122, 0.79);">

            <h4 class="text-center" style="color:white;"><strong>WELCOME TO <br> QUBAH GROUP</strong></h4>
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