@extends('template.main')

@section('title', 'Update Deadline Compensation')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexdeadline" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Update Deadline Compensation</h3>
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

                <form action="{{ route('updatedeadline', $deadline->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nomor">Date Data</label>
                        <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
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