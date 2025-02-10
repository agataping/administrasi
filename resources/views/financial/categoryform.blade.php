@extends('template.main')
@section('title', 'Deskripsi ')
@section('content')
@extends('components.style')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <a href="/indexfinancial" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Add Data Description Balance sheet</h2>
                </a>                 
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
                            <input type="text" class="form-control" id="kategori" placeholder="e.g.Fix Assets, Current Assets Etc." value="" required name="namecategory">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" name="action" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                        <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
                    </div>
                    
                </form>
                    
                    
                
            </div>
        </div>
    </div>
</div>
        
        
        
        
    
    
    
        
        
        







@endsection
@section('scripts')

@endsection
