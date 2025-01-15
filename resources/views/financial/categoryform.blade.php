@extends('template.main')
@section('title', 'Deskripsi ')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Deskripsi Neraca</h2>
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

                <form action="{{ route('createcategoryneraca') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="kategori" placeholder="" value="" required name="namecategory">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                    </div>
                </form>
                    
                    
                
            </div>
        </div>
    </div>
</div>
        
        
        
        
    
    
    
        
        
        







@endsection
@section('scripts')

@endsection