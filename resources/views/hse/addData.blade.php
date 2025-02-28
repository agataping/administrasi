@extends('template.main')
@section('title', 'HSE ')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexhse" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">ADD DATA HSE</h3>
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
                @endifxa

                <form action="{{ route('createhse') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($data as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date</label>

                        <input type="date"
                            id="tanggal"
                            name="date"
                            style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Description </label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Plan</label>
                        <input type="text" class="form-control" id="nameindikator" name="plan">
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Actual</label>
                        <input type="text" class="form-control" id="nameindikator" name="actual">
                    </div>
                    <div class="form-group">
                        <label for="nameindikator">File</label>
                        <input type="file" class="form-control" id="nameindikator" name="file">
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" name="action" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                        <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @endsection

    @section('scripts')
    @endsection