@extends('template.main')
@extends('components.style')

@section('title', 'Stock Jetty')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
            <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
            <a href="{{ route('dashboardstockjt') }}" class="text-decoration-none" style="color: black;">
                <h2 class="mb-3">Stock Jetty</h2>
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

                
        
                <div class="row">
                    <div class="col-sm-">
                        <a href="/formstockjt" class="btn btn-custom">Add Stock Jetty</a>
                    </div>
                </div> 
                
                @if(auth()->user()->role === 'admin')    

                <form method="GET" action="{{ route('stockjt') }}" id="filterForm">
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
                <form method="GET" action="{{ route('stockjt') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                <div class="form-group ">
                    <input 
                    type="text" 
                    id="myInput" 
                    onkeyup="filterByLocation()" 
                    placeholder="Search for location..." 
                    title="Type in a location"
                    style="width: 40%; padding: 10px; font-size: 16px;"
                    >
                </div>
                


                <table class="table table-bordered" id="myTable">
                    <thead style="background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;"
                    >
                        <tr>
                            <th rowspan="3" style="vertical-align: middle;">No</th>
                            <th rowspan="3" colspan="" style="vertical-align: middle;">Date</th>
                            <th rowspan="3" style="vertical-align: middle;">Plan</th>
                            <th rowspan="3" style="vertical-align: middle;">File</th>
                            <th colspan="4" style="text-align: center;">HAULING</th>
                            <th rowspan="3" style="vertical-align: middle;">Stock Out</th>
                            <th rowspan="3" style="vertical-align: middle;">Ending Stock</th>
                            <th rowspan="3" style="vertical-align: middle;">Location</th>
                            
                            <th rowspan="3" colspan="3"style="vertical-align: middle;">Action</th>
                        </tr>


                        <tr>
                            <th>Shift I</th>
                            <th>Shift II</th>
                            <th>Total Hauling</th>
                            <th>Accumulation</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: start;">
                                Opening stock : 
                                @if ($data->isNotEmpty() && $data->first()->date)
                                {{ \Carbon\Carbon::parse($data->first()->date)->format('d-m-Y' ?? 0) }}
                                @else
                                No data available
                                @endif
                                
                            </th>
                            
                            <th colspan="1" style="text-align: end;">
                            {{ number_format($data->first()->sotckawal ?? 0,  2, ',', '.') }}
                            </th>
                            
                        </tr>
                        
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                            <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($d->date)->format('d-m-Y' ?? 0) }}</td>
                            <td style="text-align: end; vertical-align: middle;">{{ number_format($d->plan,  2, ',', '.') }}
    
                            </td>

                            <td>
                                @php
                                $fileExtension = $d->file_extension ?? 'unknown';
                                @endphp
                                <a href="{{ asset('storage/' . $d->file) }}" class="text-decoration-none" target="_blank">View File</a>
                            </td>
                            <td  colspan="" style="text-align: center; vertical-align: middle;">{{ $d->shifpertama}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->shifkedua}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->totalhauling }}</td>
                            <td style="text-align: end; vertical-align: middle;">{{ number_format($d->akumulasi_stock,  3, ',', '.') }} </td>
                            <td style="text-align: end; vertical-align: middle;">{{ number_format($d->stockout,  2, ',', '.') }} </td>
                            <td style="text-align: end; vertical-align: middle;">{{ number_format($d->stock_akhir, 2, ',', '.') }}
                            </td>
                                 
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->lokasi}}</td>

                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdatestockjt', ['id' => $d->id]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                                    <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deletestockjt', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)" >
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
                        <th  colspan="2"  style="background-color:rgb(244, 244, 244); text-align: end;">Grand Total</th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: center;">
                            {{ number_format($planNominal,  2, ',', '.') }}
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: center;">
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: center;">
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: center;">
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: center;">
                            {{ number_format($totalHauling,  3, ',', '.') }}
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: end;">
                            {{ number_format($grandTotal,  3, ',', '.') }}
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: end;">
                        </th>
                        <th  colspan=""  style="background-color:rgb(244, 244, 244); text-align: end;">
                            {{ number_format($grandTotalstockakhir,  3, ',', '.') }}
                        </th>
                        
                    </tr>

                    </tfoot>
                </table>                    
                






            </div>
        </div>
    </div>
</div>
        
        
        


<!-- perhitungan stock awal perbaikan -->



@endsection
@section('scripts')
<script>


</script>
@endsection
