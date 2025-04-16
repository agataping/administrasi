@extends('template.main')
@extends('components.style')
@section('title', 'Pica Barging')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexpicabarging" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data PICA Barging</h3>
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


                <form action="{{ route('createpicabarging') }}" method="post">
                    @csrf

                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="nomor">Date Data</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Problem</label>
                        <input type="text" class="form-control" id="nomor" name="problem" required>
                    </div>

                    <div class="form-group">
                        <label for="LuasLahan">Cause</label>
                        <input type="text" class="form-control" id="LuasLahan" name="cause" required>
                    </div>

                    <div class="form-group">
                        <label for="KebutuhanLahan">Corective Action</label>
                        <input type="text" class="form-control" id="KebutuhanLahan" name="corectiveaction" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Due Date</label>
                        <input type="text" class="form-control" id="Progress" name="duedate" required>
                    </div>

                    <div class="form-group">
                        <label for="achievement">PIC</label>
                        <input type="text" class="form-control" id="achievement" name="pic" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <input type="text" class="form-control" id="Status" name="status">
                    </div>

                    <div class="form-group">
                        <label for="achievement">Remerks</label>
                        <input type="text" class="form-control" id="achievement" name="remerks" required>
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