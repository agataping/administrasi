@extends('template.main')
@section('title', 'Description ')
@section('content')
@extends('components.style')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/labarugi" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Description </h3>
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

                <form action="{{ route('updatecategorylr',$data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Caregory:</label>
                        <select id="kategori" name="jenis_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Caregory --</option>
                            @foreach($kat as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $data->jenis_id ? 'selected' : '' }}>
                                {{ $kategori->namecategory }} {{ $kategori->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori[]" class="form-label">Description</label>
                            <input type="text" class="form-control" id="kategori" placeholder="" value="{{ $data->namecategory }}" required name="namecategory">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn-block btn-lg gradient-custom-4"
                            style=" background-color: rgb(0, 255, 42); color: white; border: none;padding: 10px 20px;font-size: 16px;cursor: pointer; 
                            border-radius: 5px; font-weight: bold;"">Update</button>
                    </div>
                </form>
                    
                    
                
            </div>
        </div>
    </div>
</div>
        
        
        
        
    
    
    
        
        
        







@endsection
@section('scripts')

@endsection