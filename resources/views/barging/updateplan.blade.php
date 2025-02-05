@extends('template.main')

@section('title', 'Barging')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Barging</h2>
                
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

                    
                        <form action="{{ route('updatedataplan',$data->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="updeted_by_name" value="{{ Auth::user()->username }}">

                            <div class="form-group">
                                <label for="tanggal">Tanggal Data</label>
                                <input type="date" class="form-control" value="{{$data->tanggal}}" id="tanggal" name="tanggal" required>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label for="kuota" style="font-weight: bold; font-size: 1rem;">Pilih Kategori:</label>
                                <select id="kuota" name="kuota" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="Ekspor">Ekspor</option>
                                    <option value="Domestik">Domestik</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Plan</label>
                                <input type="number" class="form-control" value="{{$data->nominal}}" id="tanggal" name="nominal" value=""  required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">File</label>
                                <input type="file" class="form-control" value="{{$data->file}}" id="tanggal" name="file" value=""  required>
                                @php
                                $fileExtension = $d->file_extension ?? 'unknown';
                                @endphp
                                <a href="{{ asset('storage/' . $data->file) }}" class="text-decoration-none" target="_blank">View File</a>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            @endsection
            
            @section('scripts')
            @endsection
            