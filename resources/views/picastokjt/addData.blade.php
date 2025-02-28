@extends('template.main')

@section('title', 'Pica Pica Stock JT')
@extends('components.style')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/picastockjt" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data PICA Stock Jetty</h3>
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

                <form action="{{ route('createsjt') }}" method="post">
                    @csrf

                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="nomor">Data Date</label>
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