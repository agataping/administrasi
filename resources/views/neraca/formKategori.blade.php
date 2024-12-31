@extends('template.main')

@section('title', 'Kategori Neraca')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Kategori Neraca</h2>
                
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
                <div class="subcategory-input">

                    
                        <form action="{{ route('createkategorineraca') }}" method="post">
                            @csrf
                            

                            <div class="form-group">
                                <label for="tanggal_berlaku">Katgori Neraca</label>
                                <input type="text" class="form-control" id="" name="name" required>
                            </div>
                            <select name="parent_id">
                                <option value="">Pilih Parent</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <label>Level:</label>
                            <input type="text" name="level" readonly>
                            
                    
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