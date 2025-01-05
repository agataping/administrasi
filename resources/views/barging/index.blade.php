@extends('template.main')
@extends('components.style')

@section('title', 'Barging')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3"></h2>
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
                        <a href="/formbarging" class="btn btn-custom">Add Barging</a>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexbarging') }}">
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
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th  rowspan="2" style="vertical-align: middle;">LAYCAN </th>
                            <th rowspan="4" style="text-align: center; vertical-align: middle;">NAME OF BARGE</th>
                            <th rowspan="2" style="vertical-align: middle;">SURVEYOR</th>
                            <th rowspan="2" style="vertical-align: middle;">PORT OF LOADING</th>
                            <th rowspan="2" style="vertical-align: middle;">PORT OF DISCHARGING</th>
                            <th  rowspan="4"style="text-align: center;">NOTIFY ADDRESS</th>
                            <th  rowspan="2"style="vertical-align: middle;">INITIAL SURVEY</th>
                            <th  rowspan="2"style="vertical-align: middle;">FINAL SURVEY</th>
                            <th  rowspan="2"style="vertical-align: middle;">QUANTITY (MT)</th>


                            
                            <th rowspan="2"style="vertical-align: middle;">created_by</th>
                            <th rowspan="2"  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        

                        @foreach($data as $d)
                        
                        <tr>
                            
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->laycan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->namebarge }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->surveyor }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->portloading }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->portdishcharging }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->notifyaddres }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->initialsurvei }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->finalsurvey }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->quantity }}</td>


                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('updatebarging', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>


                            
                            
                        </tr>
                        @endforeach

                        <tr>
                            <th  colspan="11" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; " >Total</th>
                            <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                {{ number_format($quantity, 0, ',', '.') }}                        
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
