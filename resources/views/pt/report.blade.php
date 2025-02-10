@extends('template.main')
@section('title', '')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100" style=" background-color:rgba(134, 247, 138, 0.98); ">
        <div class="card-body">
            <div class="col-12">

                <h2 class="text-center">
                    <strong>TOTAL PERFORMANCE (YEAR TO DATE)</strong>
                </h2>


                <div class="row" style="background-color: #f4e2cd; border: 2px solid black;" >
                    <!-- Baris pertama -->
                    <div class="col" style="text-align: left;">
                        <h2 class="">TOTAL PERFORMANCE (YEAR TO DATE)</h2>
                    </div>
                    <div class="col text-end" >
                        <h4 style="margin-top: 10px;">WEIGHT: 100%</h4>
                    </div>
                </div>
                
                <!-- Baris kedua untuk persen -->
                <div class="row mt-1" style="border: 2px solid black;">
                    <div class="col-2 d-flex justify-content-center align-items-center" style="background-color:rgb(221, 255, 0); font-size: 2em; font-weight: bold;">
                        %
                    </div>
                    
                    <div class="col text-center">
                        <h4>KPI</h4> 
                        @if($user->role === 'admin')
                            @if($companyName->isEmpty())
                                 <p>Tidak ada perusahaan yang memiliki laporan.</p>
                            @else
                                @foreach ($companyName as $company)
                                    <h4>{{ $company->company_name }}</h4>
                                @endforeach
                            @endif
                            @else
                            @if($companyName)
                                <h4> <p> {{ $companyName->company_name }}</p></h4>
                            @else
                            <p>Tidak ada perusahaan yang ditemukan.</p>
                            @endif
                        @endif
                    </div> 
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
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                            @foreach($totals as $jenis)
                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">{{ $jenis['jenis_name'] }}</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($jenis['jenis_name'] == 'Gross Profit')
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Plan</td>
                                        <td>{{ number_format($totalvertikal, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($totalvertikals, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >Index</td>
                                        <td style="text-align: ; vertical-align: middle;
                                            vertical-align: middle; color: white; 
                                            @if ($persenlr <= 75)
                                            background-color: black;
                                            @elseif ($persenlr > 75 && $persenlr <= 90)
                                            background-color: rgb(206, 24, 24); /* Merah */                 
                                            @elseif ($persenlr > 90 && $persenlr <= 100)
                                            background-color: yellow;
                                            @elseif ($persenlr > 100 && $persenlr <= 190)
                                            background-color: green;
                                            @endif">{{ number_format($persenlr, 2) }}%
                                        </td>
                                    </tr>
                                    @elseif ($jenis['jenis_name'] == 'Operating Profit')
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Plan</td>
                                        
                                        <td>{{ number_format($verticallp, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($verticalop, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >Index</td>
                                        <td style="text-align: ; vertical-align: middle;
                                        
                                            vertical-align: middle; color: white; 
                                            @if ($persenop <= 75)
                                            background-color: black;
                                            @elseif ($persenop > 75 && $persenop <= 90)
                                            background-color: rgb(206, 24, 24); /* Merah */
                                                  
                                            @elseif ($persenop > 90 && $persenop <= 100)
                                            background-color: yellow;
                                            @elseif ($persenop > 100 && $persenop <= 190)
                                            background-color: green;
                                            @endif">{{ number_format($persenop, 2) }}%
                                        </td>
                                    </tr>
                                    @elseif ($jenis['jenis_name'] == 'Net Profit')
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Plan</td>
                                        <td>{{ number_format($deviasilb, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($verticalslb, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: ; ">Index</td>
                                        <td style="vertical-align: middle;
                                           vertical-align: middle; color: white; 
                                           @if ($persenlb <= 75)
                                           background-color: black;
                                           @elseif ($persenlb > 75 && $persenlb <= 90)
                                           
                                           background-color: rgb(206, 24, 24); /* Merah */
                                           
                                           @elseif ($persenlb > 90 && $persenlb <= 100)
                                           background-color: yellow;
                                           @elseif ($persenlb > 100 && $persenlb <= 190)
                                           background-color: green;
                                           @endif"
                                           >{{ number_format($persenlb, 2) }}%
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Weight</td>
                                        <td>
                                            %
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                    
                            @endforeach
  
                            
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
                                            {{ number_format($totalRevenuep, 2) }}</td>
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($totalRevenuea, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle;
                                                    vertical-align: middle; color: white; 
                                                    @if ($persenlb <= 75)
                                                    background-color: black;
                                                    @elseif ($persenlb > 75 && $persenlb <= 90)
                                                    background-color: rgb(206, 24, 24); /* Merah */
                                                    
                                                    @elseif ($persenlb > 90 && $persenlb <= 100)
                                                    background-color: yellow;
                                                    @elseif ($persenlb > 100 && $persenlb <= 190)
                                                    background-color: green;
                                                    @endif">                                                    
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            75%
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
                                            <td>{{ number_format($plancogs, 2) }}</td>
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($actualcogs, 2) }}</td>

                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle;
                                                    vertical-align: middle; color: white; 
                                                    @if ($persenlb <= 75)
                                                    background-color: black;
                                                    @elseif ($persenlb > 75 && $persenlb <= 90)
                                                    background-color: rgb(206, 24, 24); /* Merah */
                                                    
                                                    @elseif ($persenlb > 90 && $persenlb <= 100)
                                                    background-color: yellow;
                                                    @elseif ($persenlb > 100 && $persenlb <= 190)
                                                    background-color: green;
                                                    @endif">                                                    
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            75%
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
                                            {{ number_format($plancoe, 2) }}</td>
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($actualcoe, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle;
                                                    vertical-align: middle; color: white; 
                                                    @if ($persenlb <= 75)
                                                    background-color: black;
                                                    @elseif ($persenlb > 75 && $persenlb <= 90)
                                                    background-color: rgb(206, 24, 24); /* Merah */
                                                    
                                                    @elseif ($persenlb > 90 && $persenlb <= 100)
                                                    background-color: yellow;
                                                    @elseif ($persenlb > 100 && $persenlb <= 190)
                                                    background-color: green;
                                                    @endif">                                                    
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            75%
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
                                            {{ number_format($totplanscsr, 2) }}</td>
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Actual</td>
                                        <td>{{ number_format($actualcsr, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Index</td>
                                        <td style="vertical-align: middle;
                                                    vertical-align: middle; color: white; 
                                                    @if ($persenlb <= 75)
                                                    background-color: black;
                                                    @elseif ($persenlb > 75 && $persenlb <= 90)
                                                    background-color: rgb(206, 24, 24); /* Merah */
                                                    
                                                    @elseif ($persenlb > 90 && $persenlb <= 100)
                                                    background-color: yellow;
                                                    @elseif ($persenlb > 100 && $persenlb <= 190)
                                                    background-color: green;
                                                    @endif">                                                    
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2" style="text-align: start; vertical-align: middle;">Weight</td>
                                        <td class="text-end" style=" vertical-align: middle; color: white;">
                                            75%
                                        </td>
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
                                            {{ $results['total']['Index'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" style="background-color: rgb(246, 255, 0); vertical-align: middle; color: white;">
                                            90,1%
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
                                        <td class="text-end" style="background-color: rgb(246, 255, 0); vertical-align: middle; color: white;">
                                            90,1%
                                            
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
                                    <tr >
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
                                                                
                                        ">{{ $results['Ekspor']['Index'] }}% </td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td class="text-end" ">90,1%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              
                <div class="row mt-1" style="border: 2px solid black;">
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
                                            @if ($percentageactual <= 75)
                                            background-color: black; color: white;
                                            @elseif ($percentageactual > 75 && $percentageactual <= 90)
                                            background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($percentageactual > 90 && $percentageactual <= 100)
                                            background-color: yellow; color: black;
                                            @elseif ($percentageactual > 100 && $percentageactual <= 190)
                                            background-color: rgb(0, 255, 72); color: white;
                                            
                                            @elseif ($percentageactual > 190)
                                                background-color: rgb(0, 60, 255); color: white;
                                            @endif
                                            ">{{ number_format($percentageactual, 0, ',', '.') }}%</td>
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
                                                @if ($percentageob <= 75)
                                                background-color: black; color: white;
                                                @elseif ($percentageob > 75 && $percentageob <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($percentageob > 90 && $percentageob <= 100)
                                                background-color: yellow; color: black;
                                                @elseif ($percentageob > 100 && $percentageob <= 190)
                                                background-color: rgb(0, 255, 72); color: white;
                                                @elseif ($percentageob > 190)
                                                background-color: rgb(0, 42, 255); color: white;
                                                @endif
                                            ">{{ number_format($percentageob, 0, ',', '.') }}%
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
                                            @if ($percentageob <= 75)
                                            background-color: black; color: white;
                                            @elseif ($percentageob > 75 && $percentageob <= 90)
                                            background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($percentageob > 90 && $percentageob <= 100)
                                            background-color: yellow; color: black;
                                            @elseif ($percentageob > 100 && $percentageob <= 190)
                                            background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($percentageob > 190)
                                            background-color: rgb(0, 42, 255); color: white;
                                            @endif
                                            ">
                                            {{ number_format($item['indexpa'], 0, ',', '.') }}%</td>
                                        
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
                                            @if ($percentageactual <= 75)
                                            background-color: black; color: white;
                                            @elseif ($percentageactual > 75 && $percentageactual <= 90)
                                            background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($percentageactual > 90 && $percentageactual <= 100)
                                            background-color: yellow; color: black;
                                            @elseif ($percentageactual > 100 && $percentageactual <= 190)
                                            background-color: rgb(0, 255, 72); color: white;
                                            @elseif ($percentageactual > 190)
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
                                <tr><td>Plan</td><td>100%</td></tr>
                                <tr><td>Actual</td><td>{{ number_format($totalpr, 0, ',', '.') }}%</td></tr>
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
                                <tr><td>Weight</td><td class="text-end">10,00%</td></tr>
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
                                <tr><td>Plan</td><td>100%</td></tr>
                                <tr><td>Actual</td><td>{{ number_format($averagePerformance, 0, ',', '.') }}%</td></tr>
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
                                <tr><td>Weight</td><td class="text-end">10,00%</td></tr>
                            </tbody>
                        </table>

                        <!-- Struktur Organisasi (Diturunkan sedikit) -->
                        <div class="mt-3" style="width: 16rem; height: 2rem; background-color: rgb(107, 255, 149); border: 2px solid black; border-radius: 5px;
                            display: flex; justify-content: center; align-items: center;">
                            <a href="{{ route('struktur') }}" target="_blank" style="text-decoration: none; color: inherit;">
                                    Struktur Organisasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
@endif
                        
@endsection
@section('scripts')
@endsection
                        
                        


<style>
    .table{
        background-color: #f8f9fa;
      margin-top: 10px;  
    }
    .table thead {
    font-family: "Poppins", sans-serif;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 120%;
    background-color:rgb(107, 255, 149);
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