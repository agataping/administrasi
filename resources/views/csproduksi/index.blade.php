@extends('template.main')
@extends('components.style')

@section('title', 'CS Produksi')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">CS Produksi</h2>
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
                        <a href="/formMProduksi" class="btn btn-custom">Add Monthly Production</a>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexmproduction') }}">
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
                    <thead style="background-color:rgb(6, 99, 120)"  class="text-white">
                        <tr>
                            <th rowspan="3" style="vertical-align: middle;">No</th>
                            <th  rowspan="3" style="vertical-align: middle; text-align: center;">Date </th>
                            <th colspan="6" style="text-align: center; vertical-align: middle;">PLAN</th>
                            <th colspan="3" style="vertical-align: middle;">ACTUAL OB (BCM) VOLUME</th>
                            <th colspan="3" style="vertical-align: middle;">COAL GETTING (TON)</th>
                            <th rowspan="3" style="vertical-align: middle;">BARGING</th>



                            
                            <th rowspan="3"style="vertical-align: middle;">created_by</th>
                            <th rowspan="3"  style="vertical-align: middle;">Aksi</th>
                        </tr>

                        <tr>

                            <th colspan="2" style="text-align: center; vertical-align: middle;">DAILY</th>
                            <th colspan="2" style="text-align: center; vertical-align: middle;">MTD</th>
                            <th colspan="2" style="text-align: center; vertical-align: middle;">YTD</th>

                            <th rowspan="3" style="text-align: center; vertical-align: middle;">DAILY</th>
                            <th rowspan="3" style="text-align: center; vertical-align: middle;">MTD</th>
                            <th rowspan="3" style="text-align: center; vertical-align: middle;">YTD</th>

                            <th rowspan="3" style="text-align: center; vertical-align: middle;">DAILY</th>
                            <th rowspan="3" style="text-align: center; vertical-align: middle;">MTD</th>
                            <th rowspan="3" style="text-align: center; vertical-align: middle;">YTD</th>

                        </tr>

                        <tr>
                            <th>OB (BCM)</th>
                            <th>COAL (TON)</th>
                            <th>OB (BCM)</th>
                            <th>COAL (TON)</th>
                            <th>OB (BCM)</th>
                            <th>COAL (TON)</th>
                        </tr>
                        
                    </thead>

                    <tbody>
                        

                        @foreach($data as $d)
                        
                        <tr>
                            
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->date }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->dbcm_ob }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->dcoal_ton }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->mbcm_ob }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->mcoal_ton }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ybcm_ob }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ycoal_ton }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->dactual }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->mactual }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->yactual }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->dcoal }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->mcoal }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ycoal }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->bargings }}</td>


                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formUpdateMProduksi', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>


                            
                            
                        </tr>
                        @endforeach

                        <tr>
                            <th  colspan="2" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; " >Total</th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['dbcm_ob'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['dcoal_ton'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['mbcm_ob'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['mcoal_ton'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['ybcm_ob'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['ycoal_ton'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['dactual'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['mactual'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['yactual'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['dcoal'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['mcoal'] }}
                            </th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ $totals['ycoal'] }}
                            </th>
                            <th colspan="3" style="background-color:rgb(244, 244, 244); text-align: start;">
                                {{ $totals['bargings'] }}
                            </th>
                        </tr>
                        
                        
                    </tfoot>
                </tbody>
                
                
                    


                </table>                        









                </div>
            </div>
            
      
        

        
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
