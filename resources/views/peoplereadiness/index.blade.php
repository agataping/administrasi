@extends('template.main')
@extends('components.style')

@section('title', 'People Readiness')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">People Readiness</h2>
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
                
                <form method="GET" action="{{ route('indexPeople') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle;">Posisi</th>
                            <th rowspan="2" style="vertical-align: middle;">Fullfillment </th>
                            <th colspan="4" style="text-align: center;">Training Mandatory</th>
                            <th rowspan="2" style="vertical-align: middle;">% Quality</th>
                            <th rowspan="2" style="vertical-align: middle;">% Quantity (Fullfillment)</th>
                            <th rowspan="2" style="vertical-align: middle;">created_by</th>
                            <th rowspan="2" style="vertical-align: middle;">Aksi</th>
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
                            <td rowspan="2" style="text-align: center; vertical-align: middle;">{{ $d->posisi }}</td>
                            <td >Plan</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Fullfillment_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->pou_pou_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Leadership_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->HSE_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Improvement_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $d->Quality_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $d->Quantity_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="2">
                                <a href="{{ route('formupdate', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
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
                        <tr>
                        </tr>
                        @endforeach
                        </tbody>

                </table>                        
                
                        
                            
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th  colspan="4" style="vertical-align: middle; background-color:rgb(47, 136, 59); text-align: center; ">PEOPLE READINESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tr>
                        <th  rowspan="7" style="text-align: center; background-color:rgb(244, 244, 244);  vertical-align: middle;">Quality Aspect</th>
                        <tr>
                    @foreach($data as $d)
                    <tr>
                        <td  style=" vertical-align: middle;">{{ $d->posisi }}</td>
                        <td style="text-align: center; vertical-align: middle;">{{ $d->Quality_plan }}</td>
                        @if($loop->first) 
                        <td rowspan="{{ $data->count() }}" style="text-align: center; vertical-align: middle; font-weight: bold;  background-color:rgb(244, 244, 244);">
                            {{ number_format($averageQuality, 1, ',', '.') }}%
                        </td>
                        @endif
                    </tr>
                    @endforeach
            

                        <tr>
                            <th rowspan="7" style="text-align: center; background-color:rgb(244, 244, 244); vertical-align: middle;">Quantity Aspect</th>
                        </tr>
                        @foreach($data as $d)
                        <tr>
                            <td style="">{{ $d->posisi }}</td>
                            <td style="text-align: center;">{{ $d->Quantity_plan }}</td>
                        @if($loop->first) 
                            <td rowspan="{{ $data->count() }}" style="text-align: center; vertical-align: middle; font-weight: bold; background-color:rgb(244, 244, 244);">
                                {{ number_format($averageQuantity, 1, ',', '.') }}%                        
                            </td>
                        @endif
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th  colspan="3" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        {{ number_format($tot, 1, ',', '.') }}%</th>
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
