@extends('template.main')

@section('title', 'Pica Pa Ua')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Pica Pa Ua</h2>
                
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

                        <form action="{{ route('updatepicapaua',$data->id) }}" method="post">
                            @csrf
                            
                            <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                            <div class="form-group">
                                <label for="nomor">Tanggal Data</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"  value="{{ $data->tanggal }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nomor">Problem</label>
                                <input type="text" class="form-control" id="nomor" name="problem"  value="{{ $data->problem }}"required>
                            </div>
                            
                            <div class="form-group">
                                <label for="LuasLahan">Cause</label>
                                <input type="text" class="form-control" id="LuasLahan" name="cause"  value="{{ $data->cause }}"required>
                            </div>
                            
                            <div class="form-group">
                                <label for="KebutuhanLahan">Corective Action</label>
                                <input type="text" class="form-control" id="KebutuhanLahan" name="corectiveaction"  value="{{ $data->corectiveaction }}"required>
                            </div>
                            
                            <div class="form-group">
                                <label for="Status">Due Date</label>
                                <input type="text" class="form-control" id="Progress" name="duedate"  value="{{ $data->duedate }}"required>
                            </div>

                            <div class="form-group">
                                <label for="achievement">PIC</label>
                                <input type="text" class="form-control" id="achievement" name="pic"  value="{{ $data->pic }}"required>
                            </div>

                            <div class="form-group">
                                <label for="Status">Status</label>
                                <input type="text" class="form-control" id="Status" name="status" value="{{ $data->status }}" required>
                            </div>
                            
                            
    
                            
                            <div class="form-group">
                                <label for="achievement">Remerks</label>
                                <input type="text" class="form-control" id="achievement" name="remerks"  value="{{ $data->remerks }}"required>
                            </div>
                            


                    
                    <div class="d-flex justify-content-end mt-3">
                        
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
</div>

@endsection

@section('scripts')
@endsection