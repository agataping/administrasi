@extends('template.main')
@section('title', 'Unit')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Unit</h2>
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
                <form action="{{ route('createperusahaan') }}" method="post">
                @csrf
                <div id="">
                    <div class="row g-3">
                        <div class="col-sm-2">
                            <label for="" class="form-label">Induk Perusahaan</label>
                            <input type="text" class="form-control" id="" placeholder="" value="" required name="induk">
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="form-label">Anak Perusahaan</label>
                            <input type="text" class="form-control" id="" placeholder="" value="" required name="nama">
                        </div>

                    </div>
                </div>
                <!-- <button type="button" class="btn btn-primary" onclick="tambahInput()">Tambah</button> -->
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
