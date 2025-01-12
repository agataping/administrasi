@extends('template.main')
@extends('components.style')

@section('title', 'pembebasanlahan')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Pembebasan Lahan</h2>
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
                        <a href="/formlahan" class="btn btn-custom">Add Pembebasan Lahan</a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexPembebasanLahan') }}">
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
                            <th   style="vertical-align: middle;">Nama Pemilik Lahan </th>
                            <th  style="text-align: center;">Luas Lahan</th>
                            <th  style="text-align: center;">Kebutuhan Lahan Berdasarkan Boundary</th>
                            <th  style="vertical-align: middle;">Progress</th>
                            <th  style="vertical-align: middle;">Status</th>
                            <th  style="vertical-align: middle;">Achievement</th>
                            <th  style="vertical-align: middle;">Target Selesai</th>
                            
                            <th  style="vertical-align: middle;">created_by</th>
                            <th  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        

                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->NamaPemilik }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->LuasLahan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->KebutuhanLahan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Progress }}</td>
                            
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Status }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Achievement }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->targetselesai }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formUpdatelahan', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th colspan="4" style="background-color:rgb(244, 244, 244); text-align: start;">
                        {{ round($averageAchievement , 2) }}%

                        </th>
                    </tr>
                    </tfoot>
                    </tbody>
                    
                </table>                        
                
                <div class="pagination justify-content-center">
                    {{ $data->links() }}
                </div>
                

                    
                    
                    
                    
                    
                    
                    
                    
            </div>
        </div>
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
