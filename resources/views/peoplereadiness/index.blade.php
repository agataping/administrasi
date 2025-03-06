@extends('template.main')
@extends('components.style')

@section('title', 'People Readiness')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">People Readiness</h3>
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
                        <a href="/formPR" class="btn btn-custom">Add People Readiness</a>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexPeople') }}" id="filterForm">
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
                <form method="GET" action="{{ route('indexPeople') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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




                <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                    <thead style="background-color:rgba(9, 220, 37, 0.75); text-align: center;">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;">Data Date</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle;">Position</th>
                            <th rowspan="2" style="vertical-align: middle;">Fullfillment </th>
                            <th colspan="4" style="text-align: center;">Mandatory Training</th>
                            <th rowspan="2" style="vertical-align: middle;">% Quality</th>
                            <th rowspan="2" style="vertical-align: middle;">% Quantity (Fullfillment)</th>
                            <th rowspan="2" style="vertical-align: middle;">Notes</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle;">Action</th>
                        </tr>


                        <tr>
                            <th>POP/POU</th>
                            <th>HSE</th>
                            <th>Leadership</th>
                            <th>Improvement</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)

                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td rowspan="2" style="text-align: center; vertical-align: middle;">
                                {{ \Carbon\Carbon::parse($d->tanggal)->format('d F Y') }}
                            </td>

                            <td rowspan="2" style="text-align: center; vertical-align: middle;">{{ $d->posisi }}</td>
                            <td>Plan</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Fullfillment_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->pou_pou_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Leadership_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->HSE_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Improvement_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $d->Quality_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $d->Quantity_plan }}</td>
                            <td rowspan="2" style="vertical-align: middle; padding: 5px;">
                                <div style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                    {!! nl2br(e($d->note)) !!}
                                </div>
                            </td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">
                                <form action="{{ route('formupdate', ['id' => $d->id]) }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">
                                <form action="{{ route('deletepeoplereadines', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Actual</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Fullfillment_actual }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->pou_pou_actual }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Leadership_actual }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->HSE_actual }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Improvement_actual }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="13" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"></th>
                        </tr>
                    </tfoot>


                </table>
                <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                    <thead>
                        <tr>
                            <th colspan="3" style="vertical-align: middle; background-color:rgba(9, 220, 37, 0.75); text-align: center;">PEOPLE READINESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Quality Aspect -->
                        <tr>
                            <th colspan="3" style="text-align: center;  vertical-align: middle;">Quality Aspect</th>
                        </tr>
                        @foreach($data as $d)
                        <tr>
                            <td style="vertical-align: middle;">{{ $d->posisi }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Quality_plan }}</td>
                            @if($loop->first)
                            <td rowspan="{{ $data->count() }}" style="text-align: center; vertical-align: middle; font-weight: bold; ">
                                {{ number_format($averageQuality, 1, ',', '.') }}%
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        <!-- Quantity Aspect -->
                        <tr>
                            <th colspan="3" style="text-align: center;  vertical-align: middle;">Quantity Aspect</th>
                        </tr>
                        @foreach($data as $d)
                        <tr>
                            <td style="">{{ $d->posisi }}</td>
                            <td style="text-align: center;">{{ $d->Quantity_plan }}</td>
                            @if($loop->first)
                            <td rowspan="{{ $data->count() }}" style="text-align: center; vertical-align: middle; font-weight: bold;">
                                {{ number_format($averageQuantity, 1, ',', '.') }}%
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">Total</th>
                            <th style=" background-color:rgb(244, 244, 244); text-align: center;">
                                {{ number_format($tot, 1, ',', '.') }}%
                            </th>
                        </tr>
                    </tfoot>
                </table>




            </div>
        </div>
    </div>
</div>










@endsection
@section('scripts')

@endsection