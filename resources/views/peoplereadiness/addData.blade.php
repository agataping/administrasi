@extends('template.main')
@section('title', 'People Readiness')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">People Readiness</h2>
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
                <form action="{{ route('createDataPR') }}" method="POST">

                
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    

                    <div class="container " style="border-bottom: 1px solid black;">
                    <span></span> <br>

                    </div>
                    <div class="row g-3">
                        <div class="col-sm-2">
                            <label for="firstName" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required name="posisi">
                        </div>
                        
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">plan</label>
                        </div>
                        
                        <div class="col-sm-2">
                            <label for="Fullfillment_plan" class="form-label">Fullfillment</label>
                            <input type="text" class="form-control" id="Fullfillment_plan" placeholder="" value="" required name="Fullfillment_plan" onchange="hitungQuantityFulfillment()">
                        </div>
                        <div class="col-sm-2">

                            <label for="POU_POU_plan" class="form-label">POP - POU</label>
                            <input type="number" class="form-control" id="POU_POU_plan" placeholder="" value="" required name="pou_pou_plan" oninput="hitungQuality()">
                        </div>
                        
                        <div class="col-sm-2">
                            <label for="Leadership_plan" class="form-label">Leadership</label>
                            <input type="number" class="form-control" id="Leadership_plan" placeholder="" value="" required name="Leadership_plan" oninput="hitungQuality()">
                        </div>
                        
                        <div class="col-sm-2">
                            <label for="HSE_plan" class="form-label">HSE</label>
                            <input type="number" class="form-control" id="HSE_plan" placeholder="" value="" required name="HSE_plan" oninput="hitungQuality()">
                        </div>
                        
                        <div class="col-sm-2">
                            <label for="Improvement_plan" class="form-label">Improvement</label>
                            <input type="number" class="form-control" id="Improvement_plan" placeholder="" value="" required name="Improvement_plan" oninput="hitungQuality()">
                        </div>
                        
                        
                    </div>
                    
                    <div class="container " style="border-bottom: 1px solid black;">
                        </div>
                        
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="" class="col-form-label">Actual</label>
                            </div>
                            
                            <div class="col-sm-2">
                                <label for="Fullfillment_actual" class="form-label">Fullfillment</label>
                                <input type="text" class="form-control" id="Fullfillment_actual" placeholder="" value="" required name="Fullfillment_actual"
                                oninput="hitungQuantityFulfillment()">
                            </div>
                            <div class="col-sm-2">
                                <label for="POU_POU_actual" class="form-label">POP - POU</label>
                                <input type="number" class="form-control" id="POU_POU_actual" placeholder="" value="" required name="pou_pou_actual" oninput="hitungQuality()">
                            </div>
                            
                            <div class="col-sm-2">
                                <label for="Leadership_actual" class="form-label">Leadership</label>
                                <input type="number" class="form-control" id="Leadership_actual" placeholder="" value="" required name="Leadership_actual" oninput="hitungQuality()">
                            </div>
                            
                            <div class="col-sm-2">
                                <label for="HSE_actual" class="form-label">HSE</label>
                                <input type="number" class="form-control" id="HSE_actual" placeholder="" value="" required name="HSE_actual" oninput="hitungQuality()">
                            </div>
                            
                            <div class="col-sm-2">
                                <label for="Improvement_actual" class="form-label">Improvement</label>
                                <input type="number" class="form-control" id="Improvement_actual" placeholder="" value="" required name="Improvement_actual" oninput="hitungQuality()">
                            </div>                    </div>
                            
                            <div class="col-sm-2">
                                
                                <label for="Quality " class="form-label">Quality </label>
                                <input type="text" class="form-control" id="Quality" placeholder="" value="" required name="Quality_plan">
                            </div>
                            
                            <div class="col-sm-2">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="quantity-fulfillment" placeholder="" value="" required name="Quantity_plan">
                            </div>
                            <div class="form-group">
                                <label for="note">Catatan:</label>
                                <textarea class="form-control" rows="10" cols="50" id="note" name="note" rows="5" placeholder="Catatan"></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-end  mt-3">
                                <button type="submit"
                                
                                class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Save</button>
                            </div>
                            

                            
                        </div>
                    </form>
                    
                </div>
            </div>
            
      
        

        
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
