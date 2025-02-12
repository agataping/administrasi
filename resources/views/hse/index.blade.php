@extends('template.main')
@extends('components.style')

@section('title', 'pembebasanlahan')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">HSE</h2>
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
                        <form action="{{ route('formkategorihse') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Category HSE</button>
                        </form>
                    </div>
                    @if(auth()->user()->role === 'admin')    

                    <div class="col-auto">
                        <form action="{{ route('formhse') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add HSE.</button>
                        </form>
                    </div>
                </div>
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
                @endif
                <div class="" style="overflow-x:auto;">
                <form method="GET" action="{{ route('indexhse') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                <div class="table-responsive" style="max-height: 400px; overflow-y:auto;"> 
                <table class="table table-bordered">
                <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">                        <tr>
                            <th  style="vertical-align: middle;">No</th>
                            <th   style="vertical-align: middle;">Indicator</th>
                            <th  style="text-align: center;">Target</th>
                            <th  style="text-align: center;">Value</th>
                            <th  style="vertical-align: middle;">Indicator</th>
                            <th  style="vertical-align: middle;">Description</th>
                            <th colspan="2" style="vertical-align: middle;">Action</th>
                        </tr>
                        </thead>
                    <tbody>
                        @foreach ($data as $kategori => $items)
                        <tr>
                            <!-- Header untuk setiap kategori -->
                            <th colspan="8" style="text-align: left; background-color: #f0f0f0;">
                                {{ $kategori ?? '-' }}
                            </th>
                        </tr>
                        @foreach ($items as $d)
                        <tr>
                            <th style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nameindikator ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->target ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nilai ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->indikator ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->keterangan ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdatehse', ['id' => $d->id]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deletehse', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)" >
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

@endsection
