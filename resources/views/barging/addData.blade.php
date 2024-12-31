@extends('template.main')

@section('title', 'Barging')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Barging</h2>
                
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

                    
                        <form action="{{ route('createbarging') }}" method="post">
                            @csrf
                            
                            <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                      
                            <div class="form-group">
                                <label for="nomor">Layca</label>
                                <input type="text" class="form-control" id="nomor" name="laycan" required>
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
                                <label for="tanggal_berlaku">Notify Addres</label>
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
                        
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                    </div>
                </form>
            </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection