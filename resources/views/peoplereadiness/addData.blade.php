@extends('template.main')
@section('title', 'People Readiness')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexPeople" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data People Readiness</h3>
                </a>

{{-- Success Notification --}}
@if (session('success'))
<div id="notif-success" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
    {{ session('success') }}
</div>
@endif

{{-- Error Notification --}}
@if ($errors->any())
<div id="notif-error" style="
                position: fixed;
                top: 60px; /* Biar nggak nabrak success */
                right: 20px;
                background-color: #dc3545;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{{-- Script untuk menghilangkan notifikasi --}}
<script>
    setTimeout(function() {
        let notifSuccess = document.getElementById("notif-success");
        let notifError = document.getElementById("notif-error");

        if (notifSuccess) {
            notifSuccess.style.opacity = '0';
            setTimeout(() => notifSuccess.remove(), 500);
        }

        if (notifError) {
            notifError.style.opacity = '0';
            setTimeout(() => notifError.remove(), 500);
        }
    }, 3000);
</script>

                <form action="{{ route('createDataPR') }}" method="POST">


                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">


                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;">
                        <span></span> <br>

                    </div>
                    <div class="form-group">
                        <label for="nomor">data date</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <label for="firstName" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required name="posisi">
                        </div>


                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="" class="col-form-label">plan</label>
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
                            </div>
                        </div>

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

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" name="action" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                            <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
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