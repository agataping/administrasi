@extends('template.mainmenu')
@section('title', '')
@section('content')
@extends('components.style')

<div class="container-fluid mt-4">
<div class="card mb-3 "  style="border-radius: 12px; overflow: hidden; margin: 2rem auto; height:80vh; ">
    <img src="{{asset('storage/gambar/abcd.png')}}"  alt="Administrasi" style="width: auto; height: auto; object-fit: cover;">
    <div class="card-img-overlay d-flex align-items-center justify-content-center" style="background: color: white; text-align: center; ">
                <div>


        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3"></h2>

                <!-- Tampilkan pesan sukses -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Tampilkan pesan error -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div style="position: relative; width: auto; height: auto; object-fit: cover;">
                    <!-- Card IUP -->
                    <div class="cardcostum">
                        <div class="cardcost">
                            <a href="/dashboard" class="cardcost text-decoration-none">
                                <h3><b>IUP</b></h3>
                                <div class="percentage-box"><h3>
                                    98%
                                </h3></div>
                            </a>
                        </div>
                    </div>

                    <!-- Grid Container -->
                    <div >
                    @if(auth()->user()->role === 'staff')
                    @foreach($data as $item)
                    <div class="grid-item">
                        <div class="cardcostum">
                            <div class="cardcost">
                                <a href="/reportkpi" class="cardcost text-decoration-none">
                                    <h4><b>{{ $loop->iteration }}. {{ $item->nama }}</b></h4>
                                    
                                    <div class="percentage-box">98%</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @elseif(auth()->user()->role === 'admin')    
                <div class="grid-container  justify-content-center">
                    @foreach($data as $item)
                        <div class="grid-item">
                            <div class="cardcostum">
                                <div class="cardcost">
                                    <a href="/reportkpi" class="cardcost text-decoration-none">
                                        <h4><b>
                                        <h4><b>{{ $loop->iteration }}. {{ $item->nama }}. <br> {{ $item->staff_name }}</b></h4>

                                        </b></h4>
                                        <div class="percentage-box">98%</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection

<style>
</style>
