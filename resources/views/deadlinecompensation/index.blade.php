@extends('template.main')
@extends('components.style')
@extends('components.script')
@section('title', 'Deadline Compensation')
@section('content')



<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-">Deadline Compensation</h3>
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


                @endif
                <div class="row">
                    <div class="col-sm-">
                        <a href="/formaddMR" class="btn btn-custom">Add Deadline Compensation</a>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexdeadline') }}" id="filterForm">
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
                    <form method="GET" action="{{ route('indexdeadline') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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

                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                        style="margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">


                    <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                        <thead style="background-color:rgba(9, 220, 37, 0.75); text-align: center;">
                            <tr>
                                <th rowspan="" style="vertical-align: middle;">No</th>
                                <th rowspan="" style="vertical-align: middle;">Description </th>
                                <th colspan="" style="text-align: center;">Lease Duration</th>
                                <th colspan="" style="text-align: center;">Amount</th>
                                <th rowspan="" style="vertical-align: middle;">Annual Progress</th>
                                <th rowspan="" style="vertical-align: middle;">Due Date</th>
                                <th colspan="2" style="vertical-align: middle;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                            <tr>
                                <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Keterangan }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->MasaSewa }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->Nominalsewa }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->ProgresTahun }}</td>
                                <td style="text-align: center; vertical-align: middle;">{{ $d->JatuhTempo }}</td>
                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('formupdateDeadlineCompen', ['id' => $d->id]) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                <td style="text-align: center; vertical-align: middle;" rowspan="">
                                    <form action="{{ route('deletedeadline', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
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

@endsection