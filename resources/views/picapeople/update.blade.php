@extends('template.main')

@section('title', 'Pica People Readiness')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexpicapeople" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Update Data PICA People Readiness</h3>
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

                <form action="{{ route('updatepicapeople',$data->id) }}" method="post">
                    @csrf

                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="nomor">Data Date</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
                    </div>

                    <div class="form-group">
                        <label for="nomor">Problem</label>
                        <input type="text" class="form-control" id="nomor" name="problem" value="{{ $data->problem }}" required>
                    </div>

                    <div class="form-group">
                        <label for="LuasLahan">Cause</label>
                        <input type="text" class="form-control" id="LuasLahan" name="cause" value="{{ $data->cause }}" required>
                    </div>

                    <div class="form-group">
                        <label for="KebutuhanLahan">Corective Action</label>
                        <input type="text" class="form-control" id="KebutuhanLahan" name="corectiveaction" value="{{ $data->corectiveaction }}" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Due Date</label>
                        <input type="text" class="form-control" id="Progress" name="duedate" value="{{ $data->duedate }}" required>
                    </div>

                    <div class="form-group">
                        <label for="achievement">PIC</label>
                        <input type="text" class="form-control" id="achievement" name="pic" value="{{ $data->pic }}" required>
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <input type="text" class="form-control" id="Status" name="status" value="{{ $data->status }}" required>
                    </div>




                    <div class="form-group">
                        <label for="achievement">Remerks</label>
                        <input type="text" class="form-control" id="achievement" name="remerks" value="{{ $data->remerks }}" required>
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