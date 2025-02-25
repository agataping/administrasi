@extends('template.main')
@extends('components.style')
@section('title', 'Kategori HPP')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
            <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">HPP</h2>
                
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
                        <a href="/hpp" class="btn btn-custom">Add Hpp</a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexhpp') }}">
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
                
                        <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                    <thead>
                        
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Uraian</th>
                            <th colspan="2" style="text-align: center;">Tahun {{$year ?? 'Semua Tahun' }}</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">created_by</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Aksi</th>

                        </tr>
                        <tr>
                        <th style="text-align: center;">Rencana</th>
                        <th style="text-align: center;">Realisasi</th>
                        </tr>


                        <tbody>
                        <tr>
                            <th></th>
                            <th colspan="5"style="text-align: start ;">{{ $categories->first()->category ?? '-' }}:</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th colspan=""style="text-align: ;">A. {{ $categories->first()->subcategory ?? '-' }}</th>
                        </tr>

                            @foreach ($categories as $d)
                            <!-- Tampilkan item -->
                            <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>

                                <td class="item">{{ $d->item }}</td>
                                <td>{{ number_format($d->rencana, 0, ',', '.') }}</td>
                                <td>{{ number_format($d->realisasi, 0, ',', '.') }}</td>
                                <td class="item">{{ $d->created_by }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                        
                        
                    </thead>
                </table>

                
            </div>
            
        </div>
    </div>
</div>
    

@endsection

@section('scripts')
@endsection

