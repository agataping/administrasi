@extends('template.main')
@extends('components.style')

@section('title', 'Stock Jetty')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(0, 0, 0, 0.48); color;white">
        <div class="card-body">
            <div class="col-12">
                <!-- <a href="" class="cardcost text-decoration-none"> -->
                <h2 class="text-center mb-4">STOCK JETTY</h2>
                <!-- </a> -->
                <!-- @if(auth()->user()->role === 'admin')    

                <form method="GET" action="{{ route('dashboardstockjt') }}" id="filterForm" class="filter-form">
                <label for="id_company">Select Company:
                    <br>
                        <small><em>To view company data, please select a company from the list.</em></small></label>

                </label>
                    <select list="id_company" name="id_company" id="id_company" onchange="document.getElementById('filterForm').submit();">
                    <option value="">-- Select Company --</option>
                        @foreach ($perusahaans as $company)
                        <option value="{{ $company->id }}" {{ request('id_company') == $company->id ? 'selected' : '' }}>
                            {{ $company->nama }}
                        </option>
                        @endforeach
                    </select>
                </form>
                @endif -->
                <form method="GET" action="{{ route('dashboardstockjt') }}" style="display: flex; justify-content: center; gap: 20px; margin-bottom: 20px;" class="mt-3 filter-date">
                    <div>
                        <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                    </div>

                    <div>
                        <label for="end_date" style="margin-right: 5px; font-weight: bold;">End Date:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                    </div>

                    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                        Filter
                    </button>
                </form>



                <div class="dashboard-container">
                    <!-- Over Burden Section -->
                    <div class="section-card">
                        <h3 class="section-title">Plan & Actual</h3>
                        <div class="metrics-grid">

                            <div class="metric plan">
                                <a href="{{ route('stockjt') }}" class="cardcost text-decoration-none">

                                    <h4>Plan</h4>
                                </a>
                                <div class="percentage-box">
                                    <strong></strong> <span> {{ number_format($planNominal, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="metric actual">
                                <a href="{{ route('stockjt') }}" class="cardcost text-decoration-none">
                                    <h4>Actual</h4>
                                </a>
                                <div class="percentage-box">
                                    <strong></strong> <span>{{ number_format($grandTotal, 2, ',', '.') }}</span>

                                </div>
                            </div>
                            <div class="metric">
                                <h4>Deviasi</h4>
                                <div class="percentage-box">
                                    <strong></strong><span>{{ number_format($deviasi, 2, ',', '.') }}</span>

                                </div>
                            </div>
                            <div class="metric">
                                <h4>Percentage</h4>
                                <div class="percentage-box">
                                    <strong></strong> <span>{{ number_format($percen, 2, ',', '.') }}%</span>

                                </div>
                            </div>
                            <div class="metric">
                                <a href="{{ route('stockjt') }}" class="cardcost text-decoration-none">

                                    <h4>stock</h4>
                                </a>
                                <div class="percentage-box">
                                    <strong></strong> <span> {{ number_format($akumulasiStokMasuk, 2, ',', '.') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>

<style>
    .container-fluid {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-height: 80vh;
        overflow-y: auto;
        overflow-x: auto;
        text-transform: uppercase;

    }

    h2 {
        font-size: 1.8rem;
        color: rgb(255, 255, 255);
        font-weight: bold;
    }

    .dashboard-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .section-card {
        background-color: rgba(32, 31, 31, 0.19);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        flex: 1 1 45%;
        max-width: 500px;
    }

    .section-title {
        font-size: 1.5rem;
        color: rgb(255, 255, 255);
        text-align: center;
        margin-bottom: 15px;
    }

    /* .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        text-align: center;
    }

    .metric {
        background-color: rgba(90, 90, 90, 0.85);
        color: #ffffff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
    } */
    .metrics-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        justify-content: space-between;
    }

    .metric {
        flex: 1 1 calc(33.33% - 16px);
        background-color: rgba(90, 90, 90, 0.85);
        color: #ffffff;
        padding: 16px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .metric.plan,
    .metric.actual {
        flex: 1 1 calc(50% - 16px);
    }

    @media (max-width: 768px) {
        .metric {
            flex: 1 1 100%;
        }
    }



    .metric h4 {
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .metric p {
        font-size: 1.2rem;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .section-card {
            flex: 1 1 100%;
        }

        .metrics-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection
@section('scripts')
@endsection