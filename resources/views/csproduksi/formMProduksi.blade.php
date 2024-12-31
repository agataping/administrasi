@extends('template.main')

@section('title', 'MONTHLY PRODUCTION')
@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">CS MONTHLY PRODUCTION</h2>
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
                <form action="{{ route('createMproduksi') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                    <!-- Tanggal -->
                    <div class="form-group mb-4">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <!-- Plan DAILY -->
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;"></div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Plan DAILY</h5>
                        </div>
                        <div class="col-sm-2">
                            <label for="dbcm_ob">OB (BCM)</label>
                            <input type="number" class="form-control" id="dbcm_ob" name="dbcm_ob" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="dcoal_ton">COAL (TON)</label>
                            <input type="number" class="form-control" id="dcoal_ton" name="dcoal_ton" nullable>
                        </div>
                    </div>

                    <!-- Plan MTD -->
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;"></div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Plan MTD</h5>
                        </div>
                        <div class="col-sm-2">
                            <label for="mbcm_ob">OB (BCM)</label>
                            <input type="number" class="form-control" id="mbcm_ob" name="mbcm_ob" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="mcoal_ton">M Coal Ton</label>
                            <input type="number" class="form-control" id="mcoal_ton" name="mcoal_ton" nullable>
                        </div>
                    </div>

                    <!-- Plan YTD -->
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;"></div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Plan YTD</h5>
                        </div>
                        <div class="col-sm-2">
                            <label for="ybcm_ob">OB (BCM)</label>
                            <input type="number" class="form-control" id="ybcm_ob" name="ybcm_ob" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="ycoal_ton">COAL (TON)</label>
                            <input type="number" class="form-control" id="ycoal_ton" name="ycoal_ton" nullable>
                        </div>
                    </div>

                    <!-- Actual OB (BCM) Volume -->
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;"></div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Actual OB (BCM) Volume</h5>
                        </div>
                        <div class="col-sm-2">
                            <label for="dactual">DAILY</label>
                            <input type="number" class="form-control" id="dactual" name="dactual" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="mactual">MTD</label>
                            <input type="number" class="form-control" id="mactual" name="mactual" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="yactual">YTD</label>
                            <input type="number" class="form-control" id="yactual" name="yactual" nullable>
                        </div>
                    </div>

                    <!-- Coal Getting -->
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;"></div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5>Coal Getting (TON)</h5>
                        </div>
                        <div class="col-sm-2">
                            <label for="dcoal">DAILY</label>
                            <input type="number" class="form-control" id="dcoal" name="dcoal" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="mcoal">MTD</label>
                            <input type="number" class="form-control" id="mcoal" name="mcoal" nullable>
                        </div>
                        <div class="col-sm-2">
                            <label for="ycoal">YTD</label>
                            <input type="number" class="form-control" id="ycoal" name="ycoal" nullable>
                        </div>
                    </div>

                    <!-- Bargings -->
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;"></div>
                    <div class="form-group mb-4">
                        <label for="bargings">Bargings</label>
                        <input type="number" class="form-control" id="bargings" name="bargings" nullable>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
