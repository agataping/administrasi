@extends('template.main')
@extends('components.style')

@section('title', 'Land Acquissition')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">Land Acquissition</h3>
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
                <div class="row">
                    <div class="col-sm-">
                        <a href="/formlahan" class="btn btn-custom">Add data</a>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexPembebasanLahan') }}" id="filterForm">
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
                <form method="GET" action="{{ route('indexPembebasanLahan') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                                <th style="vertical-align: middle;">No</th>
                                <th style="vertical-align: middle;">Land Owner Name</th>
                                <th style="text-align: center;">Land Area</th>
                                <th style="text-align: center;">Land Requirement Based on Boundary</th>
                                <th style="vertical-align: middle;">Progress</th>
                                <th style="vertical-align: middle;">Status</th>
                                <th style="vertical-align: middle;">Achievement</th>
                                <th style="vertical-align: middle;">Target Completion</th>
                                <th colspan="2" style="vertical-align: middle;">Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach($data as $d)
                            <tr>
                                <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->NamaPemilik }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->LuasLahan }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->KebutuhanLahan }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Progress }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Status }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Achievement }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->targetselesai }}</td>


                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('formUpdatelahan', ['id' => $d->id]) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('deletepembebasanlahan', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                                <th colspan="4" style="background-color:rgb(244, 244, 244); text-align: start;">
                                    {{ round($averageAchievement , 2) }}%

                                </th>
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