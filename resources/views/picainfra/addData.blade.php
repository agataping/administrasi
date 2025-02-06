@extends('template.main')

@section('title', 'PICA Infrastuctur')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <a href="/picainfrastruktur" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Add Data PICA Infrastuctur Readiness</h2>
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

                        <form action="{{ route('createpicainfra') }}" method="post">
                            @csrf
                            
                            <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                            <div class="form-group">
<label for="nomor"> Data Date</label>                                 <input type="date" class="form-control" id="tanggal" name="tanggal" required>
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
                                <input type="text" class="form-control" id="Status" name="status" >
                            </div>
                            
                            
    
                            
                            <div class="form-group">
                                <label for="achievement">Remerks</label>
                                <input type="text" class="form-control" id="achievement" name="remerks" required>
                            </div>
                            


                    
                    <div class="d-flex justify-content-end mt-3">
                        
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Save</button>                    </div>
                </form>
            </div>
        </div>
</div>

@endsection

@section('scripts')
@endsection