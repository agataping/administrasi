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
                <form method="GET" action="{{ route('stockjt') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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
                <div class="form-group ">
                    <input 
                    type="text" 
                    id="myInput" 
                    onkeyup="filterByLocation()" 
                    placeholder="Search for location..." 
                    title="Type in a location"
                    style="width: 40%; padding: 10px; font-size: 16px;"
                    >
                </div>
                


                <table class="table table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle;">No</th>
                            <th rowspan="3" colspan="2" style="vertical-align: middle;">Date</th>
                            <th colspan="4" style="text-align: center;">HAULING</th>
                            <th rowspan="3" style="vertical-align: middle;">Lokasi</th>
                            <th rowspan="3" style="vertical-align: middle;">created_by</th>
                        </tr>


                        <tr>
                            <th>Shief I</th>
                            <th>Shief II</th>
                            <th>Tot. Hauling</th>
                            <th>Akumulasi</th>
                            
                        </tr>
                        <tr>
                            <th colspan="4"  style="text-align: center;">stock awal : {{ $data->first()->sotckawal  ?? '-' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        
                        <tr>
                            <th  style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($d->date)->format('d-m-Y') }}</td>
                            <td  colspan="2" style="text-align: center; vertical-align: middle;">{{ $d->shifpertama}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->shifkedua}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->totalhauling }}</td>
                            <td style="text-align: end; vertical-align: middle;">{{ number_format($d->akumulasi_stock, 0) }} </td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->lokasi}}</td>

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
        
        
        


<!-- perhitungan stock awal perbaikan -->



@endsection
@section('scripts')
<script>
function filterByLocation() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[5];  // Mengambil kolom lokasi
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

</script>
@endsection
