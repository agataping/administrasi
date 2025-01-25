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
                
                <form method="GET" action="{{ route('indexInfrastructureReadiness') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                    <thead style="background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2"  style="vertical-align: middle;">Project Name </th>
                            <th colspan="3" style="text-align: center;">Physical Aspect</th>
                            <th colspan="3" style="text-align: center;">Quality Aspectt</th>
                            <th rowspan="2" style="vertical-align: middle;">Total</th>
                            <th rowspan="2" style="vertical-align: middle;">Notes</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle;">Action</th>
                        </tr>
                        <tr>
                            <th>Preparation</th>
                            <th>Construction</th>
                            <th>Commissiong </th>
                            <th>Building Feasibility</th>
                            <th>Completeness</th>
                            <th>Cleanliness </th>
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
                            <td rowspan="" style="vertical-align: middle; padding: 5px;">
                                <div style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                    {!! nl2br(e($d->note)) !!}
                                </div>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdateInfrastructureReadiness', ['id' => $d->id]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deleteinfrastruktur', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <th  colspan="11" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
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
