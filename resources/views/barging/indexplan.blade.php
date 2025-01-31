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
                        <form action="{{ route('formplan') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Plan</button>
                        </form>
                    </div>
                </div>
                
                <form method="GET" action="{{ route('indexPlan') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                            <th rowspan="2"style="vertical-align: middle;">Tanggal</th>
                            <th rowspan="2"  style="vertical-align: middle;">Nominal</th>
                            <th rowspan="2"  style="vertical-align: middle;">Kuota</th>
                            <th rowspan="2" colspan="2"  style="vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</td>
                            <td style="text-align: end;">{{ number_format($d->nominal),2}} </td>
                            <td style="text-align: end;">{{$d->kuota}}</td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdateplan', ['id' => $d->id]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deleteplanbarging', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th colspan="10" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"></th>
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
