@extends('template.main')
@extends('components.style')

@section('title', 'Stock JT')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Stock JT</h2>
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
                        <a href="/formstockjt" class="btn btn-custom">Add Stock JT</a>
                    </div>
                </div> 



                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle;">No</th>
                            <th rowspan="3" colspan="2" style="vertical-align: middle;">Date</th>
                            <th colspan="4" style="text-align: center;">HAULING</th>
                            <th rowspan="3" style="vertical-align: middle;">created_by</th>
                            <th rowspan="3" style="vertical-align: middle;">Aksi</th>
                        </tr>


                        <tr>
                            <th>Shief I</th>
                            <th>Shief II</th>
                            <th>Tot. Hauling</th>
                            <th>Akumulasi</th>
                            
                        </tr>
                        <tr>
                            <th colspan="4"  style="text-align: center;">stock awal : {{ $data->first()->sotckawal ?? '-' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        
                        </tr>
                    @foreach($data as $d)
                        
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->date}}</td>
                            <td  colspan="2" style="text-align: center; vertical-align: middle;">{{ $d->shifpertama}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->shifkedua}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->totalhauling }}</td>
                            <td>{{ number_format($d->sotckawal + $d->totalhauling, 0) }} </td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by}}</td>


                            
                        </tr>
                        @endforeach
                        


                    </tbody>
                    <tfoot>
                    <tr>
                        <th  colspan="" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total Grand</th>
                        <th  colspan="7"  style="background-color:rgb(244, 244, 244); text-align: strat;"></th>
                        
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
