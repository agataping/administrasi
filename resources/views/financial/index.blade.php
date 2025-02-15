@extends('template.main')
@extends('components.style')

@section('title', 'Balnce sheet')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Balnce sheet</h2>
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
                <div class="row justify-content-start" >
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
                @if(auth()->user()->role === 'admin')    

                <form method="GET" action="{{ route('indexfinancial') }}" id="filterForm">
                                   <label for="id_company">Select Company:
                    <br>
                        <small><em>To view company data, please select a company from the list.</em></small></label>
                    <select name="id_company" id="id_company" onchange="document.getElementById('filterForm').submit();">
                        <option value="">-- Select Company --</option>
                        @foreach ($perusahaans as $company)
                        <option value="{{ $company->id }}" {{ request('id_company') == $company->id ? 'selected' : '' }}>
                            {{ $company->nama }}
                        </option>
                        @endforeach
                    </select>
                </form>
                @endif
                <div style="overflow-x:auto;">
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
                
                <div class="table-responsive" style="max-height: 400px; overflow-y:auto;"> 
                <table class="table table-bordered" id="myTable">
                <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                <tr>
                            <th rowspan="" style="vertical-align: middle; text-align: center;">No</th>
                            <th   rowspan="" style="vertical-align: middle;  text-align: center;">Description</th>
                            <th   colspan=""  style="vertical-align: middle; text-align: center;">Debit</th>
                            <th   colspan=""  style="vertical-align: middle; text-align: center;">Credit</th>
                            <th   rowspan="" style="vertical-align: middle;  text-align: center;">Date</th>
                            <th   colspan="2"  style="vertical-align: middle; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedData as $total)
                        {{-- Tampilkan Kategori --}}
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td colspan=""><strong>{{ $total['category_name'] }}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdatecatneraca', ['id' => $total['category_id']]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td></td>
                        </tr>
                        {{-- Tampilkan Sub-Kategori --}}
                        @foreach ($total['sub_categories'] as  $subIndex => $subCategory)
                        <tr>
                            <th style="vertical-align: middle;">{{ $loop->parent ? $loop->parent->iteration : '0' }}.{{ $loop->iteration }}</th>
                            <td><strong>{{ $subCategory['sub_category'] }}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdatesubneraca', ['id' => $subCategory['sub_id']]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deletesubfinan', ['id' => $subCategory['sub_id']]) }}" method="POST" onsubmit="return confirmDelete(event)">                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @foreach ($subCategory['details'] as $detailIndex => $detail)
                        <tr>
                            <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                            <td>{{ $detail['name'] }}</td>
                            <td style="text-align: right;">{{ number_format($detail['debit'], ) }}</td>
                            <td style="text-align: right;">{{ number_format($detail['credit'], ) }}</td>
                            <td style="text-align: center;">{{ \Carbon\Carbon::parse($detail['tanggal'])->format('d-m-Y') }}</td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdatefinancial', ['id' => $detail['id']]) }}">      
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deletefinancial', $detail['id']) }}" method="POST" onsubmit="return confirmDelete(event)">                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                            <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">Total {{ $total['category_name'] }}</th>
                            <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">
                            {{ number_format($total['total']['debit'] ?? 0, 2) }}
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"> {{ number_format($total['total']['credit'] ?? 0, 2) }}</th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                            </tr>
                            <tr>
                                @if ($total['category_name'] == 'CURRENT ASSETS')
                                <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">TOTAL ASSETS :</th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                @endif
                            </tr>
                            <tr>
                                @if ($total['category_name'] == 'EQUITY')
                                <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">TOTAL LIABILITIES AND EQUITY  :</th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                @endif
                            </tr>
                            @endforeach      
                            <tr>
                                <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">Control :</th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                                <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></th>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    
    
        
        





@endsection
@section('scripts')


@endsection
