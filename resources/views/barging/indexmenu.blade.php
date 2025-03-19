@extends('template.main')
@extends('components.style')
@extends('components.script')

@section('title', 'Barging')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexbarging" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Barging</h3>
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


                <div class="row align-items-center">
                    <div class="col-auto">
                        <form action="{{ route('formbarging') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Data</button>
                        </form>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')    
                
                <form method="GET" action="{{ route('indexmenu') }}" id="filterForm">
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
                    <form method="GET" action="{{ route('indexmenu') }}" style="text-transform: uppercase; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 7px;">
                            <label for="category" style="font-weight: bold;">Filter category:</label>
                            <select name="kuota" id="category" class="form-control" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; min-width: 200px;">
                                <option value="">--All Categories --</option>
                                <option value="Ekspor">Ekspor</option>
                                <option value="Domestik">Domestik</option>
                            </select>
                        </div>
                        <div>
                            <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>

                        <div style="display: flex; align-items: center; gap: 7px;">
                            <label for="end_date" style="font-weight: bold;">End Date:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; min-width: 200px;">
                        </div>
                        <button type="submit"
                            style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                            Filter
                        </button>
                    </form>

                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                        style="margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">


                    <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                        <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">

                            <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;">LAYCAN </th>
                                    <th rowspan="2" style="vertical-align: middle;">FILE </th>
                                    <th rowspan="2" style="vertical-align: middle;">KOUTA </th>
                                    <th rowspan="4" style="text-align: center; vertical-align: middle;">NAME OF BARGE</th>
                                    <th rowspan="2" style="vertical-align: middle;">SURVEYOR</th>
                                    <th rowspan="2" style="vertical-align: middle;">PORT OF LOADING</th>
                                    <th rowspan="2" style="vertical-align: middle;">PORT OF DISCHARGING</th>
                                    <th rowspan="4" style="text-align: center;">SHIPPER</th>
                                    <th rowspan="2" style="vertical-align: middle;">INITIAL SURVEY</th>
                                    <th rowspan="2" style="vertical-align: middle;">FINAL SURVEY</th>
                                    <th rowspan="2" style="vertical-align: middle;">QUANTITY (MT)</th>
                                    <th rowspan="2" colspan="2" style="vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <th rowspan="" style="vertical-align: middle; color:black; text-align: center;">{{ $loop->iteration }}</th>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->laycan }}</td>
                                    <td>
                                        @php
                                        $fileExtension = $d->file_extension ?? 'unknown';
                                        @endphp
                                        <a href="{{ asset('storage/' . $d->file) }}" class="text-decoration-none" target="_blank">View File</a>
                                    </td>
                                    <td style="text-align:;">{{$d->kuota}}</td>

                                    <td style="text-align: center; vertical-align: middle;">{{ $d->namebarge }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->surveyor }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->portloading }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->portdishcharging }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->notifyaddres }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($d->initialsurvei)->format('d-m-Y') }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($d->finalsurvey)->format('d-m-Y') }}</td>
                                    <td style="text-align: end; vertical-align: middle;">
                                        {{ number_format(floatval(str_replace(',', '.', str_replace('.', '', $d->quantity))), 2, ',', '.') }}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('updatebarging', ['id' => $d->id]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('deletebarging', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            <tfoot>
                                <tr>
                                    <th colspan="11" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; color:black; ">Total</th>
                                    <th style="background-color:rgb(244, 244, 244); text-align: end; color:black;">
                                        {{ number_format(floatval( $quantity), 2, ',',)}}

                                    </th>
                                    <th colspan="2" style="background-color:rgb(244, 244, 244); text-align: center; color:black;"></th>
                                </tr>
                            </tfoot>
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