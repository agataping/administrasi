@extends('template.main')
@extends('components.style')

@section('title', 'LabaRugi')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Laba Rugi</h2>
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
                    <thead>
                        <tr>
                            <th rowspan="" style="vertical-align: middle; text-align: center;">No</th>
                            <th   rowspan="" style="vertical-align: middle;  text-align: center;">Deskripsi</th>
                            <th   colspan=""  style="vertical-align: middle; text-align: center;">Plan</th>
                            <th  colspan=""style="vertical-align: middle; text-align: center;">Actual</th>
                            <th  colspan=""style="vertical-align: middle; text-align: center;">Tanggal</th>
                            <th  rowspan="" style="vertical-align: middle; text-align: center;">created_by</th>
                            <th  rowspan="" style="vertical-align: middle; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($totals as $total)
                    {{-- Tampilkan Kategori --}}
                    <tr>
                        <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                        <td colspan=""><strong>{{ $total['kategori_name'] }}</strong></td>
                        <td><strong>{{ number_format($total['total_plan'], 2) }}</strong></td>
                        <td><strong>{{ number_format($total['total_actual'], 2) }}</strong></td>
                    </tr>
                    
                    {{-- Tampilkan Sub-Kategori --}}
                    @foreach ($total['sub_categories'] as  $subIndex => $subCategory)
                    <tr>
                        <th style="vertical-align: middle;">{{ $loop->parent->iteration }}.{{ (int) $subIndex + 1 }}</th>
                        <td><strong>{{ $subCategory['name_sub'] }}</strong></td>
                        <td><strong>{{ number_format($subCategory['total_plan'], 2) }}</strong></td>
                        <td><strong>{{ number_format($subCategory['total_actual'], 2) }}</strong></td>
                    </tr>
                    
                    {{-- Tampilkan Detail dari Sub-Kategori --}}
                    @foreach ($subCategory['details'] as $detailIndex => $detail)
                    <tr>
                        <th style="vertical-align: middle;">{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $detailIndex + 1 }}</th>
                        <td>{{ $detail->desc }}</td>
                        <td>{{ number_format($detail->nominalplan, 2) }}</td>
                        <td>{{ number_format($detail->nominalactual, 2) }}</td>
                        <td>{{ $detail->tanggal }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endforeach                        
                </tbody>
            </table>                        
            
            
            
            
            
            
            
            
            
            
            
                    
                    
                    
                    
                    
                    
                    
                    
            </div>
        </div>
    </div>
</div>
        
        
        







@endsection
@section('scripts')
<script>
    document.getElementById('actualBtn').addEventListener('click', function() {
        document.getElementById('actualInput').style.display = 'block';
        document.getElementById('planInput').style.display = 'none';
    });

    document.getElementById('planBtn').addEventListener('click', function() {
        document.getElementById('planInput').style.display = 'block';
        document.getElementById('actualInput').style.display = 'none';
    });
</script>
@endsection
