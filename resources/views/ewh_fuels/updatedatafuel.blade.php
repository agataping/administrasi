@extends('template.main')
@section('title', 'update_ua')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexfuel" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">UPDATE DATA FUEL</h3>
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
                <form action="{{ route('updatefuel',$data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control select2" required>
                            <option value="" disabled selected>Select Unit</option>
                            @foreach($unit as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $data->code_number ? 'selected' : '' }}>
                                {{ $kategori->unit }}
                            </option>

                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date:</label>
                        <input type="date" class="form-control" value="{{$data->date}}" id="tanggal" name="date" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Description </label>
                        <input type="text" class="form-control" value="{{$data->desc}}" id="nameindikator" name="desc" required>
                    </div>

                    <!-- Nominal Inputs -->
                    <div id="planInput" class="form-group">
                        <label for="plan">Nominal Plan</label>
                        <input type="text" class="form-control" value="{{$data->plan}}" id="plan" name="plan">
                    </div>
                    <div class="form-group" id="file" style="display: none;">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file" min="" value="{{$data->file}}">
                        @php
                        $fileExtension = $data->file_extension ?? 'unknown';
                        @endphp
                        <a href="{{ asset('storage/' . $data->file) }}" class="text-decoration-none" target="_blank">View File</a>

                    </div>
                    <div id="planInput" class="form-group">
                        <label for="plan">Nominal Plan</label>
                        <input type="text" class="form-control" value="{{$data->actual}}" id="plan" name="actual">
                    </div>

                    <!-- Submit Button -->
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