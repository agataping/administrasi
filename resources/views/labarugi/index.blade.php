@extends('template.main')
@extends('components.style')

@section('title', 'Profit & Loss')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Profit & Loss</h2>
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
                        <form action="{{ route('categorylabarugi') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Deskripsi</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('sublr') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Sub.</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('formlabarugi') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>
                <div class="" style="overflow-x:auto;">
                <form method="GET" action="{{ route('labarugi') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                    <thead style="background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;"
                    >
                    <tr>
                        <th rowspan="" style="vertical-align: middle; text-align: center;">No</th>
                        <th   rowspan="" style="vertical-align: middle;  text-align: center;">Description</th>
                        <th   colspan=""  style="vertical-align: middle; text-align: center;">Plan</th>
                        <th   colspan=""  style="vertical-align: middle; text-align: center;">Vertical Analysis</th>
                        <th  colspan=""style="vertical-align: middle; text-align: center;">Actual</th>
                        <th   colspan=""  style="vertical-align: middle; text-align: center;">Vertical Analysis</th>
                        <th   colspan=""  style="vertical-align: middle; text-align: center;">Deviation</th>
                        <th   colspan=""  style="vertical-align: middle; text-align: center;">Percentage</th>
                        <th  colspan=""style="vertical-align: middle; text-align: center;">Date</th>
                        <th  colspan="2" style="vertical-align: middle; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totals as $jenisName => $jenis)
                    @foreach ($jenis['sub_categories'] as $kategoriName => $total)
                    {{-- Tampilkan Kategori                     {{dd($total['sub_categories'])}}
                    --}}
                    <tr>
                        <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                        <td colspan=""><strong>{{$kategoriName}}</strong></td>
                        <td style="text-align: end;"><strong>{{ number_format($total['total_plan'], 2) }}</strong></td>
                        <td style="text-align: end;"><strong>{{ number_format($total['vertikal'], 2) }} %</strong></td>
                        <td style="text-align: end;"><strong>{{ number_format($total['total_actual'], 2) }}</strong></td>
                        <td style="text-align: end;"><strong>{{ number_format($total['vertikals'], 2) }} %</strong></td>
                        <td style="text-align: end;"><strong>{{ number_format($total['deviation'], 2) }}</strong></td>
                        <td style="text-align: end;"><strong>{{ number_format($total['vertikals'], 2) }} %</strong></td>
                        <td></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="{{ route('formupdatecategorylr', ['category_id' => $total['category_id']]) }}" class="btn btn-primary">Edit</a>
                        </td>
                        <td></td>
                    </tr>
                    {{-- Tampilkan Sub-Kategori --}}
                    @foreach ($total['sub_categories'] as  $subIndex => $subCategory)
                    <th style="vertical-align: middle;">{{ $loop->parent ? $loop->parent->iteration : '0' }}.{{ $loop->iteration }}</th>
                    <td style="vertical-align: middle;"><strong>{{ $subCategory['name_sub'] }}</strong></td>
                    <td style="text-align: end;"><strong>{{ number_format($subCategory['total_plan'], 2) }}</strong></td>
                    <td></td>
                    <td style="text-align: end;"><strong>{{ number_format($subCategory['total_actual'], 2) }}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan=""style="text-align: center; vertical-align: middle;">
                        <a href="{{ route('formupdatesublr', $subCategory['details'][0]->sub_id) }}" class="btn btn-primary">Edit</a>
                        </td>    
                    <td></td> 
                </tr>
                {{-- Tampilkan Detail dari Sub-Kategori --}}
                @foreach ($subCategory['details'] as $detailIndex => $detail)
                <tr>
                    <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                    <td>{{ $detail->desc }}</td>
                    <td style=" text-align: end;">{{ number_format($detail->nominalplan, 2) }}</td>
                    <td></td>
                    <td style=" text-align: end;">{{ number_format($detail->nominalactual, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d-m-Y') }}</td>
                    <td style="text-align: center; vertical-align: middle;"  rowspan="">
                        <form action="{{ route('formupdatelabarugi', ['id' => $detail->detail_id]) }}">
                            <button type="submit"  class="btn btn-primary ">Edit</button>
                        </form>
                    </td>
                    <td style="text-align: center; vertical-align: middle;"  rowspan="">
                        <form action="{{ route('deletedetaillr', $detail->detail_id) }}" method="POST" onsubmit="return confirmDelete(event)" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                
                @endforeach
                @endforeach
                @endforeach
                <tr>



                    <th colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;">{{ $jenisName}} </th>

                    @if ($jenis['jenis_name'] == 'Gross Profit')
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalplanlr, 2) }}
                    </th>

                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalvertikal, 2) }}%
                    </th>

                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalactuallr, 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalvertikals, 2) }}%
                    </th>

                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($deviasilr, 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($persenlr, 2) }}%
                    </th>

                    <th colspan="5" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                    @elseif($jenis['jenis_name'] == 'Operating Profit')
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalplanlp, 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($verticallp, 2) }}%
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalactualOp, 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($verticalsp, 2) }}%
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($deviasiop, 2) }}%
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($persenop, 2) }}%
                    </th>
                    <th colspan="5" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                    @elseif (strtolower(trim($jenis['jenis_name'])) == 'net profit')
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalplanlb  , 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($verticallb , 2) }}%
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($totalactuallb, 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($verticalslb , 2) }}%
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($deviasilb, 2) }}
                    </th>
                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                        {{ number_format($persenlb, 2) }}%
                    </th>
                    </tr>

                    
                        @endif 
                        
                        @endforeach 
                    </tbody>
                </table>      

                
                
                
                
                
                
                
                
            </div>
        </div>
    </div>
    </div>
    </div>

        
        
        







@endsection
@section('scripts')
@endsection
