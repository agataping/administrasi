@extends('template.main')

@section('title', 'Update Deadline Compensation')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Update Deadline Compensation</h2>

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
                <form action="{{ route('updatedeadlineCs', $data->id) }}" method="post">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nomor">Keterangan</label>
                        <input type="text" class="form-control" id="nomor" name="Keterangan" value="{{ $data->Keterangan }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Masa Sewa</label>
                        <input type="text" class="form-control" id="description" name="MasaSewa" value="{{ $data->MasaSewa }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nomor_legalitas">Nominal sewa</label>
                        <input type="text" class="form-control" id="nomor_legalitas" name="Nominalsewa" value="{{ $data->Nominalsewa }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="Status">Progres Tahun</label>
                        <input type="text" class="form-control" id="Status" name="ProgresTahun" value="{{ $data->ProgresTahun }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_berlaku">Jatuh Tempo</label>
                        <input type="text" class="form-control" id="tanggal_berlaku" name="JatuhTempo" value="{{ $data->JatuhTempo }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                </form>
                
                
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection