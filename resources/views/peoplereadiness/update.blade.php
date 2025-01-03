@extends('template.main')

@section('title', 'Update People Readiness')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Update People Readiness</h2>

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
                <form action="{{ route('updatedata', $peopleReadiness->id) }}" method="POST">
                    @csrf
                    <div class="container" style="border-bottom: 1px solid black;">
                        <span></span> <br>
                    </div>
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">

                    <div class="row g-3">
                        <div class="col-sm-2">
                            <label for="posisi" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="posisi" name="posisi" value="{{ $peopleReadiness->posisi }}" required>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">Plan</label>
                            </div>

                            <div class="col-sm-2">
                                <label for="Fullfillment_plan" class="form-label">Fullfillment</label>
                                <input type="number" class="form-control" id="Fullfillment_plan" name="Fullfillment_plan" value="{{ $peopleReadiness->Fullfillment_plan }}" required onchange="hitungQuantityFulfillment()">
                            </div>

                            <div class="col-sm-2">
                                <label for="pou_pou_plan" class="form-label">POP - POU</label>
                                <input type="number" class="form-control" id="POU_POU_plan" name="pou_pou_plan" value="{{ $peopleReadiness->pou_pou_plan }}" required onchange="hitungQuality()" >
                            </div>

                            <div class="col-sm-2">
                                <label for="Leadership_plan" class="form-label">Leadership</label>
                                <input type="number" class="form-control" id="Leadership_plan" name="Leadership_plan" value="{{ $peopleReadiness->Leadership_plan }}" required onchange="hitungQuality()">
                            </div>

                            <div class="col-sm-2">
                                <label for="HSE_plan" class="form-label">HSE</label>
                                <input type="number" class="form-control" id="HSE_plan" name="HSE_plan" value="{{ $peopleReadiness->HSE_plan }}" required onchange="hitungQuality()">
                            </div>

                            <div class="col-sm-2">
                                <label for="Improvement_plan" class="form-label">Improvement</label>
                                <input type="number" class="form-control" id="Improvement_plan" name="Improvement_plan" value="{{ $peopleReadiness->Improvement_plan }}" required onchange="hitungQuality()">
                            </div>
                        </div>
                    </div>

                    <div class="container" style="border-bottom: 1px solid black;"></div>

                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label class="col-form-label">Actual</label>
                        </div>

                        <div class="col-sm-2">
                            <label for="Fullfillment_actual" class="form-label">Fullfillment</label>
                            <input type="number" class="form-control" id="Fullfillment_actual" name="Fullfillment_actual" value="{{ $peopleReadiness->Fullfillment_actual }}" required onchange="hitungQuantityFulfillment()">
                        </div>

                        <div class="col-sm-2">
                            <label for="pou_pou_actual" class="form-label">POP - POU</label>
                            <input type="number" class="form-control" id="POU_POU_actual" name="pou_pou_actual" value="{{ $peopleReadiness->pou_pou_actual }}" required onchange="hitungQuality()">
                        </div>

                        <div class="col-sm-2">
                            <label for="Leadership_actual" class="form-label">Leadership</label>
                            <input type="number" class="form-control" id="Leadership_actual" name="Leadership_actual" value="{{ $peopleReadiness->Leadership_actual }}" required onchange="hitungQuality()">
                        </div>

                        <div class="col-sm-2">
                            <label for="HSE_actual" class="form-label">HSE</label>
                            <input type="number" class="form-control" id="HSE_actual" name="HSE_actual" value="{{ $peopleReadiness->HSE_actual }}" required onchange="hitungQuality()">
                        </div>

                        <div class="col-sm-2">
                            <label for="Improvement_actual" class="form-label">Improvement</label>
                            <input type="number" class="form-control" id="Improvement_actual" name="Improvement_actual" value="{{ $peopleReadiness->Improvement_actual }}" required onchange="hitungQuality()">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <label for="Quality_plan" class="form-label">Quality</label>
                            <input type="text" class="form-control" id="Quality" name="Quality_plan" value="{{ $peopleReadiness->Quality_plan }}" required  readonly>
                        </div>

                        <div class="col-sm-2">
                            <label for="Quantity_plan" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity-fulfillment" name="Quantity_plan" value="{{ $peopleReadiness->Quantity_plan }}" required  readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-custom">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection
