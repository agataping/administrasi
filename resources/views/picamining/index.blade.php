@extends('template.main')
@extends('components.style')

@section('title', 'Pica Mining ')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Pica Mining </h2>
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
                        <a href="/formpicamining" class="btn btn-custom">Add Pica People </a>
                    </div>
                </div> 
                
                <form method="GET" action="{{ route('picamining') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                            <th  style="vertical-align: middle;">No</th>
                            <th   style="vertical-align: middle;">Problem</th>
                            <th  style="text-align: center;">Cause</th>
                            <th  style="text-align: center;">Corective Action</th>
                            <th  style="vertical-align: middle;">Due Date</th>
                            <th  style="vertical-align: middle;">PIC</th>
                            <th  style="vertical-align: middle;">Status</th>
                            <th  style="vertical-align: middle;">Remerks</th>
                            
                            <th  style="vertical-align: middle;">created_by</th>
                            <th  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        

                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->problem }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->cause }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->corectiveaction }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->duedate }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->pic }}</td>
                            
                            <td style="text-align: center; vertical-align: middle;">{{ $d->status }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->remerks }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formupdatepicamining', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                            
                        </tr>
                        
                        @endforeach

                    </tbody>
                    
                </table>                        
                
                

                    
                    
                    
                    
                    
                    
                    
                    
            </div>
        </div>
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
