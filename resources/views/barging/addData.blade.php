@extends('template.main')
@section('title', 'AddDataBarging')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexmenu" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3"> add data Barging</h3>
                </a>

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('errors'))
                <div class="alert alert-success">
                    {{ session('errors') }}
                </div>
                @endif


                <form action="{{ route('createbarging') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="tanggal">Data Date</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="kuota" style="font-weight: bold; font-size: 1rem;">Select category:</label>
                        <select id="kuota" name="kuota" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select category --</option>
                            <option value="Ekspor">Ekspor</option>
                            <option value="Domestik">Domestik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Laycan</label>
                        <input type="text" class="form-control" id="nomor" name="laycan" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">File</label>
                        <input type="file" class="form-control" id="file" name="file" value="">
                    </div>
                    <div class="form-group">
                        <label for="description">Name Of Barge</label>
                        <input type="text" class="form-control" id="description" name="namebarge" required>
                    </div>

                    <div class="form-group">
                        <label for="nomor_legalitas">Surveyor</label>
                        <input type="text" class="form-control" id="nomor_legalitas" name="surveyor" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Port Loading</label>
                        <input type="text" class="form-control" id="Status" name="portloading" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berlaku">Port Of Discharging</label>
                        <input type="text" class="form-control" id="" name="portdishcharging" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berlaku">Shipper</label>
                        <input type="text" class="form-control" id="" name="notifyaddres" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berlaku">Initial Survey</label>
                        <input type="date" class="form-control" id="" name="initialsurvei" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berlaku">Final Survey</label>
                        <input type="date" class="form-control" id="" name="finalsurvey" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berlaku">Quantity</label>
                        <input type="text" class="form-control" id="" name="quantity" required>
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
    <style>
        .button {
            background-color: rgb(0, 255, 42);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }

        .button:hover {
            background-color: rgb(0, 200, 35);
        }
    </style>