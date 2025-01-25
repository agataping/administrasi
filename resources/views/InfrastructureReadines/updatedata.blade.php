@extends('template.main')

@section('title', 'InfrastructureReadiness')

@section('content')



<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Update Infrastructure Readiness</h2>
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
                <form action="{{ route('updateInfrastructureReadiness', $data->id) }}" method="POST" id="form-total">
                    @csrf

                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                    <div class="form-group">
                        <label for="nomor">Tanggal Data</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"  value="{{ $data->tanggal }}" required>
                    </div>
                    <div id="input-container">
                        
                        <div class="form-group">
                            <label for="ProjectName">Project Name</label>
                            <input type="text" class="form-control" id="ProjectName" name="ProjectName" value="{{ $data->ProjectName }}" required>
                        </div>
                        <div class="form-group">
                            <label for="Preparation">Preparation</label>
                            <input type="text" class="form-control" id="Preparation" name="Preparation" value="{{ $data->Preparation }}">
                        </div>
                        <div class="form-group">
                            <label for="Construction">Construction</label>
                            <input type="text" class="form-control" id="Construction" name="Construction" value="{{ $data->Construction }}">
                        </div>
                        <div class="form-group">
                            <label for="Commissiong">Commissiong</label>
                            <input type="text" class="form-control" id="Commissiong" name="Commissiong" value="{{ $data->Commissiong }}">
                        </div>
                        <div class="form-group">
                            <label for="kelayakan-bangunan">Kelayakan Bangunan</label>
                            <input type="number" class="form-control" id="kelayakan-bangunan" name="KelayakanBangunan" value="{{ $data->KelayakanBangunan }}" oninput="total()" required>
                        </div>
                        <div class="form-group">
                            <label for="kelengkapan">Kelengakapan</label>
                            <input type="number" class="form-control" id="kelengkapan" name="Kelengakapan" value="{{ $data->Kelengakapan }}" oninput="total()" required>
                        </div>
                        <div class="form-group">
                            <label for="Kebersihan">Kebersihan</label>
                            <input type="number" class="form-control" id="Kebersihan" name="Kebersihan" value="{{ $data->Kebersihan }}" oninput="total()" required>
                        </div>
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" name="total" value="{{ $data->total }}" readonly>
                        </div>

                        <div class="form-group">
                                <label for="note">Catatan:</label>
                                <textarea class="form-control" rows="10" cols="50" id="note" name="note" rows="5" placeholder="Catatan">{{ old('note', $data->note) }}</textarea>
                            </div>
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