@extends('template.main')
@section('title', '')
@section('content')
@extends('components.style')
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4 ">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <div class="row mt-1" style="margin-bottom: 0.5rem;">
                    <h4 class="text-center text-uppercase fw-bold text-primary mb-2">
                        KPI JTN Dashboard - {{ request('tahun', date('Y')) }}
                    </h4>

                    <div class="row align-items-center p-2 m-0 shadow-sm rounded"
                        style="border-radius: 5px; background: linear-gradient(135deg,rgb(76, 76, 76),rgb(76, 76, 76)); border: 1px solid #d4af37; color: #f5f5f5;
                            max-height: 80px; overflow: hidden;">

                        <!-- Bagian Kiri -->
                        <div class="col-auto">

                            <h2 class="fw-bold m-0">Total Performance (YTD)</h2>
                        </div>

                        <!-- Bagian Kanan -->
                        <div class="col text-end">
                            <h6 class="fw-bold text-light m-0">WEIGHT: <span class="text-warning">100%</span></h6>
                        </div>
                    </div>
                    <div class="mt-1 col-2 d-flex justify-content-center align-items-center"
                        style="font-size: 2em;
                    @if ($data['totalresultcompany'] <= 75)
                    background-color: black; color: white;
                    @elseif ($data['totalresultcompany'] > 75 && $data['totalresultcompany'] <= 90)
                    background-color: rgb(206, 24, 24); color: white; /* Merah */
                    
                    @elseif ($data['totalresultcompany'] > 90 && $data['totalresultcompany'] <= 100)
                    background-color: yellow; color: black; /* Kuning */
                    @elseif ($data['totalresultcompany'] > 100 && $data['totalresultcompany'] <= 190)
                    background-color: green; color: white; /* Hijau */
                    @elseif ($data['totalresultcompany'] > 190)
                    background-color: blue; color: white; /* Biru */
                    @endif">
                        {{ number_format($data['totalresultcompany'], 2) }}%
                    </div>


                    <!-- ama perusahaan berdasrkan role Admin -->
                    @if(auth()->user()->role === 'staff' || auth()->user()->role === 'admin'))
                    <div class="col text-center" style="position: relative; left: -100px;">
                        <h4>KPI</h4>

                        @if(isset($data['companyName']))
                        <h4>
                            <p>{{ $data['companyName']->company_name }}</p>
                        </h4>
                        @else
                        <p>Tidak ada perusahaan yang ditemukan.</p>
                        @endif
                    </div>
                    @endif


                </div>




                <!-- Baris kedua untuk persen -->
                <div class="row " style="border: 1px solid black; margin-bottom: 0.5rem; ">
                </div>
                <div class="row sidebar p-1 border rounded shadow-sm bg-light ">
                    <h6 class="text-muted text-center ">Please select a year to view the KPI performance.</h6>

                    <form method="GET" action="{{ route('reportkpi') }}">
                        <label for="tahun" class="form-label mb-1"><strong>Select Year:</strong></label>
                        <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select form-select-sm">
                            @for ($i = date('Y'); $i >= 2019; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                            @endfor
                        </select>
                    </form>
                </div>





                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <div class="row mt-1" style="border: 2px solid black;">

                    <div class="col" style="text-align: start">
                        <h4 style="margin-top:10px;">FINANCIAL PERSPECTIVE</h4>
                    </div>
                    <div class="col text-end">
                        <h5 style="margin-top: 10px;">
                            WEIGHT: 35%
                        </h5>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-2 d-flex justify-content-center align-items-center"
                        style="font-size: 2em; 
                    @if ($data['totalresultfinancial'] <= 75)
                    background-color: black; color: white;
                    @elseif ($data['totalresultfinancial'] > 75 && $data['totalresultfinancial'] <= 90)
                    background-color: rgb(206, 24, 24); color: white; /* Merah */
                    @elseif ($data['totalresultfinancial'] > 90 && $data['totalresultfinancial'] <= 100)
                    background-color: yellow; color: black; /* Kuning */
                    @elseif ($data['totalresultfinancial'] > 100 && $data['totalresultfinancial'] <= 190)
                    background-color: green; color: white; /* Hijau */
                    @elseif ($data['totalresultfinancial'] > 190)
                    background-color: blue; color: white; /* Biru */
                    @endif">
                        {{ number_format($data['totalresultfinancial'], 2) }}%
                    </div>

                    <div class="col">
                        <!-- Grid layout untuk tabel yang disusun secara horizontal -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 5px;">

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
                                            {{ number_format($data['totalRevenuep'], 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($data['totalRevenuea'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle;
                                        @if ($data['indexrevenue'] <= 75)
                                        background-color: black; color: white;
                                        @elseif ($data['indexrevenue'] > 75 && $data['indexrevenue'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexrevenue'] > 90 && $data['indexrevenue'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexrevenue'] > 100 && $data['indexrevenue'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexrevenue'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexrevenue'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style="vertical-align: middle; color: black;">
                                            {{ number_format($data['weightrevenue'], 2) }}%
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
                                        <td>{{ number_format($data['totalplancogas'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($data['totalactualcogas'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                        @if ($data['indexcogs'] <= 75)
                                        background-color: black; color: white;
                                        @elseif ($data['indexcogs'] > 75 && $data['indexcogs'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexcogs'] > 90 && $data['indexcogs'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexcogs'] > 100 && $data['indexcogs'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexcogs'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexcogs'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style="vertical-align: middle; color: black;">
                                            {{ number_format($data['weightcogs'], 2) }}%
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
                                            {{ number_format($data['plancoe'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($data['actualcoe'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                        @if ($data['indexcostemlpoye'] <= 75)
                                        background-color: black; color: white;
                                        @elseif ($data['indexcostemlpoye'] > 75 && $data['indexcostemlpoye'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexcostemlpoye'] > 90 && $data['indexcostemlpoye'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexcostemlpoye'] > 100 && $data['indexcostemlpoye'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexcostemlpoye'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexcostemlpoye'], 2) }}%
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style="vertical-align: middle; color: black;">
                                            {{ number_format($data['weightcostemploye'], 2) }}%
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
                                            Plan
                                        </td>
                                        <td>
                                            {{ number_format($data['plancsr'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($data['actualcsr'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle; 
                                        @if ($data['indexcsr'] <= 75)
                                        background-color: black; color: white;
                                        
                                        @elseif ($data['indexcsr'] > 75 && $data['indexcsr'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexcsr'] > 90 && $data['indexcsr'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexcsr'] > 100 && $data['indexcsr'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexcsr'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexcsr'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style="vertical-align: middle; color: black;">
                                            {{ number_format($data['weightcsr'], 2) }}%
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
                                        <td class="text-end">{{ number_format($data['totalvertikal'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['totalvertikals'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                        @if ($data['indexprofitmg'] <= 75)
                                        background-color: black; color: white;
                                        @elseif ($data['indexprofitmg'] > 75 && $data['indexprofitmg'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexprofitmg'] > 90 && $data['indexprofitmg'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexprofitmg'] > 100 && $data['indexprofitmg'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexprofitmg'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexprofitmg'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($data['weightopratingcost'], 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Operasional Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($data['planoppersen'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['actualoppersen'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>

                                        <td style="vertical-align: middle; 
                                        @if ($data['indexoperatingcost'] <= 75)
                                        background-color: black; color: white;
                                        @elseif ($data['indexoperatingcost'] > 75 && $data['indexoperatingcost'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexoperatingcost'] > 90 && $data['indexoperatingcost'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexoperatingcost'] > 100 && $data['indexoperatingcost'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexoperatingcost'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexoperatingcost'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($data['weightopratingcost'], 2) }}%</td>
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
                                        <td class="text-end">{{ number_format($data['verticallp'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['verticalop'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>

                                        <td style="vertical-align: middle;
                                        @if ($data['indexoperasionalpmg'] <= 75)
                                        background-color: black; color: white;
                                        @elseif ($data['indexoperasionalpmg'] > 75 && $data['indexoperasionalpmg'] <= 90)
                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                        @elseif ($data['indexoperasionalpmg'] > 90 && $data['indexoperasionalpmg'] <= 100)
                                        background-color: yellow; color: black; /* Kuning */
                                        @elseif ($data['indexoperasionalpmg'] > 100 && $data['indexoperasionalpmg'] <= 190)
                                        background-color: green; color: white; /* Hijau */
                                        @elseif ($data['indexoperasionalpmg'] > 190)
                                        background-color: blue; color: white; /* Biru */
                                        @endif">
                                            {{ number_format($data['indexoperasionalpmg'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($data['weightopratingmg'], 2) }}%</td>
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
                                        <td class="text-end">{{ number_format($data['verticallb'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['verticalslb'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($data['indexnetprofitmg'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexnetprofitmg'] > 75 && $data['indexnetprofitmg'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white; /* Merah */
                                            @elseif ($data['indexnetprofitmg'] > 90 && $data['indexnetprofitmg'] <= 100)
                                                background-color: yellow; color: black; /* Kuning */
                                            @elseif ($data['indexnetprofitmg'] > 100 && $data['indexnetprofitmg'] <= 190)
                                                background-color: green; color: white; /* Hijau */
                                            @elseif ($data['indexnetprofitmg'] > 190)
                                                background-color: blue; color: white; /* Biru */
                                            @endif">{{ number_format($data['indexnetprofitmg'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($data['weightnetprofitmargin'], 2) }}%</td>
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
                                        <td class="text-end">{{ number_format($data['planreturnonasset'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['persenactualasset'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                                    @if ($data['indexactualasset'] <= 75)
                                                        background-color: black; color: white;
                                                    @elseif ($data['indexactualasset'] > 75 && $data['indexactualasset'] <= 90)
                                                        background-color: rgb(206, 24, 24); color: white; /* Merah */
                                                    @elseif ($data['indexactualasset'] > 90 && $data['indexactualasset'] <= 100)
                                                        background-color: yellow; color: black; /* Kuning */
                                                    @elseif ($data['indexactualasset'] > 100 && $data['indexactualasset'] <= 190)
                                                        background-color: green; color: white; /* Hijau */
                                                    @elseif ($data['indexactualasset'] > 190)
                                                        background-color: blue; color: white; /* Biru */
                                                    @endif">{{ number_format($data['indexactualasset'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($data['weightasset'], 2) }}%</td>
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
                                        <td class="text-end">{{ number_format($data['persenreturnonequity'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['persenactualmodalhutang'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                            @if ($data['indexmodalhutangactual'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexmodalhutangactual'] > 75 && $data['indexmodalhutangactual'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white; /* Merah */
                                            @elseif ($data['indexmodalhutangactual'] > 90 && $data['indexmodalhutangactual'] <= 100)
                                                background-color: yellow; color: black; /* Kuning */
                                            @elseif ($data['indexmodalhutangactual'] > 100 && $data['indexmodalhutangactual'] <= 190)
                                                background-color: green; color: white; /* Hijau */
                                            @elseif ($data['indexmodalhutangactual'] > 190)
                                                background-color: blue; color: white; /* Biru */
                                            @endif">
                                            {{ number_format($data['indexmodalhutangactual'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">{{ number_format($data['weightmodalhutang'], 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Leverage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($data['planlavarge'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['actuallavarge'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end">0%</td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">0%</td>
                                    </tr>
                                </tbody>
                            </table>













                        </div>
                    </div>
                </div>



                <div class="row mt-1" style="border: 2px solid black;">
                    <div class="col" style="text-align: start;">
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
                        style="font-size: 2em; font-weight: bold; text-align: center;
                                @if ($data['indexmodalhutangactual'] <= 75)
                                    background-color: black; color: white;
                                @elseif ($data['totalresultcostumer'] > 75 && $data['totalresultcostumer'] <= 90)
                                    background-color: rgb(206, 24, 24); color: white; /* Merah */ 
                                @elseif ($data['totalresultcostumer'] > 90 && $data['totalresultcostumer'] <= 100)
                                    background-color: yellow; color: black; /* Kuning */
                                @elseif ($data['totalresultcostumer'] > 100 && $data['totalresultcostumer'] <= 190)
                                    background-color: green; color: white; /* Hijau */
                                @elseif ($data['totalresultcostumer'] > 190)
                                    background-color: blue; color: white; /* Biru */
                                @endif">
                        {{ number_format($data['totalresultcostumer'], 2) }}%
                    </div>
                    <!-- Kolom untuk Tabel -->
                    <div class="col">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 5px;">
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">SHE INDEX</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">3,6 </td>
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
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Stock Jetty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td></td> <!-- Assuming $data['plan'] is the value for "Plan" -->
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['grandTotalstockakhir'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start;">Index</td>
                                        <td></td> <!-- Assuming $data['index'] holds the Index value -->
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" style="vertical-align: middle; color: white;">
                                            5,00%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Tabel Barging -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead ">
                                    <tr>
                                        <th colspan=" 2" style="text-align: center; vertical-align: middle;">Barging</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalplanbarging'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalactualbarging'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabel Domestik -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Domestik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalplandomestik'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalactualdomestik'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td style="vertical-align: middle; 
                                                    @if ($data['indexdomestik'] <= 75)
                                                        background-color: black; color: white;
                                                    @elseif ($data['indexdomestik'] > 75 && $data['indexdomestik'] <= 90)
                                                        background-color: rgb(206, 24, 24); color: white;
                                                    @elseif ($data['indexdomestik'] > 90 && $data['indexdomestik'] <= 100)
                                                        background-color: yellow; color: black;
                                                    @elseif ($data['indexdomestik'] > 100 && $data['indexdomestik'] <= 190)
                                                        background-color: green; color: white;
                                                    @elseif ($data['indexdomestik'] > 190)
                                                        background-color: blue; color: white;
                                                    @endif">
                                            {{ number_format($data['indexdomestik'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">
                                            5,00%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Tabel Ekspor -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Ekspor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td class="text-end">{{ number_format($data['totalplanekspor'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td class="text-end">{{ number_format($data['totalactualekspor'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle;
                                                @if ($data['indexekspor'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($data['indexekspor'] > 75 && $data['indexekspor'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($data['indexekspor'] > 90 && $data['indexekspor'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($data['indexekspor'] > 100 && $data['indexekspor'] <= 190)
                                                    background-color: rgb(0, 255, 72); color: white;
                                                @endif">
                                            {{ number_format($data['indexekspor'], 2) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">5,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class=" row mt-1" style="border: 2px solid black;">
                    <div class="col" style="text-align: start">

                        <h4 style="margin-top:10px;">INTERNAL PROCESS PERSPECTIVE</h4>
                    </div>
                    <div class="col text-end">
                        <h5 style="margin-top: 10px; font-size: 1.25rem;">
                            WEIGHT: 30%
                        </h5>
                    </div>
                </div>
                <div class="row mt-1">
                    <!-- Persentase di sebelah kiri -->
                    <div class="col-2 d-flex justify-content-center align-items-center" style="background-color: #f4e2cd; font-size: 2em;
                                @if ($data['totalresultIPP'] <= 75)
                                    background-color: black; color: white;
                                @elseif ($data['totalresultIPP'] > 75 && $data['totalresultIPP'] <= 90)
                                    background-color: rgb(206, 24, 24); color: white; /* Merah */
                                @elseif ($data['totalresultIPP'] > 90 && $data['totalresultIPP'] <= 100)
                                    background-color: yellow; color: black; /* Kuning */
                                @elseif ($data['totalresultIPP'] > 100 && $data['totalresultIPP'] <= 190)
                                    background-color: green; color: white; /* Hijau */
                                @elseif ($data['totalresultIPP'] > 190)
                                    background-color: blue; color: white; /* Biru */
                                @endif">
                        {{ number_format($data['totalresultIPP'], 2) }}%
                    </div>

                    <div class="col">
                        <!-- Grid layout untuk tabel yang disusun secara horizontal -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 5px;"> <!-- Fleet Productivity (Coal) -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Fleet Productivity (Coal)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalPlancoal'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalActualcoal'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle;
                                            @if ($data['indexcoalgetting'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexcoalgetting'] > 75 && $data['indexcoalgetting'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexcoalgetting'] > 90 && $data['indexcoalgetting'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexcoalgetting'] > 100 && $data['indexcoalgetting'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexcoalgetting'] > 190)
                                                background-color: rgb(0, 60, 255); color: white;
                                            @endif">{{ number_format($data['indexcoalgetting'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">2,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Fleet Productivity (OB) -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Fleet Productivity (OB)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalPlanob'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalActualob'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($data['indexoverburder'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexoverburder'] > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                            @endif">{{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">2,00%</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- evectitive EWH  -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Effective Working Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalplanewh'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalactualewh'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($data['indexoverburder'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexoverburder'] > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                            @endif">{{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">6,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Utilization of Availability	  -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Utilization of Availability</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalactualunithauler'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalactualuaunithauler'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($data['indexoverburder'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexoverburder'] > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                            @endif">{{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">6,00%</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- fuels ratio	  -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Fuel Ratio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalplanfuel'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalactualfuel'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                            @if ($data['indexoverburder'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexoverburder'] > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                            @endif">{{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">6,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- coal mine mt	  -->

                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Coal Mine (MT)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['totalPlancoal'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['totalActualcoal'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                                @if ($data['indexcoalgetting'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($data['indexcoalgetting'] > 75 && $data['indexcoalgetting'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($data['indexcoalgetting'] > 90 && $data['indexcoalgetting'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($data['indexcoalgetting'] > 100 && $data['indexcoalgetting'] <= 190)
                                                    background-color: rgb(0, 255, 72); color: white;
                                                @elseif ($data['indexcoalgetting'] > 190)
                                                    background-color: rgb(0, 60, 255); color: white;
                                                @endif">
                                            {{ number_format($data['indexcoalgetting'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">3,00%</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- fPhysical Availability	  -->
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead ">
                                <tr>
                                    <th colspan=" 3" style="text-align: center; vertical-align: middle;">Physical Availability</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($data['averagePasPlan'], 0, ',', '.') }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($data['averagePasActual'], 0, ',', '.') }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                                                @if ($data['indexoverburder'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                                                    background-color: rgb(0, 255, 72); color: white;
                                                @elseif ($data['indexoverburder'] > 190)
                                                    background-color: rgb(0, 60, 255); color: white;
                                                @endif">
                                            {{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">6,00%</td>
                                    </tr>
                                </tbody>
                            </table>


                            <!-- Physical Availability (PA) Tables -->
                            @if (!empty($data['unitpa']) && count($data['unitpa']) > 0)
                            @foreach ($data['unitpa'] as $index => $item)
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            Physical Availability <br> PA {{ $item['units'] }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plan</td>
                                        <td>{{ number_format($item['total_pas_plan'], 0, ',', '.') }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Actual</td>
                                        <td>{{ number_format($item['total_pas_actual'], 0, ',', '.') }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Index</td>
                                        <td class="text-end" style="vertical-align: middle; 
                        @if ($data['indexoverburder'] <= 75)
                            background-color: black; color: white;
                        @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                            background-color: rgb(206, 24, 24); color: white;
                        @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                            background-color: yellow; color: black;
                        @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                            background-color: rgb(0, 255, 72); color: white;
                        @elseif ($data['indexoverburder'] > 190)
                            background-color: rgb(0, 60, 255); color: white;
                        @endif">
                                            {{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end">6,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @else
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            Physical Availability <br> PA PA Support
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align: center; color: gray;">
                                            No data available
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">
                                            Physical Availability <br> PA PA Loader	
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align: center; color: gray;">
                                            No data available
                                        </td>
                                    </tr>
                                </tbody>
                                <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="text-align: center; vertical-align: middle;">
                                                Physical Availability <br> PA  LAUDER
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2" style="text-align: center; color: gray;">
                                                No data available
                                            </td>
                                        </tr>
                                    </tbody>

                                    @endif
                                    <!-- Fleet Overburden Removal (BCM)	 -->

                                    <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Overburden Removal (BCM)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>{{ number_format($data['totalPlanob'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($data['totalActualob'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="vertical-align: middle; 
                                            @if ($data['indexoverburder'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexoverburder'] > 75 && $data['indexoverburder'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexoverburder'] > 90 && $data['indexoverburder'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexoverburder'] > 100 && $data['indexoverburder'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexoverburder'] > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                            @endif">{{ number_format($data['indexoverburder'], 2, ',', '.') }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td class="text-end">,00%</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Mining Readiness -->
                                    <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;" class="table table-bordered">
                                        <thead ">
                                <tr>
                                    <th colspan=" 3" style="text-align: center; vertical-align: middle;">Mining Readiness</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Plan</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Actual</td>
                                                <td>{{ number_format($data['finalAverage'], 2, ',', '.') }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Index</td>
                                                <td class="text-end" style="vertical-align: middle; 
                                            @if ($data['indexcoalgetting'] <= 75)
                                                background-color: black; color: white;
                                            @elseif ($data['indexcoalgetting'] > 75 && $data['indexcoalgetting'] <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($data['indexcoalgetting'] > 90 && $data['indexcoalgetting'] <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($data['indexcoalgetting'] > 100 && $data['indexcoalgetting'] <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($data['indexcoalgetting'] > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                            @endif">{{ number_format($data['indexcoalgetting'], 2, ',', '.') }}%
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

                    <div class="row mt-1" style="border: 2px solid black; margin-left: 0.5rem; margin-right: 1.5rem;">
                        <div class="col" style="text-align: start; ">
                            <h4 style="margin-top: 10px;">LEARNING & GROWTH PERSPECTIVE</h4>
                        </div>
                        <div class="col text-end" style="width: 100%;">
                            <h5 style="margin-top: 10px; font-size: 1.25rem;">WEIGHT: 20%</h5>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-2 d-flex justify-content-center align-items-center"
                            style=" font-size: 2em; font-weight: bold;   
                            
                            @if ($data['resultlearning'] <= 75)
                                background-color: black; color: white;
                            @elseif ($data['resultlearning'] > 75 && $data['resultlearning'] <= 90)
                                background-color: rgb(206, 24, 24); color: white;
                            @elseif ($data['resultlearning'] > 90 && $data['resultlearning'] <= 100)
                                background-color: yellow; color: black;
                            @elseif ($data['resultlearning'] > 100 && $data['resultlearning'] <= 190)
                                background-color: rgb(0, 255, 72); color: white;
                            @elseif ($data['resultlearning'] > 190)
                                background-color: rgb(0, 42, 255); color: white;
                            @endif">{{ number_format($data['resultlearning'], 2, ',', '.') }}%

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
                                            <td>{{ number_format($data['totalpr'], 2, ',', '.') }}%</td>

                                        </tr>
                                        <tr>
                                            <td>Index</td>
                                            <td class="text-end" style="
                                                @if ($data['indexpeople'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($data['indexpeople'] > 75 && $data['indexpeople'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($data['indexpeople'] > 90 && $data['indexpeople'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($data['indexpeople'] > 100 && $data['indexpeople'] <= 190)
                                                    background-color: rgb(0, 255, 72); color: white;
                                                @elseif ($data['indexpeople'] > 190)
                                                    background-color: rgb(0, 42, 255); color: white;
                                                @endif">{{ number_format($data['indexpeople'], 2, ',', '.') }}%

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            <td class="text-end">10,00%</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabel 2: Infrastructure Readiness -->
                                <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%; height: 100%;">
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
                                            <td>{{ number_format($data['averagePerformance'], 2, ',', '.') }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Index</td>
                                            <td class="text-end" style="
                                                @if ($data['indexinfra'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($data['indexinfra'] > 75 && $data['indexinfra'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($data['indexinfra'] > 90 && $data['indexinfra'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($data['indexinfra'] > 100 && $data['indexinfra'] <= 190)
                                                    background-color: rgb(0, 255, 72); color: white;
                                                @elseif ($data['indexinfra'] > 190)
                                                    background-color: rgb(0, 42, 255); color: white;
                                                @endif">{{ number_format($data['indexinfra'], 2, ',', '.') }}%

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            <td class="text-end">10,00%</td>
                                        </tr>
                                    </tbody>
                                </table>


                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                                    <div style="width: 12rem; height: 5rem; background-color: rgb(80, 200, 120); border: 2px solid black; border-radius: 5px; display: flex; justify-content: center; align-items: center;">
                                        <a href="{{ route('struktur') }}" target="_blank" style="text-decoration: none; color: inherit;">
                                            Organizational Structure
                                        </a>
                                    </div>
                                    <div style="width: 12rem; height: 5rem; background-color: rgb(80, 200, 120); border: 2px solid black; border-radius: 5px; display: flex; justify-content: center; align-items: center;">
                                        <a href="{{ route('indexplantambang') }}" target="_blank" style="text-decoration: none; color: inherit;">
                                            Mining Plan
                                        </a>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

                <div class="vard">
                    <ul>
                        <li>
                            <a href="/indexkpi">
                                KPI
                                @if(auth()->user()->role === 'staff' || auth()->user()->role === 'admin' && isset($data['companyName']))
                                {{ $data['companyName']->company_name }}
                                @endif
                            </a>
                        </li>

                        <li><a href="/indexpengkuran">MEASUREMENT</a></li>
                    </ul>
                </div>

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
    .vard {
        width: 100%;
        background-color: #dddddd;
    }

    .vard ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .vard li {
        float: left;
    }

    .vard li a {
        display: block;
        padding: 10px 16px;
        /* isi nilai padding yang sesuai */
        background-color: #dddddd;
        text-decoration: none;
        color: black;
    }

    .vard li a:hover {
        background-color: #bbb;
        /* efek saat hover */
    }

    .table-container {
        margin-bottom: 15px;
        display: block;
    }

    .table {
        width: 100%;
        background-color: #f8f9fa;
        border-spacing: 0px;
        table-layout: auto;
    }

    .table thead {
        font-family: "Poppins", sans-serif;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 100%;
        text-align: center;
        background-color: rgb(80, 200, 120);
        color: rgb(255, 255, 255);
    }

    .table th,
    .table td {
        padding: 8px 12px;
        text-align: center;
        max-width: 200px;
        word-wrap: break-word;
        white-space: normal;
    }

    .table tbody td {
        color: black;
        font-family: "Arial", sans-serif;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    td:first-child {
        text-align: start;
    }

    td:last-child {
        text-align: end;
    }

    th {
        padding: 5px;
        line-height: 1.5;
    }
</style>