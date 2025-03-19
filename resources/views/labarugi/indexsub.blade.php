@extends('template.main')
@extends('components.style')
@extends('components.script')
@section('title', 'Sub-Description Data')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/labarugi" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Sub-Description Data</h3>
                </a>                
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
                
                
                <div class="row align-items-center">
                    <div class="col-auto">
                        <form action="{{ route('sublr') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Data</button>
                        </form>
                    </div>
                </div>
                
                <!-- @if(auth()->user()->role === 'admin')    
                <form method="GET" action="{{ route('indexsublr') }}" id="filterForm">
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
                    @endif -->
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                        style="margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">

                    <div class="" style="overflow-x:auto;">
                        <div class="table-responsive" style="max-height: 400px; overflow-y:auto;"> 
                        <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">


                                <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                        <th rowspan="2"style="vertical-align: middle;">Sub-Description</th>
                                        <th rowspan="2" colspan="3"  style="vertical-align: middle;">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($kat as $d)
                                    <tr>
                                        <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                                        <td style="text-align: ;">{{$d->namesub}}</td>
                                        
                                        <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                            
                                                <a href="{{ route('formupdatesublr', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                                    Edit
                                                </a>
                                           
                                        </td>
                                        
                                        
                                        <td style="text-align: center; vertical-align: middle;"  rowspan="">
                                            
                                            <form action="{{ route('deletesublr', ['id' => $d->id]) }}" method="POST" onsubmit="return confirmDelete(event)" >
                                                
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
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
<script>
        function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("myTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) { 
            let td = tr[i].getElementsByTagName("td");
            let rowVisible = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        rowVisible = true;
                        break;
                    }
                }
            }

            tr[i].style.display = rowVisible ? "" : "none";
        }
    }
</script>
@endsection
