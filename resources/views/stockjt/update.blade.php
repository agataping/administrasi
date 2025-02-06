@extends('template.main')

@section('title', 'Stock Jetty')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <a href="/stockjt" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Update Data Stock Jetty</h2>
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
                        <input type="number" class="form-control" value="{{$data->sotckawal}}" id="stockawal" name="sotckawal" min="" >
                    </div>
                    <div class="form-group" id="plan" style="display: none;">
                        <label for="stock">Plan</label>
                        <input type="number" class="form-control" id="plan" name="plan" min=""  value="{{$data->plan}}">
                    </div>
                    <div class="form-group" id="file" style="display: none;">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file" min=""  value="{{$data->file}}">
                        @php
                        $fileExtension = $data->file_extension ?? 'unknown';
                        @endphp
                        <a href="{{ asset('storage/' . $data->file) }}" class="text-decoration-none" target="_blank">View File</a>
                        
                    </div>
                    
                    
                    <div class="form-group" id="stockout" style="display: none;">
                        <label for="stockout">Stock Out</label>
                        <input type="number" class="form-control" id="stockout" name="stockout" min=""  value="{{$data->stockout}}">
                    </div>

                    <div class="form-group">
                        <label for="shift_pertama">Shift I</label>
                        <input type="number" class="form-control" value="{{$data->shifpertama}}" id="shift_pertama" name="shifpertama" min="">
                    </div>

                    <div class="form-group">
                        <label for="shift_kedua">Shift II</label>
                        <input tBZype="number" class="form-control" value="{{$data->shifkedua}}" id="shift_kedua" name="shifkedua" min="0" >
                    </div>

                    <div class="form-group">
                        <label for="total_hauling">Total Hauling</label>
                        <input type="number" class="form-control" value="{{$data->totalhauling}}" id="total_hauling" name="totalhauling" min="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Lokasi">Location</label>
                        <input type="text" class="form-control" value="{{$data->lokasi}}" id="Lokasi" name="lokasi" >
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="stockbtn" class="btn btn-custom">Add Opening stock</button>
                        <button type="button" id="planBtn" class="btn btn-custom">Add Plan</button>
                        <button type="button" id="stockoutBtn" class="btn btn-custom ml-2">Add Stock Out</button>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Update</button>
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

        function calculateTotal() {
            const shift1 = parseFloat(shiftPertama.value) || 0;
            const shift2 = parseFloat(shiftKedua.value) || 0;
            totalHauling.value = shift1 + shift2;
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
        document.getElementById('stockout').style.display = 'none';
    });
    
    document.getElementById('stockoutBtn').addEventListener('click', function() {
        document.getElementById('plan').style.display = 'none';
        document.getElementById('file').style.display = 'none';
        document.getElementById('stockout').style.display = 'block';
    });

    window.onload = function() {
        const planValue = "{{ $data->plan }}";  
        const stockoutValue = "{{ $data->stockout }}";  
        const fileValue = "{{ $data->file }}"; 
        const stockAwalValue = "{{ $data->sotckawal }}";  
        
        // Jika hanya Plan yang ada
        if (planValue && !stockoutValue && !fileValue && !stockAwalValue) {
            document.getElementById('planBtn').click();  
        } 
        // Jika Plan dan File ada
        else if (planValue && fileValue && !stockoutValue) {
            document.getElementById('planBtn').click(); 
            document.getElementById('file').style.display = 'block';  
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
