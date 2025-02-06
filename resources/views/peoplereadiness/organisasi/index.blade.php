@extends('template.main')
@extends('components.style')

@section('title', 'Organisational Structure')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Organisational Structure</h2>
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

                
        
                <div class="row">
                    <div class="col-sm-">
                        <a href="/formbagan" class="btn btn-custom">Add</a>
                    </div>    
                </div> 
                

                <body style="font-family: 'Arial', sans-serif; background-color: #f9f9f9; width: auto; height: auto; object-fit: cover;">
                    <div class="card mb-3 text-center border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; margin: 2rem auto;">
                        <div style="position: relative;">
                            
                            <img src="{{ asset('storage/' . $gambar->path) }}"  class="card-img-top" alt="Administrasi" style="width: auto; height: auto; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
                
                
                
                
                
                

            </div>
        </div>
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
