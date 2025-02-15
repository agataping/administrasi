@extends('template.main')

@section('title', 'Profit & Loss')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
            <a href="/labarugi" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Detail Profit & Loss</h2>
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

                <form action="{{ route('updatelabarugi',$data->id) }}" method="post" enctype="multipart/form-data"
                >
                @csrf
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="sub_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            
                            @foreach($sub as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $data->sub_id ? 'selected' : '' }}> 
                                {{ $kategori->namecategory }} | {{ $kategori->namesub }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Tanggal:</label>
                        <input type="date" class="form-control" value="{{$data->tanggal }}"id="tanggal" name="tanggal" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Description </label>
                        <input type="text" class="form-control" value="{{$data->desc }}"id="nameindikator" name="desc" required>
                    </div>

                    <!-- Nominal Inputs -->
                    <div id="planInput" style="display: none;" class="form-group">
                        <label for="plan">Nominal Plan</label>
                        <input type="text" class="form-control" value="{{$data->nominalplan }}"id="plan" name="nominalplan">
                    </div>

                    <div class="form-group" id="file" style="display: none;">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file" min=""  value="{{$data->file}}">
                        @php
                        $fileExtension = $data->file_extension ?? 'unknown';
                        @endphp
                        <a href="{{ asset('storage/' . $data->file) }}" class="text-decoration-none" target="_blank">View File</a>
                        
                    </div>

                    <div id="actualInput" style="display: none;" class="form-group">
                        <label for="actual">Nominal Actual</label>
                        <input type="text" class="form-control" value="{{$data->nominalactual }}"id="actual" name="nominalactual">
                    </div>

                    <!-- Buttons for Plan and Actual -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="planBtn" class="btn btn-custom">Add Plan</button>
                        <button type="button" id="actualBtn" class="btn btn-custom ml-2">Add Actual</button>
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
<script>
    document.getElementById('planBtn').addEventListener('click', function() {
        // Tampilkan Plan, sembunyikan Actual
        document.getElementById('planInput').style.display = 'block';
        document.getElementById('file').style.display = 'block';

        document.getElementById('actualInput').style.display = 'none';

        // Menambahkan class aktif pada tombol
        document.getElementById('planBtn').classList.add('active');
        document.getElementById('actualBtn').classList.remove('active');
    });

    document.getElementById('actualBtn').addEventListener('click', function() {
        // Tampilkan Actual, sembunyikan Plan
        document.getElementById('actualInput').style.display = 'block';
        document.getElementById('planInput').style.display = 'none';
        document.getElementById('file').style.display = 'none';


        // Menambahkan class aktif pada tombol
        document.getElementById('actualBtn').classList.add('active');
        document.getElementById('planBtn').classList.remove('active');
    });

    // Menentukan input mana yang pertama kali tampil berdasarkan kondisi nilai
    window.onload = function() {
        const planValue = "{{ $data->nominalplan }}";  // Nilai nominal plan
        const actualValue = "{{ $data->nominalactual }}";  // Nilai nominal actual
        const fileValue = "{{ $data->file}}"; // file

        if (planValue && !actualValue && !fileValue) {
            document.getElementById('planBtn').click();  
        } else if (planValue && fileValue && !actualValue) {
            document.getElementById('planFileBtn').click();  
        } else if (actualValue) {
            document.getElementById('actualBtn').click();  
        }

    };
</script>
@endsection
