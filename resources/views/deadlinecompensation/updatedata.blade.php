@extends('template.main')

@section('title', 'Update Deadline Compensation')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
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
                    
                    <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn-block btn-lg gradient-custom-4"
                        style=" background-color: rgb(0, 255, 42); color: white; border: none;padding: 10px 20px;font-size: 16px;cursor: pointer; 
                            border-radius: 5px; font-weight: bold;"">Update</button>                    </div>
                </form>
                
                
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection