@extends('template.main')
@extends('components.style')

@section('title', 'Measurement')
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
                    <h3 class="mb-3">Measurement</h3>
                </a> {{-- Error Notification --}}
                {{-- Error Notification --}}
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

                    <form method="GET" action="{{ route('indexpengkuran') }}">
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
                            <th rowspan="3" style="vertical-align: middle;">Prespective</th>
                            <th rowspan="3" colspan="2" style="vertical-align: middle;">Object Prespective</th>
                            <th colspan="3" style="vertical-align: middle;">Planning</th>
                            <th colspan="2" rowspan="" style="text-align: center;">Actual </th>
                        </tr>
                        <tr>
                            <th>YTD {{ request('tahun', date('Y')) }}</th>
                            <th colspan="2">Percent Weight</th>

                            <th rowspan="">YTD {{ request('tahun', date('Y')) }}</th>
                            <th colspan="">Percent</th>

                        </tr>
                        <tr>

                            <th>Cost </th>
                            <th>%</th>
                            <th>weight</th>
                            <th>Cost </th>
                            <th>%</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="10">1</th>
                            <th rowspan="10">Financial Perspective</th>
                            <td style="text-align: start;" colspan="2">Revenue</td>
                            <td>{{ number_format($data['totalRevenuep'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenrevenue'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightrevenue'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalRevenuea'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualrevenue'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Cost Of Good Sold</td>
                            <td>{{ number_format($data['totalplancogas'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persencogs'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightcogs'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalactualcogas'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualcogs'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Gross Profit Margin</td>
                            <td>{{ number_format($data['totalplanlr'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalactuallr'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualprofitmg'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Cost of Employee</td>
                            <td>{{ number_format($data['totplansalary'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persencostemploye'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightcostemploye'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totactualsalary'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['pserenactualcostemploye'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Corporate Social Responsibility</td>
                            <td>{{ number_format($data['totplanscsr'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persencsr'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightcsr'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totactualscsr'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualcsr'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Operating Cost</td>
                            <td>{{ number_format($data['planoperasional'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenopratingcost'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightopratingcost'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['actualoperasional'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualoperatincost'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Operating Profit Margin</td>
                            <td>{{ number_format($data['totalplanlp'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenoperatingprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightopratingmg'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalactualOp'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualoperasionalpmg'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Net Profit Margin</td>
                            <td>{{ number_format($data['totalnetprofitplan'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persennetprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightnetprofitmargin'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalactualnetprofit'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenactualnetprofitmg'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Return On Assets</td>
                            <td>{{ number_format($data['totalplanasset'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenassetplan'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightasset'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalactualasset'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['actualreturnonasset'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <td colspan="2">Return On Equity</td>
                            <td>{{ number_format($data['totalplanequity'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['persenmodalhutangplan'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['weightmodalhutang'], 2, ',', '.') }}%</td>
                            <td>{{ number_format($data['totalactualequity'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['actualreturnonequaity'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="4"></th>
                            <td>{{ number_format($data['ongkosplan'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['totalpercenfinancial'], 2, ',', '.') }}%</td>
                            <td>35%</td>
                            <td>{{ number_format($data['ongkosactual'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['totalopersenactualfinancial'], 2, ',', '.') }}%</td>
                        </tr>
                        <tr>
                            <th rowspan="4">2</th>
                            <th rowspan="4">Customer Perspective</th>
                            <td style="text-align: start;" colspan="2">SHE Index</td>
                            <td></td>
                            <td></td>
                            <td>2%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Customer Satisfaction Index</td>
                            <td></td>
                            <td></td>
                            <td>3%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Barging Domestik</td>
                            <td></td>
                            <td></td>
                            <td>5%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Barging Ekspor</td>
                            <td></td>
                            <td></td>
                            <td>5%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="4"></th>
                            <td></td>
                            <td></td>
                            <td>15%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th rowspan="9">3</th>
                            <th rowspan="9">Internal Process Perspective</th>
                            <td style="text-align: start;" colspan="2">Fleet Productivity (Coal)</td>
                            <td></td>
                            <td></td>
                            <td>2%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Fleet Productivity (OB)</td>
                            <td></td>
                            <td></td>
                            <td>2%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Effective Working Hour</td>
                            <td></td>
                            <td></td>
                            <td>4%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Utilization of Availability</td>
                            <td></td>
                            <td></td>
                            <td>4%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Physical Availability (Total)</td>
                            <td></td>
                            <td></td>
                            <td>6%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Fuel Ratio</td>
                            <td></td>
                            <td></td>
                            <td>3%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Coal Mine (MT)</td>
                            <td></td>
                            <td></td>
                            <td>3%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Overburden (BCM)</td>
                            <td></td>
                            <td></td>
                            <td>3%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Mining Readiness</td>
                            <td></td>
                            <td></td>
                            <td>3%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="4"></th>
                            <td></td>
                            <td></td>
                            <td>30%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th rowspan="2">4</th>
                            <th rowspan="2">Learning & Growth Perspective</th>
                            <td style="text-align: start;" colspan="2">People Readiness</td>
                            <td></td>
                            <td></td>
                            <td>10%</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Infrastructure Readiness</td>
                            <td></td>
                            <td></td>
                            <td>10%</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr style="vertical-align: middle; background-color:rgb(176, 175, 175);  text-align: end;">
                            <th colspan="4"></th>
                            <td></td>
                            <td></td>
                            <td>20%</td>
                            <td></td>
                            <td></td>
                        </tr>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Financial Perspective</th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"> 35%</td>
                        </tr>
                        <tr>

                            <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Customer Perspective </th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">15%</td>
                        </tr>
                        <tr>
                            <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">Internal Process Perspective</th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">30%</td>

                        </tr>
                        <tr>
                            <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244);  ">L&G Perspective </th>
                            <td style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">20%</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;"></td>
                            <td colspan="" style="vertical-align: middle; background-color:rgb(244, 244, 244);  text-align: end;">100%</td>
                        </tr>

                    </tfoot>


                </table>

                <div class="vard">
                    <ul>
                        <li><a href="/reportkpi">DASHBOARD</a></li>

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









@endsection
@section('scripts')

@endsection