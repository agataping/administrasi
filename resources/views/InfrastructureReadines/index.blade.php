@extends('template.main')
@extends('components.style')

@section('title', 'infrastructure Readiness')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">infrastructure Readiness</h2>
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
                        <a href="/fromadd" class="btn btn-custom">Add InfrastructureReadines</a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexInfrastructureReadiness') }}">
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
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2"  style="vertical-align: middle;">Project Name </th>
                            <th colspan="3" style="text-align: center;">Physical Aspect</th>
                            <th colspan="3" style="text-align: center;">Quality Aspectt</th>
                            <th rowspan="2" style="vertical-align: middle;">Total</th>
                            <th rowspan="2" style="vertical-align: middle;">created_by</th>
                            <th rowspan="2" style="vertical-align: middle;">Aksi</th>
                        </tr>
                        
                        
                        <tr>
                            <th>Preparation</th>
                            <th>Construction</th>
                            <th>Commissiong </th>
                            
                            <th>Kelayakan Bangunan</th>
                            <th>Kelengakapan</th>
                            <th>Kebersihan </th>
                            
                        </tr>
                        
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ProjectName }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Preparation }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Construction }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Commissiong }}</td>
                            
                            <td style="text-align: center; vertical-align: middle;">{{ $d->KelayakanBangunan }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Kelengakapan }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Kebersihan }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->total }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formupdateInfrastructureReadiness', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>

                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="10" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        {{ round($averagePerformance, 2) }}%</th>
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
