@extends('template.main')
@extends('components.style')

@section('title', 'KPI')
@section('content')
<style>
    td:nth-child(n+2) {
        text-align: right;
        padding: 5px;
        font-family: Arial, sans-serif;
    }

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
</style>


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="{{ route('reportkpi') }}" class="text-decoration-none" style="color: black;">
                    <h3 class="mb-3">KPI</h3>
                </a> {{-- Error Notification --}}
                @if ($errors->any())
                <div id="notif-error" style="
                position: fixed;
                top: 60px; /* Biar nggak nabrak success */
                right: 20px;
                background-color: #dc3545;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif




                {{-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexPeople') }}" id="filterForm">
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
                <div class="row sidebar p-1 border rounded shadow-sm bg-light ">
                    <h6 class="text-muted text-center ">Please select a year to view the KPI performance.</h6>

                    <form method="GET" action="{{ route('indexkpi') }}">
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
                @if(auth()->user()->role === 'staff' || auth()->user()->role === 'admin')
                <div class="col text-center" style="position: relative; left:;">
                    @if(isset($data['companyName']))
                    <p>{{ $data['companyName']->company_name }}</p>
                    @else
                    <p>Tidak ada perusahaan yang ditemukan.</p>
                    @endif
                </div>
                @endif
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="margin-bottom: 10px; padding: 5px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">



                <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                    <thead style="background-color:rgba(9, 220, 37, 0.75); text-align: center;">
                        <tr>
                            <th rowspan="3" style="vertical-align: middle;">No</th>
                            <th rowspan="3" colspan="2" style="vertical-align: middle;">
                                @if(isset($data['companyName']))
                                <p>{{ $data['companyName']->company_name }}</p>
                                @else
                                <p>Tidak ada perusahaan yang ditemukan.</p>
                                @endif
                            </th>
                            <th colspan="" style="vertical-align: middle;">weight</th>
                            <th rowspan="" style="text-align: center;">plan {{ request('tahun', date('Y')) }}</th>
                            <th colspan="3" style="text-align: center;">YTD {{ request('tahun', date('Y')) }}</th>
                        </tr>
                        <tr style="vertical-align: middle;">
                            <th rowspan="2">w</th>
                            <th rowspan="2">P </th>

                            <th rowspan="">ACTUAL</th>
                            <th colspan="">INDEX</th>
                            <th colspan="">RESULT</th>

                        </tr>
                        <tr>

                            <th>a</th>
                            <th>i=a:p</th>
                            <th>r=i x w</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="10">1</th>
                            <th rowspan="10">Financial Perspective</th>
                            <td style="text-align: start;">Revenue</td>
                            <td>{{ number_format($data['weightrevenue'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenrevenue'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualrevenue'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexrevenue'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultrevenue'] < 0 ? '0,00%' : number_format($data['resultrevenue'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <tr>
                            <td>Cost Of Good Sold</td>
                            <td>{{ number_format($data['weightcogs'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persencogs'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualcogs'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexcogs'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultcogs'] < 0 ? '0,00%' : number_format($data['resultcogs'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <tr>
                            <td>Gross Profit Margin</td>
                            <td>{{ number_format($data['weightprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualprofitmg'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexprofitmg'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultgrosspm'] < 0 ? '0,00%' : number_format($data['resultgrosspm'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Cost of Employee</td>
                            <td>{{ number_format($data['weightcostemploye'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persencostemploye'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['pserenactualcostemploye'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexcostemlpoye'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultemploye'] < 0 ? '0,00%' : number_format($data['resultemploye'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Corporate Social Responsibility</td>
                            <td>{{ number_format($data['weightcsr'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persencsr'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualcsr'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexcsr'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultcsr'] < 0 ? '0,00%' : number_format($data['resultcsr'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <tr>
                            <td>Operating Cost</td>
                            <td>{{ number_format($data['weightopratingcost'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenopratingcost'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualoperatincost'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexoperatingcost'], 2, ',', '.') }}%</td>
                            <td> {{ $data['ressultoperasionalcost'] < 0 ? '0,00%' : number_format($data['ressultoperasionalcost'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Operating Profit Margin</td>
                            <td>{{ number_format($data['weightopratingmg'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenoperatingprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualoperasionalpmg'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexoperasionalpmg'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultoperatingpm'] < 0 ? '0,00%' : number_format($data['resultoperatingpm'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <tr>
                            <td>Net Profit Margin</td>
                            <td>{{ number_format($data['weightnetprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persennetprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualnetprofitmg'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexnetprofitmg'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultnetpm'] < 0 ? '0,00%' : number_format($data['resultnetpm'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <tr>
                            <td>Return On Assets</td>
                            <td>{{ number_format($data['weightasset'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenassetplan'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenactualasset'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexactualasset'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultasset'] < 0 ? '0,00%' : number_format($data['resultasset'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Return On Equity</td>
                            <td>{{ number_format($data['weightmodalhutang'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['persenmodalhutangplan'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['actualreturnonequaity'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexmodalhutangactual'], 2, ',', '.') }}%</td>
                            <td> {{ $data['resultequity'] < 0 ? '0,00%' : number_format($data['resultequity'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        {{-- <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="3"></th>
                            <td>35%</td>
                            <td>{{ number_format($data['ongkosplan'], 2, ',', '.') }}</td>
                        <td>{{ number_format($data['totalopersenactualfinancial'], 2, ',', '.') }}%</td>
                        <td>{{ number_format($data['totalpercenfinancial'], 2, ',', '.') }}%</td>
                        <td>{{ number_format($data['ongkosactual'], 2, ',', '.') }}</td>
                        </tr> --}}
                        <tr>
                            <th rowspan="4">2</th>
                            <th rowspan="4">Customer Perspective</th>
                            <td style="text-align: start;">SHE Index</td>
                            <td>2</td>
                            <td>4</td>
                            <td>1%</td>
                            <td>27,28%</td>
                            <td>0,56%</td>
                        </tr>
                        <tr>
                            <td>Customer Satisfaction Index</td>
                            <td>3</td>
                            <td>3,20</td>
                            <td>3,20%</td>
                            <td>100%</td>
                            <td>3,00%</td>
                        </tr>
                        <tr>
                            <td>Barging Domestik</td>
                            <td>5%</td>
                            <td>{{ number_format($data['totalplandomestik'], 2) }}</td>
                            <td>{{ number_format($data['totalactualdomestik'], 2) }}</td>
                            <td>{{ number_format($data['indexdomestik'], 2) }}%</td>
                            <td> {{ $data['resultdomestik'] < 0 ? '0,00%' : number_format($data['resultdomestik'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Barging Ekspor</td>
                            <td>5%</td>
                            <td>{{ number_format($data['totalplanekspor'], 2) }}</td>
                            <td>{{ number_format($data['totalactualekspor'], 2) }}</td>
                            <td>{{ number_format($data['indexekspor'], 2) }}%</td>
                            <td> {{ $data['resultekspor'] < 0 ? '0,00%' : number_format($data['resultekspor'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <!-- <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="3"></th>
                            <td>15%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> -->
                        <tr>
                            <th rowspan="9">3</th>
                            <th rowspan="9">Internal Process Perspective</th>
                            <td style="text-align: start;">Fleet Productivity (Coal)</td>
                            <td>2%</td>
                            <td>{{ number_format($data['totalPlancoal'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['totalActualcoal'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['indexcoalgetting'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultcoal'] < 0 ? '0,00%' : number_format($data['resultcoal'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Fleet Productivity (OB)</td>
                            <td>2%</td>
                            <td>{{ number_format($data['totalPlanob'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['totalActualob'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['indexoverburder'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultob'] < 0 ? '0,00%' : number_format($data['resultob'], 2, ',', '.') . '%' }}</td>

                        </tr>
                        <tr>
                            <td>Effective Working Hour</td>
                            <td>4%</td>
                            <td>{{ number_format($data['totalplanewh'], 2) }}</td>
                            <td>{{ number_format($data['totalactualewh'], 2) }}</td>
                            <td>{{ number_format($data['indexoverburder'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultewh'] < 0 ? '0,00%' : number_format($data['resultewh'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Utilization of Availability</td>
                            <td>4%</td>
                            <td>{{ number_format($data['totalactualunithauler'], 2) }}</td>
                            <td>{{ number_format($data['totalactualuaunithauler'], 2) }}</td>
                            <td>{{ number_format($data['indexoverburder'], 2, ',', '.') }} %</td>
                            <td>{{ $data['resultua'] < 0 ? '0,00%' : number_format($data['resultua'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Physical Availability (Total)</td>
                            <td>6%</td>
                            <td>{{ number_format($data['averagePasPlan'], 0, ',', '.') }}%</td>
                            <td>{{ number_format($data['averagePasActual'], 0, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexoverburder'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultpa'] < 0 ? '0,00%' : number_format($data['resultpa'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Fuel Ratio</td>
                            <td>3%</td>
                            <td>{{ number_format($data['totalplanfuel'], 2) }}%</td>
                            <td>{{ number_format($data['totalactualfuel'], 2) }}%</td>
                            <td>{{ number_format($data['indexoverburder'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultfuel'] < 0 ? '0,00%' : number_format($data['resultfuel'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Coal Mine (MT)</td>
                            <td>3%</td>
                            <td>{{ number_format($data['totalPlancoal'], 0, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalActualcoal'], 0, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexcoalgetting'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultcoalmt'] < 0 ? '0,00%' : number_format($data['resultcoalmt'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Overburden (BCM)</td>
                            <td>3%</td>
                            <td>{{ number_format($data['totalPlanob'], 0, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalActualob'], 0, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexoverburder'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultobbcm'] < 0 ? '0,00%' : number_format($data['resultobbcm'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Mining Readiness</td>
                            <td>3%</td>
                            <td>100%</td>
                            <td>{{ number_format($data['finalAverage'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexcoalgetting'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalindexlearning'], 2, ',', '.') }}%</td>
                        </tr>
                        {{-- <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="3"></th>
                            <td>30%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> --}}
                        <tr>
                            <th rowspan="2">4</th>
                            <th rowspan="2">Learning & Growth Perspective</th>
                            <td style="text-align: start;">People Readiness</td>
                            <td>10%</td>
                            <td>100%</td>
                            <td>{{ number_format($data['totalpr'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexpeople'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultpeople'] < 0 ? '0,00%' : number_format($data['resultpeople'], 2, ',', '.') . '%' }}</td>
                        </tr>
                        <tr>
                            <td>Infrastructure Readiness</td>
                            <td>10%</td>
                            <td>100%</td>
                            <td>{{ number_format($data['averagePerformance'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['indexinfra'], 2, ',', '.') }}%</td>
                            <td>{{ $data['resultlearning'] < 0 ? '0,00%' : number_format($data['resultlearning'], 2, ',', '.') . '%' }}</td>
                        </tr>

                        <!-- <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="3"></th>
                            <td>20%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> -->


                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Total</th>
                            <th colspan="" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Total</th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"> 100%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['totalresult'], 2) }}%</td>

                        </tr>
                        <tr>
                            <th colspan="3" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Financial Perspective</th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"> 35%</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['totalindexfinancial'], 2) }}%</td>
                            <td>{{ number_format($data['totalresultfinancial'], 2) }}%</td>
                        </tr>
                        <tr>

                            <th colspan="3" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Customer Perspective </th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">15%</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['totalresultcp'], 2) }}%</td>
                            <td>{{ number_format($data['totalresultcostumer'], 2) }}%</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Internal Process Perspective</th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">30%</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['resultIPP'], 2) }}%</td>
                            <td>{{ number_format($data['totalresultIPP'], 2) }}%</td>

                        </tr>
                        <tr>
                            <th colspan="3" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">L&G Perspective </th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">20%</td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['totalindexlearning'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['resultinfrastruktur'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"></td>
                            <td colspan="" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">100%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($data['totalresultcompany'], 2, ',', '.') }}%</td>
                        </tr>

                    </tfoot>


                </table>


                <div class="vard">
                    <ul>
                        <li><a href="/reportkpi">DASHBOARD</a></li>

                        <li>
                            <a href="/indexkpi">
                                KPI
                                @if(auth()->user()->role === 'staff' || auth()->user()->role === 'admin')
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









@endsection
@section('scripts')

@endsection