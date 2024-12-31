@extends('template.main')
@section('title', 'Kategori Mining Readiness')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Kategori Mining ReadinesI</h2>
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
                <form action="{{ route('createKatgori') }}" method="post">
                @csrf
                <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                <div id="kategori">
                    <div class="row g-3">
                        <div class="col-sm-2">
                            <label for="kategori[]" class="form-label">Katgori Mining</label>
                            <input type="text" class="form-control" id="kategori" placeholder="" value="" required name="kategori[]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="tambahInputKategori()">Tambah</button>
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
