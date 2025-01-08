@extends('template.main')

@section('title', 'Input Stock JT')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Input Stock JT</h2>
                
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

                <form action="{{ route('createstockjt') }}" method="post">
                    @csrf

                    <input type="hidden" name="created_by" value="{{ Auth::user()->username }}">

                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="stock_awal">Stock Awal</label>
                        <input type="number" class="form-control" id="stock_awal" name="sotckawal" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="shift_pertama">Shift Pertama</label>
                        <input type="number" class="form-control" id="shift_pertama" name="shifpertama" min="0">
                    </div>

                    <div class="form-group">
                        <label for="shift_kedua">Shift Kedua</label>
                        <input tBZype="number" class="form-control" id="shift_kedua" name="shifkedua" min="0" >
                    </div>

                    <div class="form-group">
                        <label for="total_hauling">Total Hauling</label>
                        <input type="number" class="form-control" id="total_hauling" name="totalhauling" min="0" readonly>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
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
</script>
@endsection
