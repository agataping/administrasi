@extends('template.main')

@section('title', 'Deadline Compensation')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Deadline Compensation</h2>
                
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
                <form action="{{ route('createdeadline') }}" method="post">
                    
                    @csrf
                    
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                                <label for="nomor">Tanggal Data</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                    <div class="form-group">
                        <label for="nomor">Keterangan</label>
                        <input type="text" class="form-control" id="nomor" name="Keterangan" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Masa Sewa</label>
                        <input type="text" class="form-control" id="description" name="MasaSewa" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nomor_legalitas">Nominal sewa</label>
                        <input type="text" class="form-control" id="nomor_legalitas" name="Nominalsewa" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="Status">Progres Tahun</label>
                        <input type="text" class="form-control" id="Status" name="ProgresTahun" required>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="tanggal_berlaku">Jatuh Tempo</label>
                        <input type="text" class="form-control" id="tanggal_berlaku" name="JatuhTempo" required>
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