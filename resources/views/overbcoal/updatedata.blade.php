@extends('template.main')

@section('title', 'Over Burden & Coal')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Over Burden & Coal</h2>
                
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

                <form action="{{ route('updateovercoal',$data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">


                    <input type="hidden" name="updeted_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($kat as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $data->kategori_id ? 'selected' : '' }}> 
                                {{ $kategori->name }} </option>

                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date:</label>
                        <input type="date" class="form-control" value="{{$data->tanggal}}" id="tanggal" name="tanggal" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div class="form-group">
                        <label for="nameindikator">Description </label>
                        <input type="text" class="form-control" value="{{$data->desc}}" id="nameindikator" name="desc" required>
                    </div>

                    <!-- Nominal Inputs -->
                    <div id="planInput" style="display: none;" class="form-group">
                        <label for="plan">Nominal Plan</label>
                        <input type="text" class="form-control" value="{{$data->nominalplan}}" id="plan" name="nominalplan">
                    </div>

                    <div id="actualInput" style="display: none;" class="form-group">
                        <label for="actual">Nominal Actual</label>
                        <input type="text" class="form-control" value="{{$data->nominalactual}}" id="actual" name="nominalactual">
                    </div>

                    <!-- Buttons for Plan and Actual -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="planBtn" class="btn btn-custom" >Add Plan</button>
                        <button type="button" id="actualBtn" class="btn btn-custom ml-2" >Add Actual</button>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">
                            Update</button>
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
        document.getElementById('actualInput').style.display = 'none';

        // Menambahkan class aktif pada tombol
        document.getElementById('planBtn').classList.add('active');
        document.getElementById('actualBtn').classList.remove('active');
    });

    document.getElementById('actualBtn').addEventListener('click', function() {
        // Tampilkan Actual, sembunyikan Plan
        document.getElementById('actualInput').style.display = 'block';
        document.getElementById('planInput').style.display = 'none';

        // Menambahkan class aktif pada tombol
        document.getElementById('actualBtn').classList.add('active');
        document.getElementById('planBtn').classList.remove('active');
    });

    // Menentukan input mana yang pertama kali tampil berdasarkan kondisi nilai
    window.onload = function() {
        const planValue = "{{ $data->nominalplan }}";  // Nilai nominal plan
        const actualValue = "{{ $data->nominalactual }}";  // Nilai nominal actual
        
        if(planValue && !actualValue) {
            document.getElementById('planBtn').click();  // Jika hanya Plan yang ada, tampilkan Plan
        } else if(actualValue) {
            document.getElementById('actualBtn').click();  // Jika Actual ada, tampilkan Actual
        }
    };
</script>
@endsection
