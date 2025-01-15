@extends('template.main')

@section('title', 'Neraca')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Neraca</h2>
                
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

                <form action="{{ route('createfinanc') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;" required>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Pilih Kategori:</label>
                        <select id="kategori" name="sub_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($sub as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->namecategory }} | {{ $kategori->namesub }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="name" style="font-weight: bold; font-size: 1rem;">Deskripsi:</label>
                        <input type="text" id="name" name="name" plhaceholder="Cth. Mandiri Hauling Dll"style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; " required>
                    </div>





                    <div id="" class="form-group">
                        <label for="actual">Nominal</label>
                        <input type="text" class="form-control" id="actual" name="nominal">
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
@endsection