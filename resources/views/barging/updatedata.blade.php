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

                    
                        <form action="{{ route('updatedatabarging', $data->id) }}" method="POST" >

                            @csrf
                            
                            <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <div class="form-group">
                                <label for="tanggal_berlaku">Tanggal Data</label>
                                <input type="date" class="form-control" value="{{$data->tanggal}}" id="" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label for="nomor">Laycan</label>
                                <input type="text" class="form-control" value="{{$data->laycan}}" id="nomor" name="laycan" required>
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
                                <label for="tanggal_berlaku">Notify Addres</label>
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
                        
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Update</button>
                    </div>
                </form>
            </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection