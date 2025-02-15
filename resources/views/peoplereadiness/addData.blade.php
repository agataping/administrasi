@extends('template.main')
@section('title', 'People Readiness')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
            <a href="/indexPeople" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Add Data People Readiness</h2>
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
                <form action="{{ route('createDataPR') }}" method="POST">

                
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    

                    <div class="container-fluid mt-4"style="border-bottom: 1px solid black;">
                    <span></span> <br>

                    </div>
                    <div class="form-group">
                        <label for="nomor">Tanggal Data</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-4">
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
<style>
        .button {
    background-color: rgb(0, 255, 42);
    color: white; 
    border: none; 
    padding: 10px 20px; 
    font-size: 16px;
    cursor: pointer; 
    border-radius: 5px; 
    font-weight: bold;
}

.button:hover {
    background-color: rgb(0, 200, 35); 

</style>
@section('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById("note");

        // Fungsi untuk menambahkan nomor pada setiap baris
        function addLineNumbers(text) {
            const lines = text.split("\n");
            const numberedLines = lines.map((line, index) => {
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
