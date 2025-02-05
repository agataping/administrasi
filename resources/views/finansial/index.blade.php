@extends('template.main')
@extends('components.style')

@section('title', 'Finansial Persepektif')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Finansial Perspektif</h2>
                
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
                        <form action="{{ route('KFormLabarugi') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Deskripsi</button>
                        </form>
                    </div>
                    
                    <div class="col-auto">
                        <form action="{{ route('KFormLabarugi') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Sub. Desc</button>
                        </form>
                    </div>
                    
                    <div class="col-auto">
                        <a href="/formLabaRugi" class="btn btn-custom">Add Laba Rugi</a>
                    </div>
                </div>
                

                
                <div class="row">
                    <div class="col-sm-2">
                        <form method="GET" action="{{ url('/index') }}">
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

                <div class="table-responsive">
                <table class="table table-bordered" >
                    <thead style="background-color:rgb(6, 99, 120)" class="text-white">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">Description</th>
                            <th rowspan="2" style="vertical-align: middle;">Plan YTD</th>
                            <th rowspan="2" style="vertical-align: middle;">Vertical Analisys</th>
                            <th rowspan="2" style="vertical-align: middle;">Actual YTD</th>
                            <th rowspan="2" style="vertical-align: middle;">Vertical Analisys</th>
                            
                            <th rowspan="2" style="vertical-align: middle;">Deviations</th>
                            <th rowspan="2" style="vertical-align: middle;">Percentage</th>
                            

                            <th rowspan="2" style="vertical-align: middle;">created_by</th>
                            <th rowspan="2" style="vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($structuredData as $category)
                            <tr>
                                <td><strong>{{ $category['name'] }}</strong></td>
                                
                                <td>{{ $category['PlaYtd'] ?? '' }}</td>
                                @if (in_array($category['id'], [3])) 
                                <td></td>
                                @endif                                   
                                @if (in_array($category['id'], [6, 15, 22])) 
                                <td>{{ $category['VerticalAnalisys1'] ?? '' }}</td>
                                @endif                                   
                                <td>{{ $category['Actualytd'] ?? '' }}</td>
                                <td>{{ $category['VerticalAnalisys'] ?? '' }}</td>
                                <td>{{ $category['Deviation'] ?? '' }}</td>
                                <td>{{ $category['Percentage'] ?? '' }}</td>


                                <td>{{ $category['created_by'] ?? '' }}</td>
                                </tr>

                            @foreach ($category['subcategories'] as $subcategory)
                                <tr>
                                    <td colspan=""style="padding-left: 20px;">{{ $subcategory['name'] }}</td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="" >{{ $subcategory['Actualytd'] ?? '' }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="" >{{ $subcategory['created_by'] ?? '' }} <td>
                            @endforeach
                        @endforeach
                        <tfoot>

                        <td style="text-align: end; vertical-align: end;"  colspan="11">
                                <a href="/formupdateLabaRugi" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tfoot>

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
