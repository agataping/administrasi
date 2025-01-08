@extends('template.main')
@extends('components.style')

@section('title', 'Maening Readines')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Maening Readines</h2>
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
                        <a href="/FormKategori" class="btn btn-custom">Add Kategori</a>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-">
                        <a href="/FormMining" class="btn btn-custom">Add Maening Readines</a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexmining') }}">
                            <label for="year">Filter by Year:</label>
                            <select name="year" id="year" onchange="this.form.submit()">
                                <option value="">All Years</option>
                                @foreach ($years as $availableYear)
                                <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>
                                    {{ $availableYear }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div> 
                </div> 

                <table class="table table-bordered">
                    <thead style="text-align: end; background-color:rgb(56, 181, 73);">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;">Description</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomer Legalitas</th>
                            <th rowspan="2" style="vertical-align: middle;">Status</th>
                            <th colspan="3" style="text-align: center;">JTN</th>
                            <th rowspan="2" style="vertical-align: middle;">Achievement</th>
                            <th rowspan="2" style="vertical-align: middle;">Created By</th>
                            <th rowspan="2" style="vertical-align: middle;">Aksi</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Berlaku s/d</th>
                            <th>Filling / Lokasi dokumen</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($groupedData as $kategori => $items)
                        <tr>
                        <th style="vertical-align: middle; background-color: #f0f0f0;">{{ $loop->iteration }}</th>

                            <th colspan="10" style="text-align: left; background-color: #f0f0f0;">
                                {{ $kategori ?? '-' }}
                            </th>
                        </tr>

                        @foreach ($items as $d)
                        <tr>
                            <th style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Description ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->NomerLegalitas ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->status ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->tanggal ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->berlaku ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->filling ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Achievement ?? '-' }} </td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->created_by ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a href="{{ route('FormMiningUpdate', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                            
                            
                        </tr>
                        @endforeach
                        
                        
                        <tr>
                            <th colspan="9" style="text-align: end; background-color:rgb(244, 244, 244);">Total</th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ round($d->average_achievement, 2) }}%
                            </th>
                        </tr>



                        @endforeach
                        <tr>
                            <th colspan="9" style="text-align: end; background-color: rgb(244, 244, 244);">Total Aspect</th>
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

    
@endsection
@section('scripts')

@endsection
