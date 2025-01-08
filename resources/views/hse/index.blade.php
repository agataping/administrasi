@extends('template.main')
@extends('components.style')

@section('title', 'pembebasanlahan')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">HSE</h2>
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
                        <a href="/formkategorihse" class="btn btn-custom">Add Kategori HSE</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-">
                        <a href="/formhse" class="btn btn-custom">Add HSE</a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexhse') }}">
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
                            <th   style="vertical-align: middle;">Indicator</th>
                            <th  style="text-align: center;">Target</th>
                            <th  style="text-align: center;">Nilai</th>
                            <th  style="vertical-align: middle;">Indicator</th>
                            <th  style="vertical-align: middle;">Keterangan</th>
                            
                            <th  style="vertical-align: middle;">created_by</th>
                            <th  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        

                    </thead>
                    <tbody>
                        @foreach ($data as $kategori => $items)
                        <tr>
                            <!-- Header untuk setiap kategori -->
                            <th colspan="8" style="text-align: left; background-color: #f0f0f0;">
                                {{ $kategori ?? '-' }}
                            </th>
                        </tr>
                        @foreach ($items as $d)
                        <tr>
                            <th style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nameindikator ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->target ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nilai ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->indikator ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->keterangan ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->created_by ?? '-' }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a href="{{ route('formupdatehse', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                            <th colspan="7" style="vertical-align: middle; background-color: rgb(244, 244, 244); text-align: end;">Total Nilai</th>
                        </tr>
                    </tbody>                    
                </table>                        
                
                
                

                    
                    
                    
                    
                    
                    
                    
                    
            </div>
        </div>
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
