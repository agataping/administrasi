@extends('template.main')

@section('title', 'Update People Readiness')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexpicapeople" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Update Data PICA People Readiness</h3>
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

                <form action="{{ route('updatedata', $peopleReadiness->id) }}" method="POST">
                    @csrf
                    <div class="container-fluid mt-4" style="border-bottom: 1px solid black;">
                        <span></span> <br>
                    </div>
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="nomor"> Data Date</label> <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $peopleReadiness->tanggal }}" required>
                    </div>
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
                                <input type="number" class="form-control" id="POU_POU_plan" name="pou_pou_plan" value="{{ $peopleReadiness->pou_pou_plan }}" required onchange="hitungQuality()">
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
                            <input type="text" class="form-control" id="Quality" name="Quality_plan" value="{{ $peopleReadiness->Quality_plan }}" required readonly>
                        </div>

                        <div class="col-sm-2">
                            <label for="Quantity_plan" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity-fulfillment" name="Quantity_plan" value="{{ $peopleReadiness->Quantity_plan }}" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note">Catatan:</label>
                        <textarea id="note" class="form-control" rows="10" cols="50" name="note" placeholder="Catatan">{{ old('note', $peopleReadiness->note) }}</textarea>
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
        document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById(" note");

                            // Fungsi untuk menambahkan nomor pada setiap baris
                            function addLineNumbers(text) {
                            const lines=text.split("\n");
                            const numberedLines=lines.map((line, index)=> {
                            return `${index + 1}. ${line}`;
                            });
                            return numberedLines.join("\n");
                            }

                            // Saat halaman dimuat, tambahkan nomor pada textarea jika ada catatan
                            window.addEventListener('load', () => {
                            textarea.value = addLineNumbers(textarea.value); // Menambahkan nomor saat halaman dimuat
                            });

                            // Fungsi untuk memperbarui nomor baris saat ada perubahan dalam textarea
                            function updateLineNumbers() {
                            let lines = textarea.value.split("\n");
                            lines = lines.map((line, index) => `${index + 1}. ${line.replace(/^\d+\.\s*/, '')}`); // Menghapus nomor lama dan menambahkan nomor baru
                            textarea.value = lines.join("\n");
                            }

                            // Menambahkan nomor setiap kali ada input atau enter
                            textarea.addEventListener('input', updateLineNumbers);

                            // Menambahkan nomor baris sebelum form disubmit
                            const form = document.querySelector('form'); // Ambil form
                            form.addEventListener('submit', function(event) {
                            textarea.value = addLineNumbers(textarea.value); // Tambahkan nomor sebelum submit
                            });
                            });

                            </script>
                            @endsection