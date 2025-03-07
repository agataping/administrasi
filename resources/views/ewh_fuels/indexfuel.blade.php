@extends('template.main')
@extends('components.style')

@section('title', 'fuel')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/indexewhfuel" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">FUEL</h3>
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
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <form action="{{ route('unit') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Description</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('formfuel') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <a href="/indexunit">View Unit Data</a>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexfuel') }}" id="filterForm">
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
                <form method="GET" action="{{ route('indexfuel') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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

                <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                    <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                        <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                            <tr>
                                <th rowspan="" style="vertical-align: middle; text-align: center;">No</th>
                                <th colspan="" style="vertical-align: middle; text-align: center;">Date</th>
                                <th rowspan="" style="vertical-align: middle;  text-align: center;">Description</th>
                                <th colspan="" style="vertical-align: middle; text-align: center;">Plan</th>
                                <th colspan="" style="vertical-align: middle; text-align: center;">File</th>
                                <th colspan="" style="vertical-align: middle; text-align: center;">Actual</th>
                                <th colspan="2" style="vertical-align: middle; text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totals as $total)
                            <tr>
                                <th style="vertical-align: middle; background-color: #f0f0f0;">{{ $loop->iteration }}</th>
                                <th style="vertical-align: middle; background-color: #f0f0f0;"></th>
                                <th colspan="" style="text-align: left; background-color: #f0f0f0;">
                                    {{ $total['units'] }}
                                </th>
                                <td  style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">
                                    {{ number_format($total['total_plan'], 2) }}
                                </td >
                                <th style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">

                                </th>
                                <td  colspan="" style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">
                                    {{ number_format($total['total_actual'], 2) }}
                                </td>

                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('formupadteunit', $total['details'][0]->unit_id) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                <th>
                                </th>


                            </tr>
                            @foreach ($total['details'] as $subIndex => $detail)
                            <tr>
                                <th style="vertical-align: middle;">{{ $loop->parent->iteration }}.{{ (int) $subIndex + 1 }}</th>
                                <td>{{ \Carbon\Carbon::parse($detail->date)->format('d F Y') }}</td>
                                <td>{{ $detail->desc }}</td>
                                <td  style="vertical-align: middle; text-align: end;">{{ number_format((float)$detail->plan, 2) }}</td>
                                <td style="vertical-align: middle; text-align: end;">
                                    @php
                                    $fileExtension = $detail->file_extension;
                                    @endphp
                                    <a href="{{ asset('storage/' . $detail->file) }}" class="text-decoration-none" target="_blank">View File</a>

                                </td>
                                <td  style="vertical-align: middle; text-align: end;">{{ number_format((float)$detail->actual, 2) }}</td>
                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('formupdatefuel', ['id' => $detail->id]) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('deletefuel', $detail->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="10" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>







            </div>
        </div>
    </div>
</div>










@endsection
@section('scripts')
<script>
    document.getElementById('actualBtn').addEventListener('click', function() {
        document.getElementById('actualInput').style.display = 'block';
        document.getElementById('planInput').style.display = 'none';
    });

    document.getElementById('planBtn').addEventListener('click', function() {
        document.getElementById('planInput').style.display = 'block';
        document.getElementById('actualInput').style.display = 'none';
    });
</script>
@endsection