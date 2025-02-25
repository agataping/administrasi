@extends('template.main')

@section('title', 'Meaning Readines')
@extends('components.style')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
            <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
            <a href="/indexmining" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Add Data Detail Meaning Readines</h2>
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

                    <select id="kategori" name="kategori" class="form-control">
                        <option value="" disabled selected>Select Category</option>
                        @foreach($kategori as $kategori)
                        <option value="{{ $kategori->kategori }}">{{ $kategori->kategori }}</option>
                        @endforeach
                    </select>
                    

                    <div >
                        <form action="{{ route('CreateMining') }}" method="post">
                            @csrf
                            <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                            <input type="hidden" name="KatgoriDescription" value="{{ $kategori->kategori }}">
                                                        
                            <div class="form-group">
                                <label for="nomor">Nomor</label>
                                <input type="text" class="form-control" id="nomor" name="nomor" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="Description" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nomor_legalitas">Legality Number</label>
                                <input type="text" class="form-control" id="nomor_legalitas" name="NomerLegalitas" >
                            </div>
                            
                            <div class="form-group">
                                <label for="Status">Status</label>
                                <input type="text" class="form-control" id="Status" name="status" >
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="tanggal_berlaku">Date</label>
                                <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal" >
                            </div>

                            <div class="form-group">
                                <label for="tanggal_berlaku"> Valid Until</label>
                                <input type="text" class="form-control" id="BERLAKU" name="berlaku" >
                            </div>

                            <div class="form-group">
                                <label for="filling"> Filling</label>
                                <input type="text" class="form-control" id="filling" name="filling" >
                            </div>
                            
                            <div class="form-group">
                                <label for="achievement">Achievement</label>
                                <input type="text" class="form-control" id="achievement" name="Achievement" required>
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