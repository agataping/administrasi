@extends('template.main')
@extends('components.style')
@section('title', 'HSE')
@extends('components.script')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">HSE</h3>
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
                <div class="row justify-content-start mb-0">
                    <div class="col-auto">
                        <form action="{{ route('formkategorihse') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Category HSE</button>
                        </form>
                    </div>

                    <div class="col-auto">
                        <form action="{{ route('formhse') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add HSE.</button>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-start ">
                    <div class="col-auto">
                        <a href="/indexcategoryhse">View category Data
                        </a>
                    </div>
                </div>

                <!-- @if(auth()->user()->role === 'admin')
                <form method="GET" action="{{ route('indexhse') }}" id="filterForm">
                    <label for="id_company">Select Company:
                        <br>
                        <small><em>To view company data, please select a company from the list.</em></small></label>
                    <select name="id_company" id="id_company" onchange="document.getElementById('filterForm').submit();">
                        <option value="">-- Select Company --</option>
                        @foreach ($perusahaans as $company)
                        <option value="{{ $company->id }}" {{ request('id_company') == $company->id ? 'selected' : '' }}>
                            {{ $company->nama }}
                        </option>
                        @endforeach
                    </select>
                </form>
                @endif -->
                <div class="" style="overflow-x:auto;">
                    <form method="GET" action="{{ route('indexhse') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div>
                            <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate ? $startDate->toDateString() : '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>
                        <div>
                            <label for="end_date" style="margin-right: 5px; font-weight: bold;">End Date:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate ? $endDate->toDateString() : '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>
                        <button type="submit" style=" padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                            Filter
                        </button>
                    </form>
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                        style="margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">

                    <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                        <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                            <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                                <tr>
                                    <th style="vertical-align: middle;">No</th>
                                    <th style="vertical-align: middle;">Date</th>
                                    <th style="vertical-align: middle;">Description</th>
                                    <th style="text-align: center;">Plan</th>
                                    <th style="text-align: center;">Actual</th>
                                    <th style="vertical-align: middle;">file</th>
                                    <th colspan="2" style="vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $kategori => $items)
                                <tr>
                                    <!-- Header untuk setiap kategori -->
                                    <td colspan="6" style="text-align: left; background-color: #f0f0f0;">
                                        {{ $kategori ?? '-' }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <form action="{{ route('formupdatecategoryhse', ['id' => $items->first()->id ?? '']) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>

                                </tr>
                                @foreach ($items as $d)
                                <tr>
                                    <th style="vertical-align: middle;">{{ $loop->iteration }}</th>
                                    <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($d->date)->format('d-m-Y') }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->keterangan ?? '-' }}</td>

                                    <td style="text-align: end; vertical-align: middle;">{{ number_format($d->plan), 2, ',', '.' ?? '-' }}</td>
                                    <td style="text-align: end; vertical-align: middle;">{{ number_format($d->actual), 2, ',', '.' ?? '-' }}</td>
                                    <td>
                                        @php
                                        $fileExtension = $d->file_extension ?? 'unknown';
                                        @endphp
                                        <a href="{{ asset('storage/' . $d->file) }}" class="text-decoration-none" target="_blank">View File</a>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('formupdatehse', ['id' => $d->id]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('deletehse', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                <tr>
                                    <th colspan="7" style="vertical-align: middle; background-color: rgb(244, 244, 244); text-align: end;">Total Nilai</th>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>











@endsection
@section('scripts')
<script>
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("myTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td");
            let rowVisible = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        rowVisible = true;
                        break;
                    }
                }
            }

            tr[i].style.display = rowVisible ? "" : "none";
        }
    }
</script>
@endsection