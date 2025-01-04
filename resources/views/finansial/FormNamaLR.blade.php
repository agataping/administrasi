@extends('template.main')
@section('title', 'People Readiness')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">DESKRIPSI LABA RUGI</h2>
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
                @if($form_type == 'kategori')
                <form action="{{ route('createDeskripsi') }}" method="post">
                @csrf
                <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                <div id="input-kategori" >
                    <div class="kategori">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <label for="DescriptionName" class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="DescriptionName" placeholder="" required id="DescriptionName">
                            </div>
                        </div>                        <div class="form-group" id="subkategori-container">


                        <div class="row g-3">
                            <div class="col-sm-4">
                                <label for="DescriptionName" class="form-label">Sub Kategori</label>
                                <input type="text" class="form-control" name="sub[]" placeholder="" >
                            </div>
                        </div>



                            <button type="button" class="btn btn-secondary btn-sm" id="addSubkategori">Tambah Subkategori</button>
                            </div>
                        </div>

                        <!-- Input Sub Kategori akan ditambahkan di sini -->
                    </div>
                </div>       
                @endif



                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                </div>
                
                </form>


                @if($form_type == 'subkategori')
                <form method="POST" action="{{ route('addSubkategori') }}">
                    @csrf
                    <div class="form-group">
                        <label for="kategori_id">Pilih Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            @foreach($data as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->DescriptionName }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="subkategori_name">Nama Subkategori</label>
                        <input type="text" name="subkategori_name" id="subkategori_name" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Tambah Subkategori</button>
                </form>
                
            </div>
            
            @endif
        </div>      
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
