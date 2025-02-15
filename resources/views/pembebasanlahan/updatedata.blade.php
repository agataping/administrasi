@extends('template.main')

@section('title', 'Update Land Acquissition')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
            <a href="/indexPembebasanLahan" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Update Data Land Acquissition</h2>
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

                <form action="{{ route('updatePembebasanLahan', $pembebasanLahan->id) }}" method="post">
                    @csrf

                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
<label for="nomor"> Data Date</label>                                 <input type="text" class="form-control" id="tanggal" name="tanggal"  value="{{ $data->tanggal }}" required>
                            </div>
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
                                               <button type="submit" class="btn-block btn-lg gradient-custom-4"
                        style=" background-color: rgb(0, 255, 42); color: white; border: none;padding: 10px 20px;font-size: 16px;cursor: pointer; 
                            border-radius: 5px; font-weight: bold;"">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection
