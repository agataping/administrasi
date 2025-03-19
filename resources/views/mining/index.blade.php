@extends('template.main')
@extends('components.style')

@section('title', 'Mining Readines')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">Mining Readines</h3>
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
                                <div class="row justify-content-start mb-0">
                    <div class="col-auto">
                        <form action="{{ route('FormKategori') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Category</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('FormMining') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-start ">
                    <div class="col-auto">
                        <a href="/categorymining">View category Data
                        </a>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexmining') }}" id="filterForm">
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
                @endif
 -->

                <form method="GET" action="{{ route('indexmining') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                    </div>
                    <div>
                        <label for="end_date" style="margin-right: 5px; font-weight: bold;">End Date:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                    </div>
                    <button type="submit" style=" padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                        Filter
                    </button>
                </form>
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="margin-bottom: 10px; padding: 5px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">

                <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                    <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                        <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">No</th>
                                <th rowspan="2" style="vertical-align: middle;">Description</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Legality Number</th>
                                <th rowspan="2" style="vertical-align: middle;">Status</th>
                                <th colspan="3" style="text-align: center;">JTN</th>
                                <th rowspan="2" style="vertical-align: middle;">Achievement</th>
                                <th rowspan="2" colspan="2" style="vertical-align: middle;">Action</th>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Valid Until</th>
                                <th>Filling / Document Location</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($groupedData as $kategori => $items)
                            <tr>
                                <th style="vertical-align: middle; background-color: #f0f0f0;">{{ $loop->iteration }}</th>

                                <th colspan="7" style="text-align: left; background-color: #f0f0f0;">
                                    {{ $kategori ?? '-' }}
                                </th>
                                <td>
                                    <form action="{{ route('formupdatecategorymining', ['id' => $items->first()->id ?? '']) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                </td>
                            </tr>

                            @foreach ($items as $d)
                            <tr>
                                <th style="vertical-align: middle;">{{ $loop->iteration }}</th>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Description ?? '-' }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->NomerLegalitas ?? '-' }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->status ?? '-' }}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;
                                    @php
                                    $bgColor = '#ffffff'; // Default warna background (putih)
                                    
                                    if (Str::contains(strtolower($d->berlaku), 'sekarang')) {
                                        
                                            $bgColor = '#90EE90'; // Hijau muda
                                        } elseif (preg_match('/\d{1,2} \w+ \d{4}/', $d->berlaku)) {
                                            $bgColor = '#FFD700'; // Kuning emas (untuk format tanggal)
                                        } elseif (preg_match('/\d+ tahun/', strtolower($d->berlaku))) {
                                            $bgColor = '#ADD8E6'; // Biru muda (untuk " x tahun")
                                    }
                                    @endphp
                                    background-color: {{ $bgColor }}; ">
                                    {{ $d->berlaku ?? '-' }}
                                </td>
                                <td style=" text-align: center; vertical-align: middle;">{{ $d->filling ?? '-' }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Achievement ?? '-' }} </td>

                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('FormMiningUpdate', ['id' => $d->id]) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('deletemining', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="7" style="text-align: end; background-color:rgb(244, 244, 244);">Total</th>
                                <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                    {{ round($d->average_achievement, 2) }}%
                                </th>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="7" style="text-align: end; background-color: rgb(244, 244, 244);">Legal Aspect</th>
                                <th style="background-color: rgb(244, 244, 244); text-align: center;">
                                    {{ round($totalAspect , 2) }}%
                                </th>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')

@endsection