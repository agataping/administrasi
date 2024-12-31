@extends('template.main')

@section('title', 'Mining Readines')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Mining Readines</h2>
                
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
                <select id="kategori" name="kategori">
                        @foreach($kategori as $kategori)
                        <option value="{{ $kategori->kategori}}">{{ $kategori->kategori }}</option>

                        @endforeach
                    </select>
                    
                    <div id="form-input" style="display:none;">
                        <form action="{{ route('CreateMining') }}" method="post">
                            @csrf
                            <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                            <input type="hidden" name="KatgoriDescription" value="{{ $kategori->kategori }}">
                                                        
                            <div class="form-group">
                                <label for="nomor">Nomor</label>
                                <input type="text" class="form-control" id="nomor" name="nomor" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="Description" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nomor_legalitas">Nomor Legalitas</label>
                                <input type="text" class="form-control" id="nomor_legalitas" name="NomerLegalitas" >
                            </div>
                            
                            <div class="form-group">
                                <label for="Status">Status</label>
                                <input type="text" class="form-control" id="Status" name="status" >
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="tanggal_berlaku">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal" >
                            </div>

                            <div class="form-group">
                                <label for="tanggal_berlaku"> Berlaku</label>
                                <input type="text" class="form-control" id="BERLAKU" name="berlaku" >
                            </div>

                            <div class="form-group">
                                <label for="filling"> Filling</label>
                                <input type="text" class="form-control" id="filling" name="filling" >
                            </div>
                            
                            <div class="form-group">
                                <label for="achievement">Achievement</label>
                                <input type="text" class="form-control" id="achievement" name="Achievement" required>
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