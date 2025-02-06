@extends('template.main')

@section('title', 'Update Deadline Compensation')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3"></h2>
                <a href="/indexdeadline" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Update Deadline Compensation</h2>
                </a>
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
                <form action="{{ route('updatedeadline', $deadline->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                                <label for="nomor">Date Data</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal"  value="{{ $data->tanggal }}" required>
                            </div>
                    <div class="form-group">
                        <label for="nomor">Description</label>
                        <input type="text" class="form-control" id="nomor" name="Keterangan" value="{{ $deadline->Keterangan }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Lease period</label>
                        <input type="text" class="form-control" id="description" name="MasaSewa" value="{{ $deadline->MasaSewa }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nomor_legalitas">Lease Amount</label>
                        <input type="text" class="form-control" id="nomor_legalitas" name="Nominalsewa" value="{{ $deadline->Nominalsewa }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="Status">Progress </label>
                        <input type="text" class="form-control" id="Status" name="ProgresTahun" value="{{ $deadline->ProgresTahun }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_berlaku">Due Date</label>
                        <input type="text" class="form-control" id="tanggal_berlaku" name="JatuhTempo" value="{{ $deadline->JatuhTempo }}" required>
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