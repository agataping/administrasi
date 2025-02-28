@extends('template.main')
@section('title', 'Deskripsi Balnce sheet')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexfinancial" class=" text-decoration-none " style="color: black;">
                    <h2 class="mb-3">Update Data Sub Balnce sheet</h2>
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
                <form action="{{ route('updatesubneraca',$data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($kat as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id ==$data->kategori_id ? 'selected' : '' }}> {{ $kategori->namecategory }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" value="{{$data->namesub}}" id="kategori" placeholder="" value="" required name="namesub">
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