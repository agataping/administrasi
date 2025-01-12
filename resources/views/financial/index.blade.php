@extends('template.main')
@extends('components.style')

@section('title', 'Neraca')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Neraca</h2>
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
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <form action="{{ route('categoryneraca') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Deskripsi</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('subneraca') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Sub.</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('formfinanc') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>
                <form method="GET" action="{{ route('indexfinancial') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                <table class="table table-bordered" id="myTable">
                    <thead style="background-color: #4CAF50; ">
                        <tr>
                            <th rowspan="" style="vertical-align: middle; text-align: center;">No</th>
                            <th   rowspan="" style="vertical-align: middle;  text-align: center;">Deskripsi</th>
                            <th   colspan=""  style="vertical-align: middle; text-align: center;">Nominal</th>
                            <th   rowspan="" style="vertical-align: middle;  text-align: center;">Tanggal</th>

                            <!-- <th  rowspan="" style="vertical-align: middle; text-align: center;">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedData as $total)
                        {{-- Tampilkan Kategori --}}
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td colspan=""><strong>{{ $total['category_name'] }}</strong></td>
                        </tr>
                        
                        
                        {{-- Tampilkan Sub-Kategori --}}
                        @foreach ($total['sub_categories'] as  $subIndex => $subCategory)
                        <tr>
                            <th style="vertical-align: middle;">{{ $loop->parent ? $loop->parent->iteration : '0' }}.{{ $loop->iteration }}</th>
                            <td><strong>{{ $subCategory['sub_category'] }}</strong></td>
                        </tr>
                        
                        {{-- Tampilkan Detail dari Sub-Kategori --}}
                        
                        @foreach ($subCategory['details'] ?? [] as $detailIndex => $detail)
                        
                        
                        <tr>
                            <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                            <td>{{ $detail->name }}</td>
                            
                            <td style="text-align: right;">{{ number_format($detail->nominal, 2) }}</td>
                            <td style="text-align: center;">{{ \Carbon\Carbon::parse($detail->tanggal)->format('d F Y') }}</td>
                            
                        </tr>
                        @endforeach
                        
                        @endforeach
                        <tr>
                            <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">Total {{ $total['category_name'] }}</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                                {{ number_format($total['total'], 2) }}
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>

                        </tr>
                        <tr>
                            @if ($total['category_name'] == 'CURRENT ASSETS')
                            <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">TOTAL ASSETS :</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">{{ number_format($totalsAssets, 2) }}</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                            @endif
                        </tr>
                        <tr>
                            @if ($total['category_name'] == 'EQUITY')
                            <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">TOTAL LIABILITIES AND EQUITY  :</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">{{ number_format($totalLiabilitas, 2) }}</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                            @endif
                        </tr>
                        @endforeach      
                        <tr>
                            <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">Control :</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">{{ $note }}</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
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
