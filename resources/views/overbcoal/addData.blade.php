@extends('template.main')
@section('title', 'Add Data Over Burden & Coal')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
            <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
            <h2 class="mb-3" onclick="window.history.back()" style="cursor: pointer;">Add Data Over Burden & Coal</h2>
                
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

                <form action="{{ route('createovercoal') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <input type="hidden" name="kategori_id" value="{{ old('kategori_id', '2') }}">                    
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
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date:</label>
                        <input type="date" id="tanggal" name="tanggal" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Description </label>
                        <input type="text" class="form-control" id="nameindikator" name="desc" required>
                    </div>

                    <!-- Nominal Inputs -->
                    <div id="planInput" style="display: none;" class="form-group">
                        <label for="plan">Nominal Plan</label>
                        <input type="text" class="form-control" id="plan" name="nominalplan">
                    </div>
                    <!-- File -->
                    <div id="fileInput" style="display: none;" class="form-group">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>


                    <div id="actualInput" style="display: none;" class="form-group">
                        <label for="actual">Nominal Actual</label>
                        <input type="text" class="form-control" id="actual" name="nominalactual">
                    </div>

                    <!-- Buttons for Plan and Actual -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="planBtn" class="btn ">Add Plan</button>
                        <button type="button" id="actualBtn" class="btn ml-2">Add Actual</button>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" name="action" value="add" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                        <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('planBtn').addEventListener('click', function() {
        document.getElementById('planInput').style.display = 'block';
        document.getElementById('fileInput').style.display = 'block';
        document.getElementById('actualInput').style.display = 'none';
    });

    document.getElementById('actualBtn').addEventListener('click', function() {
        document.getElementById('actualInput').style.display = 'block';
        document.getElementById('planInput').style.display = 'none';
        document.getElementById('fileInput').style.display = 'none';
    });
</script>
@endsection
