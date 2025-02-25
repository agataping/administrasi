@extends('template.mainmenu')
@section('title', '')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>

<div class="card mb-3" style="background:  no-repeat center center/cover; border-radius: 12px; overflow: hidden; margin: 2rem auto; height: 80vh;">
    <div class="card-img-overlay d-flex align-items-center justify-content-center" style="background: color: white; text-align: center; ">
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
                
                <div style="position: relative; width: auto; height: auto; object-fit: cover;">
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
                    
                    <div >
                        @if(auth()->user()->role === 'staff')
                        <div class="grid-container  justify-content-center">
                            
                            @foreach($data as $item)
                            <div class="grid-item">
                                <div class="cardcostum">
                                    <div class="cardcost">
                                        @if($item->id == auth()->user()->id_company)
                                        <a href="/reportkpi" class="cardcost text-decoration-none">
                                            @else
                                            <a class="cardcost text-decoration-none disabled-link">
                                                @endif
                                                <h4><b>{{ $loop->iteration }}. {{ $item->nama }}</b></h4>
                                                <div class="percentage-box">98%</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            @elseif(auth()->user()->role === 'admin')    
                            @foreach($data as $item)
                            <div class="grid-item">
                                <div class="cardcostum">
                                    <div class="cardcost">
                                        <a href="/reportkpi" class="cardcost text-decoration-none">
                                            <h4><b>
                                                <h4><b>{{ $loop->iteration }}. {{ $item->nama }}</b></h4>
                                                
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
        
