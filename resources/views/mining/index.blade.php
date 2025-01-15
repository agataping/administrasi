@extends('template.main')
@extends('components.style')

@section('title', 'Meaning Readines')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Meaning Readines</h2>
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
                        <form action="{{ route('FormKategori') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Kategori</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('FormMining') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>

                

                <form method="GET" action="{{ route('indexmining') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                    <div >
                        <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}" 
                        style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;"/>
                    </div>
                    
                    <div>
                        <label for="end_date" style="margin-right: 5px; font-weight: bold;">End Date:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}" 
                        style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;"/>
                    </div>
                    
                    <button type="submit" style=" padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                        Filter
                    </button>
                </form>
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