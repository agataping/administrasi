@extends('template.mainmenu')
@section('title', '')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
<div class="card mb-3 "  style="border-radius: 12px; overflow: hidden; margin: 2rem auto; height:80vh; ">
    <img src="{{asset('storage/gambar/abcd.png')}}"  alt="Administrasi" style="width: auto; height: auto; object-fit: cover;">
    <div class="card-img-overlay d-flex align-items-center justify-content-center" style="background: color: white; text-align: center; ">
                <div>
        <div class="card-body">
            <div class="col-12">
                
                <h2 class="mb-3"></h2>
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
                <div style="position: relative;" style="width: auto; height: auto; object-fit: cover;">

                <div class="cardcostum">
                    <div class="cardcost">
                        <a href="/dashboard" class="cardcost text-decoration-none">
                            
                            <h3><b>NON ENERGI</b></h3>                        
                            <div class="percentage-box" >
                                <h3>
                                    98%

                                </h3>
                            </div>
                        </div>
                    </div>
                    @foreach($data as $item)
                    <div class="d-flex justify-content-center gap-3">
                        
                        <div class="cardcostum">
                            <div class="cardcost">
                                <a href="/dummy" class="cardcost text-decoration-none">
                                    <h4><b>{{ $loop->iteration }}. {{ $item->nama}}</b></h4>
                                    <div class="percentage-box" >
                                        98%
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            </div>
        
        
                                                 
 @endsection
                                
@section('scripts')

@endsection
