@extends('template.main')
@extends('components.style')

@section('title', 'Description Data Overburden & Coal getting')
@section('content')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">

                <h3 class="mb-3" onclick="window.history.back()" style="cursor: pointer;">Description Overburden & Coal getting</h3>

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
                        <form action="{{ route('formovercoal') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Data</button>
                        </form>
                    </div>
                </div>

                {{-- @if(auth()->user()->role === 'admin')
                <form method="GET" action="{{ route('indexcategoryobcoal') }}" id="filterForm">
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
                @endif --}}
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="margin-bottom: 10px; padding: 5px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">

                <div class="" style="overflow-x:auto;">
                    <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                        <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                            <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;">Description</th>
                                    <th rowspan="2" colspan="3" style="vertical-align: middle;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                                    <td style="text-align: ;">{{$d->name}}</td>

                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <a href="{{ route('formupdatecategoryobc', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                            Edit
                                        </a>
                                    </td>


                                    <td style="text-align: center; vertical-align: middle;" rowspan="">

                                        <form action="{{ route('deletecategoryobc', ['id' => $d->id]) }}" method="POST" onsubmit="return confirmDelete(event)">

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

    @endsection