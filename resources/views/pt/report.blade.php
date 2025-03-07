@extends('template.main')
@section('title', '')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4 ">
    <div class="card w-100 ">
        <div class="card-body">
            <div class="col-12">
                <!-- @if(auth()->user()->role === 'admin')    
                <form method="GET" action="{{ route('reportkpi') }}" id="filterForm">
                    <label for="id_company">Select Company:
                        <br>
                        <small><em>To view company KPI, please select a company from the list.</em></small>
                    </label>
                    <select name="id_company" id="id_company" onchange="updateCompanyName(); document.getElementById('filterForm').submit();">
                        <option value="">-- Select Company --</option>
                        @foreach ($perusahaans as $company)
                        <option value="{{ $company->id }}" data-nama="{{ $company->nama }}" {{ request('id_company') == $company->id ? 'selected' : '' }}>
                            {{ $company->nama }}
                        </option>
                        @endforeach
                    </select>
                </form>
                @endif -->
                <div class="background-full" style="background:  url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
                </div>

                <h2 class="text-center">
                    <strong>TOTAL PERFORMANCE (YEAR TO DATE)</strong>
                </h2>


                <div class="row" style="background-color: #f4e2cd; border: 2px solid black;">
                    <!-- Baris pertama -->
                    <div class="col" style="text-align: left;">
                        <h2 class="">TOTAL PERFORMANCE (YEAR TO DATE)</h2>
                    </div>
                    <div class="col text-end">
                        <h4 style="margin-top: 10px;">WEIGHT: 100%</h4>
                    </div>
                </div>

                <!-- Baris kedua untuk persen -->
                <div class="row mt-1" style="border: 2px solid black;">
                    <div class="col-2 d-flex justify-content-center align-items-center" style="background-color:rgb(221, 255, 0); font-size: 2em; font-weight: bold;">
                        %
                    </div>

                    <!-- ama perusahaan berdasrkan role Admin -->
                    @if(auth()->user()->role === 'admin')
                    <div class="col text-center">
                        <h4>KPI</h4>
                        <h4 id="selectedCompanyName">{{ $company->nama ?? 'No Company Selected' }}</h4>
                    </div>
                    @endif

                    <!-- nama perusahaan berdasrkan role staff -->
                    @if(auth()->user()->role === 'staff')
                    <div class="col text-center">
                        <h4>KPI</h4>

                        @if($companyName)
                        <h4>
                            <p> {{ $companyName->company_name }}</p>
                        </h4>
                        @else
                        <p>Tidak ada perusahaan yang ditemukan.</p>
                        @endif
                    </div>
                    @endif
                </div>


                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <div class="row mt-1" style="border: 2px solid black;">

                    <div class="col" style="text-align-end">
                        <h4 style="margin-top: 10px;">FINANCIAL PERSPECTIVE</h4>
                    </div>
                    <div class="col text-end">
                        <h5 style="margin-top: 10px;">
                            WEIGHT: 35%
                        </h5>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-2 d-flex justify-content-center align-items-center" style="background-color: #f4e2cd; font-size: 2em; text- font-weight: bold;">
                        59%
                    </div>
                    <div class="col">
                        <!-- Grid layout untuk tabel yang disusun secara horizontal -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 5px;">

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">

                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            Revenue
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">
                                            Plan</td>
                                        <td>
                                            {{ number_format($totalRevenuep, 2) }}
                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($totalRevenuea, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexrevenue<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexrevenue> 75 && $indexrevenue<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexrevenue> 90 && $indexrevenue<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexrevenue> 100 && $indexrevenue<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexrevenue> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexrevenue, 2) }}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: black;">
                                            {{ number_format($weightrevenue, 2) }}%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            Cost of Goods Sold (COGS)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">
                                            Plan</td>
                                        <td>{{ number_format($totalplancogas, 2) }}</td>
                                    </tr>
                                    <tr>

                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($totalactualcogas, 2) }}%</td>

                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexcogs<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexcogs> 75 && $indexcogs<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexcogs> 90 && $indexcogs<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexcogs> 100 && $indexcogs<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexcogs> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexcogs, 2) }}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: black;">
                                            {{ number_format($weightcogs, 2) }}%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            Cost Of Employe
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">
                                            Plan</td>
                                        <td>
                                            {{ number_format($plancoe, 2) }}
                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($actualcoe, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexcostemlpoye<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexcostemlpoye> 75 && $indexcostemlpoye<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexcostemlpoye> 90 && $indexcostemlpoye<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexcostemlpoye> 100 && $indexcostemlpoye<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexcostemlpoye> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexcostemlpoye, 2) }}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: black;">
                                            {{ number_format($weightcostemploye, 2) }}%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            CSR
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">
                                            Plan</td>
                                        <td>
                                            {{ number_format($totplanscsr, 2) }}
                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($actualcsr, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexcsr<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexcsr> 75 && $indexcsr<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexcsr> 90 && $indexcsr<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexcsr> 100 && $indexcsr<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexcsr> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexcsr, 2) }}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: black;">
                                            {{ number_format($weightcsr, 2) }}%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Gross Profit (gp) Margin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($totalvertikal, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($verticalop, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexoperasionalpmg<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexoperasionalpmg> 75 && $indexoperasionalpmg<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexoperasionalpmg> 90 && $indexoperasionalpmg<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexoperasionalpmg> 100 && $indexoperasionalpmg<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexoperasionalpmg> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif">{{ number_format($indexoperasionalpmg, 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($weightopratingcost, 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Operasional Cost </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($planoppersen, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($actualoppersen, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexoperatingcost<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexoperatingcost> 75 && $indexoperatingcost<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexoperatingcost> 90 && $indexoperatingcost<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexoperatingcost> 100 && $indexoperatingcost<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexoperatingcost> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexoperatingcost, 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($weightopratingcost, 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Operating Profit Margin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($totalvertikal, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{number_format($verticalop, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexoperasionalpmg<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexoperasionalpmg> 75 && $indexoperasionalpmg<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexoperasionalpmg> 90 && $indexoperasionalpmg<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexoperasionalpmg> 100 && $indexoperasionalpmg<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexoperasionalpmg> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif">{{ number_format($indexoperasionalpmg, 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($weightopratingmg, 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>


                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Net Profit Margin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($verticallp, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($verticalslb, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexnetprofitmg<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexnetprofitmg> 75 && $indexnetprofitmg<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexnetprofitmg> 90 && $indexnetprofitmg<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexnetprofitmg> 100 && $indexnetprofitmg<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexnetprofitmg> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexnetprofitmg, 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($weightnetprofitmargin, 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Return On Asset</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($persenassetplan, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($psersenactualasset, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexactualasset <= 75)
                                            background-color: black; color: white;
                                            @elseif ($indexactualasset > 75 && $indexactualasset <= 90)
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */                                                            
                                            @elseif ($indexactualasset > 90 && $indexactualasset <= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexactualasset > 100 && $indexactualasset <= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexactualasset > 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexactualasset , 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($weightasset , 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Return On Equity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($persenmodalhutangplan  , 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($persenactualmodalhutang , 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($indexmodalhutanactual<= 75)
                                            background-color: black; color: white;
                                            @elseif ($indexmodalhutanactual> 75 && $indexmodalhutanactual<= 90)
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */                                                            
                                            @elseif ($indexmodalhutanactual> 90 && $indexmodalhutanactual<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexmodalhutanactual> 100 && $indexmodalhutanactual<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexmodalhutanactual> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif"> {{ number_format($indexmodalhutanactual  , 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($weightmodalhutang , 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">lavarge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end">%</td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">%</td>
                                    </tr>
                                </tbody>
                            </table>










                        </div>
                    </div>
                </div>



                <div class="row mt-1" style="border: 2px solid black;">
                    <div class="col" style="text-align-end">
                        <h4 style="margin-top: 10px;">COSTUMER PERSPECTIVE</h4>
                    </div>
                    <div class="col text-end">
                        <h5 style="margin-top: 10px; font-size: 1.25rem;">
                            WEIGHT: 15%
                        </h5>
                    </div>
                </div>
                <div class="row mt-1">
                    <!-- Persentase di sebelah kiri -->
                    <div class="col-2 d-flex justify-content-center align-items-center"
                        style="background-color: #f4e2cd; font-size: 2em; font-weight: bold; text-align: center;">
                        59%
                    </div>

                    <!-- Kolom untuk Tabel -->
                    <div class="col">
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">SHE INDEX</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">3,6</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">1</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end">27,78%</td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">2,00%</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">COSTUMER SATISFACTION INDEX</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">3,2</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">3,2</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end">100,00%</td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">3,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Tabel tock jetty -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead style="background-color: rgb(107, 255, 149);">
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">stock jetty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($planNominalsj, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($grandTotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($indexstockjetty<= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($indexstockjetty> 75 && $indexstockjetty<= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($indexstockjetty> 90 && $indexstockjetty<= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($indexstockjetty> 100 && $indexstockjetty<= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($indexstockjetty> 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif
                                        ">
                                            {{ $indexstockjetty }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            5,00%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            <!-- Tabel Barging -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead style="background-color: rgb(107, 255, 149);">
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Barging</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ $results['total']['Plan'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ $results['total']['Actual'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($results['total']['Index'] <= 75)
                                                            
                                            background-color: black; color: white;
                                            @elseif ($results['total']['Index'] > 75 && $results['total']['Index'] <= 90)
                                                            
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                            
                                            @elseif ($results['total']['Index'] > 90 && $results['total']['Index'] <= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($results['total']['Index'] > 100 && $results['total']['Index'] <= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($results['total']['Index'] > 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif
                                        ">
                                            {{ $results['total']['Index'] }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            5,00%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabel Domestik -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead style="background-color: rgb(107, 255, 149);">
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Domestik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ $results['Domestik']['Plan'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ $results['Domestik']['Actual'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($results['Domestik']['Index'] <= 75)
                                                                
                                            background-color: black; color: white;
                                            @elseif ($results['Domestik']['Index'] > 75 && $results['Domestik']['Index'] <= 90)
                                                                
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                                
                                                                
                                            @elseif ($results['Domestik']['Index'] > 90 && $results['Domestik']['Index'] <= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($results['Domestik']['Index'] > 100 && $results['Domestik']['Index'] <= 190)
                                            background-color: green; color: white; /* Hijau */
                                            @elseif ($results['Domestik']['Index'] > 190 )
                                            background-color: blue; color: white; /* Hijau */
                                            @endif
                                        ">
                                            {{ $results['Domestik']['Index'] }}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            5,00%

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabel Ekspor -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead style="background-color: rgb(107, 255, 149);">
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Ekspor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ $results['Ekspor']['Plan'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end"> {{ $results['Ekspor']['Actual'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($results['Ekspor']['Index'] <= 75)
                                            background-color: black; color: white;
                                            @elseif ($results['Ekspor']['Index'] > 75 && $results['Ekspor']['Index'] <= 90)
                                            background-color: rgb(206, 24, 24); color: white; /* Merah */
                                            @elseif ($results['Ekspor']['Index'] > 90 && $results['Ekspor']['Index'] <= 100)
                                            background-color: yellow; color: black; /* Kuning */
                                            @elseif ($results['Ekspor']['Index'] > 100 && $results['Ekspor']['Index'] <= 190)
                                            background-color: rgb(0, 255, 72); color: white; /* Hijau */
                                            @endif
                                                                
                                        ">{{ $results['Ekspor']['Index']}}% </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" ">5,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              
                <div class=" row mt-1" style="border: 2px solid black;">
                                            <div class="col" style="text-align-end">
                                                <h4 style="margin-top: 10px;">INTERNAL PROCESS PERSPECTIVE</h4>
                                            </div>
                                            <div class="col text-end">
                                                <h5 style="margin-top: 10px; font-size: 1.25rem;">
                                                    WEIGHT: 30%
                                                </h5>
                                            </div>
                        </div>
                        <div class="row mt-1">
                            <!-- Persentase di sebelah kiri -->
                            <div class="col-2 d-flex justify-content-center align-items-center"
                                style="background-color: #f4e2cd; font-size: 2em; font-weight: bold; text-align: center;">
                                59%
                            </div>


                            <div class="col">
                                <!-- Grid layout untuk tabel yang disusun secara horizontal -->
                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                                    <!-- Fleet Productivity (Coal) -->
                                    <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                        <thead style="background-color: rgb(107, 255, 149);">
                                            <tr>
                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Fleet Productivity (Coal)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>{{ number_format($totalPlancoal, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($totalActualcoal, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="vertical-align: middle; 
                                            @if ($indexcoalgetting <= 75)
                                            background-color: black; color: white;
                                            @elseif ($indexcoalgetting > 75 && $indexcoalgetting <= 90)
                                            background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($indexcoalgetting > 90 && $indexcoalgetting <= 100)
                                            background-color: yellow; color: black;
                                            @elseif ($indexcoalgetting > 100 && $indexcoalgetting <= 190)
                                            background-color: rgb(0, 255, 72); color: white;
                                            
                                            @elseif ($indexcoalgetting > 190)
                                                background-color: rgb(0, 60, 255); color: white;
                                            @endif
                                            ">{{ number_format($indexcoalgetting, 0, ',', '.') }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td class="text-end">2,00%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Fleet Productivity (OB) -->
                                    <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                        <thead style="background-color: rgb(107, 255, 149);">
                                            <tr>
                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Fleet Productivity (OB)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>{{ number_format($totalPlanob, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($totalPlanob, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="vertical-align: middle; 
                                                @if ($indexoverburder <= 75)
                                                background-color: black; color: white;
                                                @elseif ($indexoverburder > 75 && $indexoverburder <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($indexoverburder > 90 && $indexoverburder <= 100)
                                                background-color: yellow; color: black;
                                                @elseif ($indexoverburder > 100 && $indexoverburder <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                                @elseif ($indexoverburder > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                                @endif
                                            ">{{ number_format($indexoverburder, 0, ',', '.') }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td class="text-end">2,00%</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Physical Availability (PA) Tables -->
                                    @foreach($unitpa as $item)
                                    <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                        <thead style="background-color: rgb(107, 255, 149);">
                                            <tr>
                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Physical Availability <br> PA {{ $item['units'] }}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>{{ number_format($item['total_pas_plan'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($item['total_pas_actual'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="vertical-align: middle; 
                                            @if ($indexoverburder <= 75)
                                            background-color: black; color: white;
                                            @elseif ($indexoverburder > 75 && $indexoverburder <= 90)
                                            background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($indexoverburder > 90 && $indexoverburder <= 100)
                                            background-color: yellow; color: black;
                                            @elseif ($indexoverburder > 100 && $indexoverburder <= 190)
                                            background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($indexoverburder > 190)
                                            background-color: rgb(0, 42, 255); color: white;
                                            @endif
                                            ">
                                                    {{ number_format($item['indexpa'], 0, ',', '.') }}%
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    @endforeach
                                    <!-- Mining Readiness -->
                                    <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;" class="table table-bordered">
                                        <thead style="background-color: rgb(107, 255, 149);">
                                            <tr>
                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Mining Readiness</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($finalAverage, 0, ',', '.') }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="vertical-align: middle; 
                                            @if ($indexcoalgetting <= 75)
                                            background-color: black; color: white;
                                            @elseif ($indexcoalgetting > 75 && $indexcoalgetting <= 90)
                                            background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($indexcoalgetting > 90 && $indexcoalgetting <= 100)
                                            background-color: yellow; color: black;
                                            @elseif ($indexcoalgetting > 100 && $indexcoalgetting <= 190)
                                            background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($indexcoalgetting > 190)
                                            background-color: rgb(0, 60, 255); color: white;
                                            @endif">{{ number_format($indexmining, 0, ',', '.') }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td class="text-end">4,00%</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-1" style="border: 2px solid black;">

                            <div class="col" style="text-align: start;">
                                <h4 style="margin-top: 10px;">LEARNING & GROWTH PERSPECTIVE</h4>
                            </div>
                            <div class="col text-end" style="width: 100%;">
                                <h5 style="margin-top: 10px; font-size: 1.25rem;">WEIGHT: 20%</h5>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-2 d-flex justify-content-center align-items-center"
                                style="background-color: #f4e2cd; font-size: 2em; font-weight: bold;">
                                75%
                            </div>
                            <div class="col">
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; align-items: start; max-width: 50rem;">
                                    <!-- Tabel 1: People Readiness -->
                                    <table class="table table-bordered"
                                        style="border: 1px solid black; border-collapse: collapse; width: 100%; height: 100%;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">People Readiness</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($totalpr, 0, ',', '.') }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="
                                        @if ($indexpeople <= 75)
                                        background-color: black; color: white;
                                        @elseif ($indexpeople > 75 && $indexpeople <= 90)
                                        background-color: rgb(206, 24, 24); color: white;
                                        @elseif ($indexpeople > 90 && $indexpeople <= 100)
                                        background-color: yellow; color: black;
                                        @elseif ($indexpeople > 100 && $indexpeople <= 190)
                                        background-color: rgb(0, 255, 72); color: white;
                                        @elseif ($indexpeople > 190)
                                        background-color: rgb(0, 60, 255); color: white;
                                        @endif">
                                                    {{ number_format($indexpeople, 0, ',', '.') }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td class="text-end">10,00%</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Tabel 2: Infrastructure Readiness -->
                                    <table class="table table-bordered"
                                        style="border: 1px solid black; border-collapse: collapse; width: 100%; height: 100%;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Infrastructure Readiness</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($averagePerformance, 0, ',', '.') }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="
                                        @if ($indexinfra <= 75)
                                        background-color: black; color: white;
                                        
                                        @elseif ($indexinfra > 75 && $indexinfra <= 90)
                                        background-color: rgb(206, 24, 24); color: white;
                                        @elseif ($indexinfra > 90 && $indexinfra <= 100)
                                        background-color: yellow; color: black;
                                        @elseif ($indexinfra > 100 && $indexinfra <= 190)
                                        background-color: rgb(0, 255, 72); color: white;
                                        @elseif ($indexinfra > 190)
                                        background-color: rgb(0, 60, 255); color: white;
                                        @endif">
                                                    {{ number_format($indexinfra, 0, ',', '.') }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td class="text-end">10,00%</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Organizational Structure (Diturunkan sedikit) -->
                                    <div class="mt-3" style="width: 16rem; height: 2rem; background-color: rgb(107, 255, 149); border: 2px solid black; border-radius: 5px;
                            display: flex; justify-content: center; align-items: center;">
                                        <a href="{{ route('struktur') }}" target="_blank" style="text-decoration: none; color: inherit;">
                                            Organizational Structure
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endsection
                        @section('scripts')
                        @endsection
                        <script>
                            function updateCompanyName() {
                                var select = document.getElementById("id_company");
                                var selectedOption = select.options[select.selectedIndex];
                                var companyName = selectedOption.getAttribute("data-nama") || "No Company Selected";
                                document.getElementById("selectedCompanyName").innerText = companyName;
                            }

                            // Set initial company name on page load
                            document.addEventListener("DOMContentLoaded", function() {
                                updateCompanyName();
                            });
                        </script>



                        <style>
                            .table {
                                background-color: #f8f9fa;
                                margin-top: 10px;
                            }

                            .table thead {
                                font-family: "Poppins", sans-serif;
                                font-weight: bold;
                                text-transform: uppercase;
                                font-size: 120%;
                                background-color: rgb(107, 255, 149);
                                text-align: center;
                            }

                            .table tbody td {
                                color: black;
                                font-family: "Arial", sans-serif;

                            }

                            td:first-child {
                                text-align: start;
                            }

                            td:last-child {
                                text-align: end;
                            }
                        </style>