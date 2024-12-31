@extends('template.main')

@section('title', 'Kategori HPP')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Kategori HPP</h2>
                
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

                    
                        <form action="{{ route('addhpp') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="uraian">Uraian</label>
                                <input type="text" class="form-control" id="uraian" name="uraian" required>
                            </div>

                            
                            <div class="form-group">
                                <label for="tanggal_berlaku">Parent Kategori</label>
                                <select name="parent_id" id="parent_id">
                                    <option value="">None (Root Category)</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ str_repeat('--', $category->level) }} {{ $category->uraian }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            

                            <div class="form-group">
                                <label for="rencana">Rencana</label>
                                <input type="text" class="form-control" id="rencana" name="rencana" >
                            </div>

                            <div class="form-group">
                                <label for="realisasi">Realisasi</label>
                                <input type="text" class="form-control" id="realisasi" name="realisasi" >
                            </div>

                            <div class="form-group">
                                <label for="tahun">tahun</label>
                                <input type="text" class="form-control" id="tahun" name="tahun" >
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

