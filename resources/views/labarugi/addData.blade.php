@extends('template.main')
@section('title', 'Profit & Loss')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/labarugi" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">ADD Profit & Loss</h3>
                </a>


{{-- Success Notification --}}
@if (session('success'))
<div id="notif-success" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
    {{ session('success') }}
</div>
@endif

{{-- Error Notification --}}
@if ($errors->any())
<div id="notif-error" style="
                position: fixed;
                top: 60px; /* Biar nggak nabrak success */
                right: 20px;
                background-color: #dc3545;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{{-- Script untuk menghilangkan notifikasi --}}
<script>
    setTimeout(function() {
        let notifSuccess = document.getElementById("notif-success");
        let notifError = document.getElementById("notif-error");

        if (notifSuccess) {
            notifSuccess.style.opacity = '0';
            setTimeout(() => notifSuccess.remove(), 500);
        }

        if (notifError) {
            notifError.style.opacity = '0';
            setTimeout(() => notifError.remove(), 500);
        }
    }, 3000);
</script>


                <form action="{{ route('createlabarugi') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="sub_id" class="form-control select2" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($sub as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->namecategory }} | {{ $kategori->namesub }}</option>
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

                    <div class="form-group" id="file" style="display: none;">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file" min="">
                    </div>

                    <div id="actualInput" style="display: none;" class="form-group">
                        <label for="actual">Nominal Actual</label>
                        <input type="text" class="form-control" id="actual" name="nominalactual">
                    </div>

                    <!-- Buttons for Plan and Actual -->
                    <div class="d-flex justify-content-end mt-3">
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
        document.getElementById('planInput').style.display = 'block';
        document.getElementById('file').style.display = 'block';
        document.getElementById('actualInput').style.display = 'none';
    });

    document.getElementById('actualBtn').addEventListener('click', function() {
        document.getElementById('actualInput').style.display = 'block';
        document.getElementById('planInput').style.display = 'none';
        document.getElementById('file').style.display = 'none';

    });



</script>
@endsection