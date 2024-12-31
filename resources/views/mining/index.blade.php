@extends('template.main')
@extends('components.style')

@section('title', 'Mining Readines')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Mining Readines</h2>
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
                        <a href="/FormKategori" class="btn btn-custom">Add Kategori</a>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-">
                        <a href="/FormMining" class="btn btn-custom">Add Mining Readines</a>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/indexmining') }}">
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
                            <th  rowspan="2" style="vertical-align: middle;">Description </th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomer Legalitas</th>
                            <th rowspan="2" style="vertical-align: middle;">Status</th>
                            <th  colspan="3"style="text-align: center;">JTN</th>
                            <th  rowspan="2"style="vertical-align: middle;">Achievement</th>
                            
                            <th rowspan="2"style="vertical-align: middle;">created_by</th>
                            <th rowspan="2"  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        
                        <tr>
                            <th>Tanggal</th>
                            <th>Berlaku s/d</th>
                            <th>Filling / Lokasi dokumen </th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @php($no = 1)
                            <th  style="text-align: center;">{{ $no}}</th>
                            <th colspan="10"style="text-align: ;">{{ $dataL->first()->KatgoriDescription ?? '-' }}</th>
                            
                        </tr>
                        

                        @foreach($dataL as $d)
                        
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nomor }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Description }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->NomerLegalitas }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->status }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->tanggal }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->berlaku }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->filling }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Achievement }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('FormMiningUpdate', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                            
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="9" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        {{ round($avarageL, 2) }}%
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>
                    

                    <tbody>
                    @php($no = 2)
                            <th  style="text-align: center;">{{ $no}}</th>
                            <th colspan="10"style="text-align: ;">{{ $data->first()->KatgoriDescription ?? '-' }}</th>

                        <tr>
                        @foreach($data as $d)

                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nomor }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Description }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->NomerLegalitas }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->status }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->tanggal }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->berlaku }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->filling }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Achievement }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('FormMiningUpdate', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>

                            
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="9" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        {{ round($avarage, 2) }}%
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>

                    <tbody>
                    @php($no = 3)
                            <th  style="text-align: center;">{{ $no}}</th>
                            <th colspan="10"style="text-align: ;">{{ $dataP->first()->KatgoriDescription ?? '-' }}</th>

                        <tr>
                        @foreach($dataP as $d)

                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nomor }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Description }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->NomerLegalitas }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->status }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->tanggal }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->berlaku }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->filling }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Achievement }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('FormMiningUpdate', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>

                            
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="9" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        {{ round($avarageP, 2) }}%
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>

                    <tbody>
                    @php($no = 4)
                            <th  style="text-align: center;">{{ $no}}</th>
                            <th colspan="10"style="text-align: ;">{{ $dataK->first()->KatgoriDescription ?? '-' }}</th>

                        <tr>
                        @foreach($dataK as $d)

                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->nomor }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->Description }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->NomerLegalitas }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->status }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->tanggal }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->berlaku }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->filling }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->Achievement }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('FormMiningUpdate', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>

                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="9" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        {{ round($avarageK, 2) }}%
                        </th>
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
