@extends('template.main')
@section('title', 'Deskripsi ')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexfinancial" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Update Data Description Balnce sheet</h2>
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

                <form action="{{ route('updatecatneraca',$data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updeted_by_name" value="{{ Auth::user()->username }}">
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" value="{{$data->namecategory}}"id="kategori" placeholder="" value="" required name="namecategory">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Save</button>                    </div>
                </form>
                    
                    
                
            </div>
        </div>
    </div>
</div>
        
        
        
        
    
    
    
        
        
        







@endsection
@section('scripts')

@endsection
