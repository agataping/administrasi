@extends('template.main')

@section('title', 'Kategori HPP')

@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Kategori HPP</h2>
                
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

                <form action="{{ route('addhpp') }}" method="POST">
                    @csrf
                    <div id="input-sub">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="subcategory">Sub Category</label>
                                <input type="text" class="form-control" name="items[0][subcategory]" placeholder="Over Burden dll" >
                            </div>
                            <div class="col-md-4">
                                <label for="plan">Rencana</label>
                                <input type="text" class="form-control" name="items[0][planSub]" placeholder="Rencana" >
                            </div>
                            <div class="col-md-4">
                                <label for="realisasi">Realisasi</label>
                                <input type="text" class="form-control" name="items[0][realisasiSub]" placeholder="Realisasi" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-auto justify-content-start">
                                <button type="button" id="add-sub" class="btn btn-success">Tambah Baris Sub Category</button>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-4 " style="border-bottom: 1px solid black;">
                        </div>

                    <div id="dynamic-input">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="item">Item</label>
                                <input type="text" class="form-control" name="items[0][item]" placeholder="Misal: Subcontractor A" >
                            </div>
                            <div class="col-md-4">
                                <label for="rencana">Rencana</label>
                                <input type="number" class="form-control" name="items[0][rencana]" placeholder="Masukkan jumlah rencana" >
                            </div>
                            <div class="col-md-4">
                                <label for="realisasi">Realisasi</label>
                                <input type="number" class="form-control" name="items[0][realisasi]" placeholder="Masukkan jumlah realisasi">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-auto justify-content-start">
                            <button type="button" id="add-row" class="btn btn-success">Tambah Baris Item</button>
                        </div>
                        
                        <div class="col-auto justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = 1;
    let rowIndexSub = 1;

    // Menambahkan baris untuk Item
    document.getElementById('add-row').addEventListener('click', function () {
        const dynamicInput = document.getElementById('dynamic-input');
        const newRow = `
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="item">Item</label>
                    <input type="text" class="form-control" name="items[${rowIndex}][item]" placeholder="Misal: Subcontractor B" >
                </div>
                <div class="col-md-4">
                    <label for="rencana">Rencana</label>
                    <input type="number" class="form-control" name="items[${rowIndex}][rencana]" placeholder="Masukkan jumlah rencana" >
                </div>
                <div class="col-md-4">
                    <label for="realisasi">Realisasi</label>
                    <input type="number" class="form-control" name="items[${rowIndex}][realisasi]" placeholder="Masukkan jumlah realisasi">
                </div>
            </div>`;
        dynamicInput.insertAdjacentHTML('beforeend', newRow);
        rowIndex++;
    });

    // Menambahkan baris untuk Sub Category
    document.getElementById('add-sub').addEventListener('click', function () {
        const inputSub = document.getElementById('input-sub');
        const newRow = `
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="subcategory">Sub Category</label>
                    <input type="text" class="form-control" name="items[${rowIndexSub}][subcategory]" placeholder="Over Burden dll">
                </div>
                <div class="col-md-4">
                    <label for="plan">Rencana</label>
                    <input type="text" class="form-control" name="items[${rowIndexSub}][planSub]" placeholder="Rencana">
                </div>
                <div class="col-md-4">
                    <label for="realisasi">Realisasi</label>
                    <input type="text" class="form-control" name="items[${rowIndexSub}][realisasiSub]" placeholder="Realisasi">
                </div>
            </div>`;
        inputSub.insertAdjacentHTML('beforeend', newRow);
        rowIndexSub++;
    });
});
</script>
