@extends('template.main')
@section('title', 'Deskripsi Neraca')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Deskripsi </h2>
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
                <form action="{{ route('createsubneraca') }}" method="post">
                @csrf
                <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Pilih Kategori:</label>
                        <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($kat as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->namecategory }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="kategori" placeholder="" value="" required name="namesub">
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
