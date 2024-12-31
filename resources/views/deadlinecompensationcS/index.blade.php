@extends('template.main')
@section('title', 'CS Deadline Compentation')
@extends('components.style')

@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">CS Deadline Compentation</h2>
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
                        <a href="/formDeadlineCs" class="btn btn-custom">Add Deadline Compentation</a>
                    </div>
                </div>                 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/') }}">
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
                            <th  rowspan="" style="vertical-align: middle;">Keterangan </th>
                            <th rowspan="" style="text-align: center; vertical-align: middle;">Masa Sewa</th>
                            <th rowspan="" style="vertical-align: middle;">Nominal sewa</th>
                            <th rowspan="" style="vertical-align: middle;">Progres Tahun</th>
                            <th rowspan="" style="vertical-align: middle;">Jatuh Tempo</th>


                            
                            <th rowspan=""style="vertical-align: middle;">created_by</th>
                            <th rowspan=""  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        

                        @foreach($data as $d)
                        
                        <tr>
                            
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Keterangan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->MasaSewa }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Nominalsewa }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ProgresTahun }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->JatuhTempo }}</td>


                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formupdateDeadlineCs', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>


                            
                            
                        </tr>
                        @endforeach
                        </tr>
                    </tfoot>
                </tbody>

                </div>
            </div>
            
      
        

        
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
