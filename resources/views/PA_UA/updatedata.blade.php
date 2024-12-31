@extends('template.main')
@section('title', 'MINING')
@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">PA & UA</h2>
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
                <form action="{{ route('updateproduksi', $data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control select2" required>
                            <option value="" disabled selected>Pilih Unit</option>
                            @foreach($unit as $u)
                            <option value="{{ $u->id }}" 
                            {{ $u->code_number . ' | ' . $u->unit == $data->code_number . ' | ' . $data->unit ? 'selected' : '' }}>
                            {{ $u->code_number . ' | ' . $u->unit }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                
                
                <hr class="my-4">
                
                <div class="row mb-3">
                    <div class="col-12">
                        <h5>Produksi OB</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="ob_bcm">BCM</label>
                        <input type="number" class="form-control" value="{{$data->ob_bcm}}" id="ob_bcm" name="ob_bcm" nullable>
                    </div>
                    <div class="col-sm-2">
                        <label for="ob_wh">WH OB</label>
                        <input type="number" class="form-control" value="{{$data->ob_wh}}" id="ob_wh" name="ob_wh" nullable>
                    </div>
                    <div class="col-sm-2">
                        <label for="ob_pty">PTY</label>
                        <input type="number" class="form-control" value="{{$data->ob_pty}}" id="ob_pty" name="ob_pty" nullable>
                    </div>
                    <div class="col-sm-2">
                        <label for="ob_distance">DISTANCE</label>
                        <input type="number" class="form-control" value="{{$data->ob_distance}}" id="ob_distance" name="ob_distance" nullable>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row mb-3">
                    <div class="col-12">
                        <h5>Produksi Coal</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="coal_mt">MT</label>
                        <input type="number" class="form-control" value="{{$data->coal_mt}}" id="coal_mt" name="coal_mt" nullable>
                    </div>
                    <div class="col-sm-2">
                        <label for="coal_wh">WH</label>
                        <input type="number" class="form-control" value="{{$data->coal_wh}}" id="coal_wh" name="coal_wh" nullable>
                    </div>
                    <div class="col-sm-2">
                            <label for="coal_pty">PTY</label>
                            <input type="number" class="form-control" value="{{$data->coal_pty}}" id="coal_pty" name="coal_pty" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="coal_distance">DISTANCE</label>
                            <input type="number" class="form-control" value="{{$data->coal_distance}}" id="coal_distance" name="coal_distance" nullable>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>HOURS</h5>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="general_hours">GENERAL</label>
                            <input type="number" class="form-control" value="{{$data->general_hours}}" id="general_hours" name="general_hours" nullable>
                            
                        </div>
                        <div class="col-sm-2">
                            <label for="rental_hours">G</label>
                            <input type="number" class="form-control" value="{{$data->rental_hours}}" id="rental_hours" name="rental_hours" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="stby_hours">STBY</label>
                            <input type="number" class="form-control" value="{{$data->stby_hours}}" id="stby_hours" name="stby_hours" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="bd_hours">BD</label>
                            <input type="number" class="form-control" value="{{$data->bd_hours}}" id="bd_hours" name="bd_hours" nullable>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="mohh">MOHH</label>
                            <input type="number" class="form-control" value="{{$data->mohh}}" id="mohh" name="mohh" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="pa">PA</label>
                            <input type="number" class="form-control" value="{{$data->pa}}" id="pa" name="pa" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="ua">UA</label>
                            <input type="number" class="form-control" value="{{$data->ua}}" id="ua" name="ua" nullable>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Fuel Consumption</h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="ltr_total">TOT. LITER</label>
                            <input type="number" class="form-control" value="{{$data->ltr_total}}" id="ltr_total" name="ltr_total" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="ltr_wh">L/WH</label>
                            <input type="number" class="form-control" value="{{$data->ltr_wh}}" id="ltr_wh" name="ltr_wh" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="ltr">Liter OB</label>
                            <input type="number" class="form-control" value="{{$data->ltr}}" id="ltr" name="ltr" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="ltr_coal">Liter Coal</label>
                            <input type="number" class="form-control" value="{{$data->ltr_coal}}" id="ltr_coal" name="ltr_coal" nullable>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="t_hm">Total HM</label>
                            <input type="number" class="form-control" value="{{$data->t_hm}}" id="t_hm" name="t_hm" nullable>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Fuel Ratio (Liter)</h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="l_hm">L/HM</label>
                            <input type="number" class="form-control" value="{{$data->l_hm}}" id="l_hm" name="l_hm" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="l_bcm">L/BCM</label>
                            <input type="number" class="form-control" value="{{$data->l_bc}}" id="l_bcm" name="l_bcm" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="l_mt">G</label>
                            <input type="number" class="form-control" value="{{$data->l_mt}}" id="l_mt" name="l_mt" nullable>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="tot_ma">MA</label>
                            <input type="text" class="form-control" value="{{$data->tot_ma}}" id="tot_ma" name="tot_ma" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="tot_pa">PA</label>
                            <input type="text" class="form-control" value="{{$data->tot_pa}}" id="tot_pa" name="tot_pa" nullable>
                        </div>

                        <div class="form-group">
                            <label for="tot_ua">UA</label>
                            <input type="text" class="form-control" value="{{$data->tot_ua}}" id="tot_ua" name="tot_ua">
                        </div>
                        <div class="form-group">
                            <label for="eu">EU</label>
                            <input type="text" class="form-control" value="{{$data->eu}}" id="eu" name="eu">
                        </div>
                        <div class="form-group">
                            <label for="plan">PA PLAN</label>
                            <input type="text" class="form-control" value="{{$data->pa_plan}}" id="plan" name="pa_plan">
                        </div>
                        <div class="form-group">
                            <label for="ua_plan">UA PLAN</label>
                            <input type="text" class="form-control" value="{{$data->ua_plan}}" id="ua_plan" name="ua_plan">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection