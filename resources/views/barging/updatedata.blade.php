@extends('template.main')
@section('title', 'UpdateDataBarging')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexmenu" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">update data Barging</h3>
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


                <form action="{{ route('updatedatabarging', $data->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <div class="form-group">
                        <label for="tanggal_berlaku">Date Date</label>
                        <input type="date" class="form-control" value="{{$data->tanggal}}" id="" name="tanggal" required>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="kuota" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kuota" name="kuota" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            <option value="Ekspor">Ekspor</option>
                            <option value="Domestik">Domestik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Laycan</label>
                        <input type="text" class="form-control" value="{{$data->laycan}}" id="nomor" name="laycan" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">File</label>
                        <input type="file" class="form-control" value="{{$data->file}}" id="tanggal" name="file" value="">
                        @php
                        $fileExtension = $d->file_extension ?? 'unknown';
                        @endphp
                        <a href="{{ asset('storage/' . $data->file) }}" class="text-decoration-none" target="_blank">View File</a>
                    </div>
                    <div class="form-group">
                        <label for="description">Name Of Barge</label>
                        <input type="text" class="form-control" value="{{$data->namebarge}}" id="description" name="namebarge" required>
                    </div>

                    <div class="form-group">
                        <label for="nomor_legalitas">Surveyor</label>
                        <input type="text" class="form-control" value="{{$data->surveyor}}" id="nomor_legalitas" name="surveyor" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Port Loading</label>
                        <input type="text" class="form-control" value="{{$data->portloading}}" id="Status" name="portloading" required>
                    </div>


                    <div class="form-group">
                        <label for="tanggal_berlaku">Port Of Discharging</label>
                        <input type="text" class="form-control" value="{{$data->portdishcharging}}" id="" name="portdishcharging" required>
                    </div>


                    <div class="form-group">
                        <label for="tanggal_berlaku">Shipper</label>
                        <input type="text" class="form-control" value="{{$data->notifyaddres}}" id="" name="notifyaddres" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berlaku">Initial Survey</label>
                        <input type="date" class="form-control" value="{{$data->initialsurvei}}" id="" name="initialsurvei" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berlaku">Final Survey</label>
                        <input type="date" class="form-control" value="{{$data->finalsurvey}}" id="" name="finalsurvey" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berlaku">Quantity</label>
                        <input type="text" class="form-control" value="{{$data->quantity}}" id="" name="quantity" required>
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

@endsection

@section('scripts')
@endsection