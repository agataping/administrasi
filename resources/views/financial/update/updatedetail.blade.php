@extends('template.main')
@section('title', 'Balnce sheet')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexfinancial" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Update Data Detail Balence sheet</h3>
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


                <form action="{{ route('updatedetailfinan',$data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Data date:</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{$data->tanggal}}" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="" class="form-label">Order Number</label>
                            <input type="number" class="form-control" id="" placeholder="" value="{{ $data->ordernumber}}" required name="ordernumber">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="sub_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($sub as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $data->sub_id ? 'selected' : '' }}>
                                {{ $kategori->namecategory }} | {{ $kategori->namesub }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="name" style="font-weight: bold; font-size: 1rem;">Description:</label>
                        <input type="text" id="name" name="name" value="{{$data->name}}" plhaceholder="Cth. Mandiri Hauling Dll" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; " required>
                    </div>

                    <div id="debitplan" class="form-group" style="display: none;">
                        <label for="actual">Debit plan</label>
                        <input type="text" class="form-control" id="debitplan" name="debit" value="{{$data->debit}}">
                    </div>
                    <div id="creditplan" class="form-group" style="display: none;">
                        <label for="actual">Credit plan </label>
                        <input type="text" class="form-control" id="creditplan" name="credit" value="{{$data->credit}}">
                    </div>
                    <div id="fileplan" style="display: none;" class="form-group">
                        <label for="fileplan">File Plan</label>
                        <input type="file" class="form-control" name="fileplan">

                        @if (!empty($data->fileplan))
                        <a href="{{ asset('storage/' . $data->fileplan) }}" class="text-decoration-none" target="_blank">View File Plan</a>
                        @else
                        <span class="text-muted">No File</span>
                        @endif
                    </div>

                    <div id="debitactual" class="form-group" style="display: none;">
                        <label for="actual">Debit actual</label>
                        <input type="text" class="form-control" id="debitactual" name="debit_actual" value="{{$data->debit_actual}}">
                    </div>

                    <div id="creditactual" class="form-group" style="display: none;">
                        <label for="actual">Credit actual</label>
                        <input type="text" class="form-control" id="creditactual" name="credit_actual" value="{{$data->credit_actual}}">
                    </div>
                    <div id="fileactual" style="display: none;" class="form-group">
                        <label for="fileactual">File Actual</label>
                        <input type="file" class="form-control" name="fileactual">

                        @if (!empty($data->fileactual))
                        <a href="{{ asset('storage/' . $data->fileactual) }}" class="text-decoration-none" target="_blank">View File</a>
                        @else
                        <span class="text-muted">No File Plan</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end mt-3" style="display: none;">
                        <button type="button" id="planBtn" class="btn">Add Plan</button>
                        <button type="button" id="actualBtn" class="btn ml-2">Add Actual</button>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn-block btn-lg gradient-custom-4"
                            style=" background-color: rgb(0, 255, 42); color: white; border: none;padding: 10px 20px;font-size: 16px;cursor: pointer; 
                            border-radius: 5px; font-weight: bold;"">Update</button>
                    </div>               
                 </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('planBtn').addEventListener('click', function() {
        document.getElementById('debitactual').style.display = 'none';
        document.getElementById('creditactual').style.display = 'none';
        document.getElementById('fileactual').style.display = 'none';

        document.getElementById('fileplan').style.display = 'block';
        document.getElementById('debitplan').style.display = 'block';
        document.getElementById('creditplan').style.display = 'block';
    });

    document.getElementById('actualBtn').addEventListener('click', function() {
        document.getElementById('debitactual').style.display = 'block';
        document.getElementById('creditactual').style.display = 'block';
        document.getElementById('fileactual').style.display = 'block';

        document.getElementById('debitplan').style.display = 'none';
        document.getElementById('creditplan').style.display = 'none';
        document.getElementById('fileplan').style.display = 'none';

    });
    window.onload = function() {
    const planValue = " {{ $data->nominalplan }}".trim(); // Nilai nominal plan
                            const actualValue="{{ $data->nominalactual }}" .trim(); // Nilai nominal actual
                            const filePlanValue="{{ $data->fileplan }}" .trim(); // File Plan
                            const fileActualValue="{{ $data->fileactual }}" .trim(); // File Actual
                            const debitPlanValue="{{ $data->debit }}" .trim(); // Debit Plan
                            const creditPlanValue="{{ $data->credit }}" .trim(); // Credit Plan
                            const debitActualValue="{{ $data->debit_actual }}" .trim(); // Debit Actual
                            const creditActualValue="{{ $data->credit_actual }}" .trim(); // Credit Actual

                            // Fungsi untuk mengecek apakah elemen ada sebelum klik
                            function safeClick(buttonId) {
                            const btn=document.getElementById(buttonId);
                            if (btn) btn.click();
                            }

                            // Logika untuk menampilkan elemen sesuai data
                            if (planValue !=="" && actualValue==="" && filePlanValue==="" && fileActualValue===""
                            && debitPlanValue !=="" && creditPlanValue !=="" && debitActualValue==="" && creditActualValue==="" ) {
                            safeClick('planBtn');
                            }
                            else if (planValue !=="" && filePlanValue !=="" && actualValue===""
                            && debitPlanValue !=="" && creditPlanValue !=="" && debitActualValue==="" && creditActualValue==="" ) {
                            safeClick('planFileBtn');
                            }
                            else if (actualValue !=="" || debitActualValue !=="" || creditActualValue !=="" || fileActualValue !=="" ) {
                            safeClick('actualBtn');
                            }
                            };


                            </script>
                            @endsection