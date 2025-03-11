@extends('template.main')

@section('title', 'Input Stock Jetty')
@extends('components.style')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/stockjt" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Add Data Stock Jetty</h3>
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

                <form action="{{ route('createstockjt') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="created_by" value="{{ Auth::user()->username }}">

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="form-group" id="stock" style="display: none;">
                        <label for="stock">Opening Stock</label>
                        <input type="text" class="form-control" id="stockawal" name="sotckawal" min="">
                    </div>

                    <div class="form-group" id="plan" style="display: none;">
                        <label for="stock">Plan</label>
                        <input type="text" class="form-control" id="plan" name="plan" min="">
                    </div>




                    <div id="stockout-container" style="display: none; margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Load to Barger / stock out:</label>
                        <select id="stockout" name="stockout" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Load to Barge--</option>
                            @foreach($data as $kategori)
                            <option value="{{ $kategori->quantity }}">{{ $kategori->quantity }}|{{ $kategori->quantity }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="shift_pertama">Shift I</label>
                        <input type="text" class="form-control" id="shift_pertama" name="shifpertama" min="">
                    </div>

                    <div class="form-group">
                        <label for="shift_kedua">Shift II</label>
                        <input tBZype="text" class="form-control" id="shift_kedua" name="shifkedua" min="">
                    </div>

                    <div class="form-group">
                        <label for="total_hauling">Total Hauling</label>
                        <input type="text" class="form-control" id="total_hauling" name="totalhauling" min="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Lokasi">Location</label>
                        <input type="text" class="form-control" id="Lokasi" name="lokasi">
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file" min="">
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="stockbtn" style="all: unset; padding: 8px 12px;">Add Opening Stock</button>
                        <button type="button" id="planBtn" style="all: unset; padding: 8px 12px;">Add Plan</button>
                        <button type="button" id="stockoutBtn" style="all: unset; padding: 8px 12px;" class="ml-2">Add Stock Out</button>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" name="action" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                        <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
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
</script>
@endsection