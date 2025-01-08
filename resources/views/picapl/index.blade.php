@extends('template.main')
@extends('components.style')

@section('title', 'Pica Pembebasan Lahan ')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Pica Pembebasan Lahan </h2>
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
                        <a href="/formpicapl" class="btn btn-custom">Add Pica </a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/picapl') }}">
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
                                <a href="{{ route('formupdatepicapl', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
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
