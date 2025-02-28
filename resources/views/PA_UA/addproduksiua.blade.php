@extends('template.main')
@section('title', 'UA')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexproduksiua" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data UA</h3>
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
                <form action="{{ route('createproduksiua') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control select2" required>
                            <option value="" disabled selected>Pilih Unit</option>
                            @foreach($unit as $u)
                            <option value="{{ $u->id }}">{{ $u->unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date:</label>
                        <input type="date" id="tanggal" name="date" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Description </label>
                        <input type="text" class="form-control" id="nameindikator" name="desc" required>
                    </div>

                    <!-- Nominal Inputs -->
                    <div id="planInput" class="form-group">
                        <label for="plan">Nominal Plan</label>
                        <input type="text" class="form-control" id="plan" name="plan">
                    </div>
                    <div id="planInput" class="form-group">
                        <label for="plan">File</label>
                        <input type="file" class="form-control" id="plan" name="file">
                    </div>
                    <div id="planInput" class="form-group">
                        <label for="plan">Nominal Actual</label>
                        <input type="text" class="form-control" id="plan" name="actual">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" name="action" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                        <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection