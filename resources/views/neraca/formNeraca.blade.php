@extends('template.main')

@section('title', 'neraca')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">neraca</h2>
                
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

                    
                        <form action="{{ route('createneraca') }}" method="post">
                            @csrf
                            <div id="Neraca-container">
                                <div class="subcategory-input">
                                    <label for="category_id">Kategori</label>
                                    <select name="Neraca[0][category_id]" required>
                                        @foreach($kat as $c)
                                        <option value="{{ $c->id}}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    
                                    <div class="form-group">
                                        <label for="name">Nama Subkategori</label>
                                        <input type="text" name="Neraca[0][description]" required>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="number" name="Neraca[0][nominal]" required>
                                        
                                    </div>
                                    
                                    <!-- <button type="button" id="add-subcategory">Tambah Subkategori</button> -->
                                    
                                    
                                    <div class="d-flex justify-content-end mt-3">
                        
                        
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                    </div>
                </form>
            </div>
            </div>

    </div>
</div>

@endsection

@section('script')
@endsection

@section('scripts')
@endsection