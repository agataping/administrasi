@extends('template.main')
@section('title', 'Balnce sheet')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexfinancial" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data Detail Balance sheet</h3>
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

                <form action="{{ route('createfinanc') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date</label>
                        <input type="date" id="tanggal" name="tanggal" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="sub_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($sub as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->namecategory }} | {{ $kategori->namesub }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="name" style="font-weight: bold; font-size: 1rem;">Description:</label>
                        <input type="text" id="name" name="name" plhaceholder="e.g. Mandiri, Hauling Etc" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; " required>
                    </div>



                    <div id="debitplan" class="form-group" style="display: none;">
                        <label for="actual">Debit plan</label>
                        <input type="text" class="form-control" id="debitplan" name="debit">
                    </div>

                    <div id="creditplan" class="form-group" style="display: none;">
                        <label for="actual">Credit plan </label>
                        <input type="text" class="form-control" id="creditplan" name="credit">
                    </div>
                    <div id="fileplan" class="form-group" style="display: none;">
                        <label for="actual">File Plan</label>
                        <input type="file" class="form-control" id="creditplan" name="fileplan">
                        
                    </div>
                    <div id="debitactual" class="form-group" style="display: none;">
                        <label for="actual">Debit actual</label>
                        <input type="text" class="form-control" id="debitactual" name="debit_actual">
                    </div>

                    <div id="creditactual" class="form-group" style="display: none;">
                        <label for="actual">Credit actual</label>
                        <input type="text" class="form-control" id="creditactual" name="credit_actual">
                    </div>
                    <div id="fileactual" class="form-group" style="display: none;">
                        <label for="actual">file actual</label>
                        <input type="file" class="form-control" id="creditactual" name="filectual">
                    </div>
                    <div class="d-flex justify-content-end mt-3" style="display: none;">
                        <button type="button" id="planBtn" class="btn">Add Plan</button>
                        <button type="button" id="actualBtn" class="btn ml-2">Add Actual</button>
                    </div>
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
<script>
    document.getElementById('planBtn').addEventListener('click', function() {
        document.getElementById('debitactual').style.display = 'none';
        document.getElementById('creditactual').style.display = 'none';
        document.getElementById('fileactual').style.display = 'none';

        document.getElementById('fileplan').style.display = 'block';
        document.getElementById('debitplan').style.display = 'block';
        document.getElementById('creditplan').style.display = 'block';
    });

    document.getElementById('actualBtn').addEventListener('click', function() {
        document.getElementById('debitactual').style.display = 'block';
        document.getElementById('creditactual').style.display = 'block';
        document.getElementById('fileactual').style.display = 'block';

        document.getElementById('debitplan').style.display = 'none';
        document.getElementById('creditplan').style.display = 'none';
        document.getElementById('fileplan').style.display = 'none';

    });
</script>
@endsection