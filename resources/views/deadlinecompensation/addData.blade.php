@extends('template.main')

@section('title', 'Deadline Compensation')
@extends('components.style')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexdeadline" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data Deadline Compensation</h3>
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
                <form action="{{ route('createdeadline') }}" method="post">

                    @csrf

                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="nomor">Date Data</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Description</label>
                        <input type="text" class="form-control" id="nomor" name="Keterangan" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Lease period</label>
                        <input type="text" class="form-control" id="description" name="MasaSewa" required>
                    </div>

                    <div class="form-group">
                        <label for="nomor_legalitas">Lease Amount</label>
                        <input type="text" class="form-control" id="nomor_legalitas" name="Nominalsewa" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Progress</label>
                        <input type="text" class="form-control" id="Status" name="ProgresTahun" required>
                    </div>


                    <div class="form-group">
                        <label for="tanggal_berlaku">Due Date</label>
                        <input type="text" class="form-control" id="tanggal_berlaku" name="JatuhTempo" required>
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
@endsection