@extends('template.main')

@section('title', 'HSE ')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexhse" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">UPDATE DATA HSE</h3>
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

                <form action="{{ route('updatehse', $hse->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($kategori as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $hse->kategori_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date</label>
                        <input
                            type="date"
                            id="tanggal"
                            name="date"
                            value="{{$hse->date}}"
                            style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                    </div>




                    <div class="form-group">
                        <label for="keterangan">Description</label>
                        <input type="text" class="form-control" value="{{ $hse->keterangan }}" id="keterangan" name="keterangan">
                    </div>
                    <div class="form-group">
                        <label for="nameindikator">Plan</label>
                        <input type="text" class="form-control" id="nameindikator" name="plan" value="{{ $hse->plan }}">
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Actual</label>
                        <input type="text" class="form-control" id="nameindikator" name="actual" value="{{ $hse->actual }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">File</label>
                        <input type="file" class="form-control" value="{{$hse->file}}" id="tanggal" name="file" value="">
                        @php
                        $fileExtension = $d->file_extension ?? 'unknown';
                        @endphp
                        <a href="{{ asset('storage/' . $hse->file) }}" class="text-decoration-none" target="_blank">View File</a>
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

@endsection

@section('scripts')
@endsection