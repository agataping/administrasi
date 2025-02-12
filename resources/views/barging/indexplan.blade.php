@extends('template.main')
@extends('components.style')

@section('title', 'Barging')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <a href="/indexbarging" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Plan Barging</h2>
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
                        <form action="{{ route('formplan') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Plan</button>
                        </form>
                    </div>
                </div>
                                @if(auth()->user()->role === 'admin')    

                <form method="GET" action="{{ route('indexPlan') }}" id="filterForm">
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
                <form method="GET" action="{{ route('indexPlan') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2"style="vertical-align: middle;">Date</th>
                            <th rowspan="2"  style="vertical-align: middle;">Nominal</th>
                            <th rowspan="2"  style="vertical-align: middle;">Kuota</th>
                            <th rowspan="2"  style="vertical-align: middle;">file</th>
                            <th rowspan="2" colspan="3"  style="vertical-align: middle;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</td>
                            <td style="text-align: end; vertical-align: middle;" >
                            {{ number_format(floatval(str_replace(',', '.', str_replace('.', '', $d->nominal))), 2, ',', '.') }}
                            </td>
                            <td style="text-align: end;">{{$d->kuota}}</td>
                            <td>
                                @php
                                $fileExtension = $d->file_extension ?? 'unknown';
                                @endphp
                                <a href="{{ asset('storage/' . $d->file) }}" class="text-decoration-none" target="_blank">View File</a>
                            </td> 
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdateplan', ['id' => $d->id]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                       
                                <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                
                                <form action="{{ route('deleteplanbarging', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)" >
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
                            <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">Total</th>
                            <th style="background-color:rgb(244, 244, 244); text-align: end;">
                            {{ number_format(floatval($planNominal), 2,',', )}}
                        </th>
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
