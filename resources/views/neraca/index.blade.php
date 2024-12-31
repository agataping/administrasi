@extends('template.main')
@extends('components.style')

@section('title', 'Neraca')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Neraca</h2>
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
                        <a href="/kategorineraca" class="btn btn-custom">Add Kategori Neraca</a>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-">
                        <a href="/neraca" class="btn btn-custom">Add Neraca</a>
                    </div>
                </div> 


                
                
            </div>
        </div>
        
        
        
        
        
    </div>
</div>

        
        
        







@endsection
@section('scripts')

@endsection
