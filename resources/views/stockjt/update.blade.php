@extends('template.main')
@section('title', 'Stock Jetty')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/stockjt" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Update Data Stock Jetty</h3>
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

                <form action="{{ route('updatestockjt',$data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="updated_by" value="{{ Auth::user()->username }}">

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" value="{{$data->date}}" id="date" name="date" required>
                    </div>

                    <div class="form-group" id="stock" style="display: none;">
                        <label for="stock">Opening Stock</label>
                        <input type="text" class="form-control" value="{{$data->sotckawal}}" id="stockawal" name="sotckawal" min="">
                    </div>
                    <div class="form-group" id="plan" style="display: none;">
                        <label for="stock">Plan</label>
                        <input type="text" class="form-control" id="plan" name="plan" min="" value="{{$data->plan}}">
                    </div>


                    <div id="stockout-container" style="display: none; margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Load to Barger / stock out:</label>
                        <select id="stockout" name="stockout" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled>-- Select Load to Barge --</option>
                            @foreach($barging as $kategori)
                            <option value="{{ $kategori->quantity }}"
                                {{ old('stockout', $data->quantity ?? '') == $kategori->quantity ? 'selected' : '' }}>
                                {{ $kategori->laycan }} | {{ $kategori->quantity }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="shift_pertama">Shift I</label>
                        <input type="text" class="form-control" value="{{$data->shifpertama}}" id="shift_pertama" name="shifpertama" min="">
                    </div>

                    <div class="form-group">
                        <label for="shift_kedua">Shift II</label>
                        <input tBZype="text" class="form-control" value="{{$data->shifkedua}}" id="shift_kedua" name="shifkedua" min="0">
                    </div>

                    <div class="form-group">
                        <label for="total_hauling">Total Hauling</label>
                        <input type="text" class="form-control" value="{{$data->totalhauling}}" id="total_hauling" name="totalhauling" min="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Lokasi">Location</label>
                        <input type="text" class="form-control" value="{{$data->lokasi}}" id="Lokasi" name="lokasi">
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file" min="" value="{{$data->file}}">
                        @php
                        $fileExtension = $data->file_extension ?? 'unknown';
                        @endphp
                        <a href="{{ asset('storage/' . $data->file) }}" class="text-decoration-none" target="_blank">View File</a>

                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="stockbtn" class="btn">Add Opening stock</button>
                        <button type="button" id="planBtn" class="btn">Add Plan</button>
                        <button type="button" id="stockoutBtn" class="btn ml-2">Add Stock Out</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const shiftPertama = document.getElementById('shift_pertama');
        const shiftKedua = document.getElementById('shift_kedua');
        const totalHauling = document.getElementById('total_hauling');
        
        function parseNumber(value) {
            return parseFloat(value.replace(',', '.')) || 0;
        }
        
        function calculateTotal() {
            const shift1 = parseNumber(shiftPertama.value);
            const shift2 = parseNumber(shiftKedua.value);
            const total = shift1 + shift2;
            
            totalHauling.value = total.toString().replace('.', ',');
        }
        
        shiftPertama.addEventListener('input', calculateTotal);
        shiftKedua.addEventListener('input', calculateTotal);
    });
    

    document.getElementById('stockbtn').addEventListener('click', function() {
        const stockDiv = document.getElementById('stock');
        if (stockDiv.style.display === 'none' || stockDiv.style.display === '') {
            stockDiv.style.display = 'block'; 
            this.textContent = 'Remove Opening Stock'; 
        } else {
            stockDiv.style.display = 'none'; 
            this.textContent = 'Add Opening Stock'; 
        }
    });    
    
    
    document.getElementById('planBtn').addEventListener('click', function() {
        document.getElementById('plan').style.display = 'block';
        document.getElementById('file').style.display = 'block';
        document.getElementById('stockout-container').style.display = 'none';
    });
    
    document.getElementById('stockoutBtn').addEventListener('click', function() {
        document.getElementById('plan').style.display = 'none';
        document.getElementById('stockout-container').style.display = 'block';
    });

    window.onload = function() {
        const planValue = " {{ $data->plan }}";
                            const stockoutValue="{{ $data->stockout }}" ;
                            const fileValue="{{ $data->file }}" ;
                            const stockAwalValue="{{ $data->sotckawal }}" ;

                            // Jika hanya Plan yang ada
                            if (planValue && !stockoutValue && !fileValue && !stockAwalValue) {
                            document.getElementById('planBtn').click();
                            }
                            // Jika Plan dan File ada
                            else if (planValue && fileValue && !stockoutValue) {
                            document.getElementById('planBtn').click();
                            document.getElementById('file').style.display='block' ;
                            }
                            // Jika Stock Out yang ada
                            else if (stockoutValue) {
                            document.getElementById('stockoutBtn').click();
                            }
                            // Jika Stock Awal ada
                            else if (stockAwalValue) {
                            document.getElementById('stockbtn').click();
                            }
                            };





                            </script>
                            @endsection