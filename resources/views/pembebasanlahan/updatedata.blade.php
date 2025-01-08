@extends('template.main')

@section('title', 'Update Pembebasan Lahan')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Update Pembebasan Lahan</h2>
                
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

                <form action="{{ route('updatePembebasanLahan', $pembebasanLahan->id) }}" method="post">
                    @csrf

                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    
                    <div class="form-group">
                        <label for="nomor">Nama Pemilik Lahan</label>
                        <input type="text" class="form-control" id="nomor" name="NamaPemilik" value="{{ $pembebasanLahan->NamaPemilik }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="LuasLahan">Luas Lahan</label>
                        <input type="text" class="form-control" id="LuasLahan" name="LuasLahan" value="{{ $pembebasanLahan->LuasLahan }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="KebutuhanLahan">Kebutuhan Lahan</label>
                        <input type="text" class="form-control" id="KebutuhanLahan" name="KebutuhanLahan" value="{{ $pembebasanLahan->KebutuhanLahan }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="Progress">Progress</label>
                        <input type="text" class="form-control" id="Progress" name="Progress" value="{{ $pembebasanLahan->Progress }}" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <input type="text" class="form-control" id="Status" name="Status" value="{{ $pembebasanLahan->Status }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="achievement">Achievement</label>
                        <input type="text" class="form-control" id="achievement" name="Achievement" value="{{ $pembebasanLahan->Achievement }}" required>
                    </div>

                    <div class="form-group">
                        <label for="targetselesai">Target Selesai</label>
                        <input type="targetselesai" class="form-control" id="achievement" value="{{ $pembebasanLahan->targetselesai }}" name="targetselesai" >
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
