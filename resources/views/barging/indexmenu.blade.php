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
                

                <div class="row align-items-center">
                    <div class="col-auto">
                        <form action="{{ route('formbarging') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Barging</button>
                        </form>
                    </div>

                    
                    <!-- Bagian Keterangan atau Nilai -->
                    <div class="col text-end">
                        <div>
                        </div>
                    </div>
                </div>
                


                <form method="GET" action="{{ route('indexmenu') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                    <thead style="background-color:rgb(6, 99, 120)"  class="text-white">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th  rowspan="2" style="vertical-align: middle;">LAYCAN </th>
                            <th  rowspan="2" style="vertical-align: middle;">KOUTA </th>
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
                            <td style="text-align: end;">{{$d->kuota}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->namebarge }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->surveyor }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->portloading }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->portdishcharging }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->notifyaddres }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->initialsurvei)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->finalsurvey)->format('d-m-Y') }}</td>
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
