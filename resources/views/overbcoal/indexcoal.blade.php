@extends('template.main')
@extends('components.style')

@section('title', 'OverBurden&Coa')
@section('content')


<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">COAL</h2>
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
                        <form action="{{ route('formkategoriobc') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Deskripsi</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('formovercoal') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>
                <form method="GET" action="{{ route('indexcoal') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                            <th  colspan=""style="vertical-align: middle; text-align: center;">Date</th>
                            <th   rowspan="" style="vertical-align: middle;  text-align: center;">Deskripsi</th>
                            <th   colspan=""  style="vertical-align: middle; text-align: center;">Plan</th>
                            <th  colspan=""style="vertical-align: middle; text-align: center;">Actual</th>
                            <th  rowspan="" style="vertical-align: middle; text-align: center;">Deviation</th>
                            <th  rowspan="" style="vertical-align: middle; text-align: center;">Percentage</th>
                            <th  colspan="2" style="vertical-align: middle; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totals as $total)
                        <tr>
                            <th style="vertical-align: middle; background-color: #f0f0f0;">{{ $loop->iteration }}</th>    
                            <th style="vertical-align: middle; background-color: #f0f0f0;"></th>
                            <th colspan="" style="text-align: left; background-color: #f0f0f0;">
                                {{ $total['kategori_name'] }}
                            </th>
                            <th  style="vertical-align: middle; background-color: #f0f0f0; text-align: end;" >
                                {{ number_format($total['total_plan'], 2) }}
                            </th>
                            <th  colspan="" style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">
                                {{ number_format($total['total_actual'], 2) }}
                            </th>
                            <th  style="vertical-align: middle; background-color: #f0f0f0; text-align: end;" >
                                {{ number_format($total['deviation'], 2) }}
                            </th>
                            <th  colspan="" style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">
                                {{ number_format($total['percentage'], 2) }}%
                            </th>
                            <th  colspan="" style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">
                            </th>
                            <th  colspan="" style="vertical-align: middle; background-color: #f0f0f0; text-align: end;">
                            </th>



                        </tr>
                        @foreach ($total['details'] as $subIndex => $detail)
                        <tr>
                        <th style="vertical-align: middle;">{{ $loop->parent->iteration }}.{{ (int) $subIndex + 1 }}</th>
                            <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d F Y') }}</td>
                            <td>{{ $detail->desc }}</td>
                            <td style="vertical-align: middle; text-align: end;">{{ number_format((float)$detail->nominalplan, 2) }}</td>
                            <td style="vertical-align: middle; text-align: end;">{{ number_format((float)$detail->nominalactual, 2) }}</td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('formupdateovercoal', ['id' => $detail->id]) }}">
                                    <button type="submit"  class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </td>
                                    <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                <form action="{{ route('deleteovercoal', $detail->id) }}" method="POST" onsubmit="return confirmDelete(event)" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
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
