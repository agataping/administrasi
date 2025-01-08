@extends('template.main')
@section('title', '')
@section('content')
@extends('components.style')

<div class="container-fluid mt-4">
    <div class="card w-100 d-flex align-items-center justify-content-center">
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
                
                <div class="cardcostum">
                    <div class="cardcost">
                        <a href="/dashboard" class="cardcost text-decoration-none">
                            
                            <h4><b>Kontraktor</b></h4>                        
                            <div class="percentage-box" >
                                98%
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
