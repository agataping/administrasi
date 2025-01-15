@extends('template.main')

@section('title', 'InfrastructureReadiness')

@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Update Maening Readiness</h2>
                
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

                <form action="{{ route('UpdateMining', $mining->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">

                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="KatgoriDescription" class="form-control">
                            @foreach($kategori as $kat)
                            <option value="{{ $kat->kategori }}" {{ $kat->kategori == $mining->KatgoriDescription ? 'selected' : '' }}>{{ $kat->kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nomor">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $mining->nomor }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="Description" value="{{ $mining->Description }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nomor_legalitas">Nomor Legalitas</label>
                        <input type="text" class="form-control" id="nomor_legalitas" name="NomerLegalitas" value="{{ $mining->NomerLegalitas }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="Status">Status</label>
                        <input type="text" class="form-control" id="Status" name="status" value="{{ $mining->status }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_berlaku">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal" value="{{ $mining->tanggal }}">
                    </div>

                    <div class="form-group">
                        <label for="berlaku">Berlaku</label>
                        <input type="text" class="form-control" id="berlaku" name="berlaku" value="{{ $mining->berlaku }}">
                    </div>

                    <div class="form-group">
                        <label for="filling">Filling</label>
                        <input type="text" class="form-control" id="filling" name="filling" value="{{ $mining->filling }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="achievement">Achievement</label>
                        <input type="text" class="form-control" id="achievement" name="Achievement" value="{{ $mining->Achievement }}" required>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')

@endsection
